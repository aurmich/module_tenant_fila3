<?php

declare(strict_types=1);

namespace Modules\Reporting\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Reporting\Models\Report;
use Modules\Reporting\Models\ReportData;
use Modules\Dental\Models\Appointment;
use Modules\Patient\Models\Patient;
use Illuminate\Support\Facades\DB;

/**
 * Servizio per la generazione di report statistici.
 */
class ReportGenerator
{
    /**
     * Genera un report in base al tipo e ai parametri specificati.
     *
     * @param string $reportType
     * @param array<string, mixed> $parameters
     * @param int $userId
     * @param int $tenantId
     * 
     * @return Report
     */
    public function generate(string $reportType, array $parameters, int $userId, int $tenantId): Report
    {
        // Crea un nuovo record di report
        $report = new Report();
        $report->name = $parameters['name'] ?? $this->generateReportName($reportType);
        $report->description = $parameters['description'] ?? '';
        $report->type = $reportType;
        $report->period_start = $parameters['period_start'] ?? Carbon::now()->startOfMonth();
        $report->period_end = $parameters['period_end'] ?? Carbon::now();
        $report->status = 'processing';
        $report->parameters = $parameters;
        $report->created_by = $userId;
        $report->tenant_id = $tenantId;
        $report->save();

        try {
            // Genera i dati del report in base al tipo
            match ($reportType) {
                'paziente_demografico' => $this->generatePatientDemographicReport($report),
                'visite_per_periodo' => $this->generateAppointmentsByPeriodReport($report),
                'attivita_odontoiatri' => $this->generateDentistActivityReport($report),
                'isee_analisi' => $this->generateIseeAnalysisReport($report),
                default => throw new \InvalidArgumentException("Tipo di report non supportato: {$reportType}"),
            };

            // Aggiorna lo stato del report a completato
            $report->status = 'completed';
            $report->last_generated_at = Carbon::now();
            $report->save();

            return $report;
        } catch (\Exception $e) {
            // In caso di errore, aggiorna lo stato del report
            $report->status = 'error';
            $report->save();

            // Crea un record di dati per il report con l'errore
            ReportData::create([
                'report_id' => $report->id,
                'key' => 'error',
                'value' => $e->getMessage(),
                'data_type' => 'string',
                'description' => 'Errore durante la generazione del report',
                'group' => 'errors',
            ]);

            throw $e;
        }
    }

    /**
     * Genera un nome per il report in base al tipo.
     *
     * @param string $reportType
     * @return string
     */
    private function generateReportName(string $reportType): string
    {
        $date = Carbon::now()->format('d/m/Y');
        
        return match ($reportType) {
            'paziente_demografico' => "Analisi demografica pazienti - {$date}",
            'visite_per_periodo' => "Statistiche visite per periodo - {$date}",
            'attivita_odontoiatri' => "Analisi attività odontoiatri - {$date}",
            'isee_analisi' => "Analisi ISEE pazienti - {$date}",
            default => "Report {$reportType} - {$date}",
        };
    }

    /**
     * Genera report demografico dei pazienti.
     *
     * @param Report $report
     * @return void
     */
    private function generatePatientDemographicReport(Report $report): void
    {
        // Range di date per il report
        $startDate = $report->period_start;
        $endDate = $report->period_end;

        // Conteggio totale pazienti
        $totalPatients = Patient::where('tenant_id', $report->tenant_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'total_patients',
            'value' => $totalPatients,
            'data_type' => 'integer',
            'description' => 'Numero totale di pazienti registrati',
            'group' => 'totals',
            'order' => 1,
        ]);

        // Distribuzione per età
        $ageGroups = [
            '18-25' => [18, 25],
            '26-35' => [26, 35], 
            '36-45' => [36, 45],
            '46+' => [46, 200]
        ];

        $ageDistribution = [];
        foreach ($ageGroups as $groupName => $range) {
            $count = Patient::where('tenant_id', $report->tenant_id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN ? AND ?', $range)
                ->count();
                
            $ageDistribution[$groupName] = $count;
        }

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'age_distribution',
            'value' => json_encode($ageDistribution),
            'data_type' => 'json',
            'description' => 'Distribuzione dei pazienti per fascia di età',
            'group' => 'demographics',
            'order' => 2,
        ]);

        // Altri dati demografici come la provenienza
        $this->addGeographicDistribution($report);
    }

    /**
     * Genera report delle visite per periodo.
     *
     * @param Report $report
     * @return void
     */
    private function generateAppointmentsByPeriodReport(Report $report): void
    {
        // Range di date per il report
        $startDate = $report->period_start;
        $endDate = $report->period_end;

        // Conteggio totale appuntamenti
        $totalAppointments = Appointment::where('tenant_id', $report->tenant_id)
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->count();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'total_appointments',
            'value' => $totalAppointments,
            'data_type' => 'integer',
            'description' => 'Numero totale di appuntamenti',
            'group' => 'totals',
            'order' => 1,
        ]);

        // Distribuzione appuntamenti per mese
        $appointmentsByMonth = DB::table('appointments')
            ->select(DB::raw('MONTH(appointment_date) as month, COUNT(*) as count'))
            ->where('tenant_id', $report->tenant_id)
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->groupBy(DB::raw('MONTH(appointment_date)'))
            ->orderBy(DB::raw('MONTH(appointment_date)'))
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'appointments_by_month',
            'value' => json_encode($appointmentsByMonth),
            'data_type' => 'json',
            'description' => 'Distribuzione degli appuntamenti per mese',
            'group' => 'time_distribution',
            'order' => 2,
        ]);

        // Stato degli appuntamenti
        $appointmentStatus = DB::table('appointments')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->where('tenant_id', $report->tenant_id)
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'appointment_status',
            'value' => json_encode($appointmentStatus),
            'data_type' => 'json',
            'description' => 'Distribuzione degli appuntamenti per stato',
            'group' => 'status',
            'order' => 3,
        ]);
    }

    /**
     * Genera report sull'attività degli odontoiatri.
     *
     * @param Report $report
     * @return void
     */
    private function generateDentistActivityReport(Report $report): void
    {
        // Range di date per il report
        $startDate = $report->period_start;
        $endDate = $report->period_end;

        // Appuntamenti per odontoiatra
        $appointmentsByDentist = DB::table('appointments')
            ->join('dentists', 'appointments.dentist_id', '=', 'dentists.id')
            ->select('dentists.name', DB::raw('COUNT(*) as count'))
            ->where('appointments.tenant_id', $report->tenant_id)
            ->whereBetween('appointments.appointment_date', [$startDate, $endDate])
            ->groupBy('dentists.id', 'dentists.name')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'name')
            ->toArray();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'appointments_by_dentist',
            'value' => json_encode($appointmentsByDentist),
            'data_type' => 'json',
            'description' => 'Numero di appuntamenti per odontoiatra',
            'group' => 'dentist_activity',
            'order' => 1,
        ]);

        // Tasso di completamento appuntamenti per odontoiatra
        $completionRateByDentist = DB::table('appointments')
            ->join('dentists', 'appointments.dentist_id', '=', 'dentists.id')
            ->select(
                'dentists.name',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN appointments.status = "completed" THEN 1 ELSE 0 END) as completed')
            )
            ->where('appointments.tenant_id', $report->tenant_id)
            ->whereBetween('appointments.appointment_date', [$startDate, $endDate])
            ->groupBy('dentists.id', 'dentists.name')
            ->having('total', '>', 0)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'rate' => round(($item->completed / $item->total) * 100, 2)
                ];
            })
            ->pluck('rate', 'name')
            ->toArray();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'completion_rate_by_dentist',
            'value' => json_encode($completionRateByDentist),
            'data_type' => 'json',
            'description' => 'Tasso di completamento appuntamenti per odontoiatra (%)',
            'group' => 'dentist_activity',
            'order' => 2,
        ]);
    }

    /**
     * Genera report sull'analisi ISEE dei pazienti.
     *
     * @param Report $report
     * @return void
     */
    private function generateIseeAnalysisReport(Report $report): void
    {
        // Range di date per il report
        $startDate = $report->period_start;
        $endDate = $report->period_end;

        // Distribuzione ISEE per fasce
        $iseeBrackets = [
            '0-5000' => [0, 5000],
            '5001-10000' => [5001, 10000],
            '10001-15000' => [10001, 15000],
            '15001-20000' => [15001, 20000]
        ];

        $iseeDistribution = [];
        foreach ($iseeBrackets as $bracketName => $range) {
            $count = Patient::where('tenant_id', $report->tenant_id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereBetween('isee_value', $range)
                ->count();
                
            $iseeDistribution[$bracketName] = $count;
        }

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'isee_distribution',
            'value' => json_encode($iseeDistribution),
            'data_type' => 'json',
            'description' => 'Distribuzione dei pazienti per fascia ISEE',
            'group' => 'isee_analysis',
            'order' => 1,
        ]);

        // Valore ISEE medio
        $avgIsee = Patient::where('tenant_id', $report->tenant_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('isee_value')
            ->avg('isee_value');

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'average_isee',
            'value' => $avgIsee ?? 0,
            'data_type' => 'float',
            'description' => 'Valore ISEE medio dei pazienti',
            'group' => 'isee_analysis',
            'order' => 2,
        ]);

        // Conteggio pazienti per gruppo geografico e fascia ISEE
        $this->addGeographicIseeCorrelation($report);
    }

    /**
     * Aggiunge dati sulla distribuzione geografica dei pazienti al report.
     *
     * @param Report $report
     * @return void
     */
    private function addGeographicDistribution(Report $report): void
    {
        $startDate = $report->period_start;
        $endDate = $report->period_end;

        // Distribuzione per area geografica (città/provincia)
        $geographicDistribution = DB::table('patients')
            ->select('city', DB::raw('COUNT(*) as count'))
            ->where('tenant_id', $report->tenant_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10) // Limitiamo alle top 10 città
            ->get()
            ->pluck('count', 'city')
            ->toArray();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'geographic_distribution',
            'value' => json_encode($geographicDistribution),
            'data_type' => 'json',
            'description' => 'Distribuzione geografica dei pazienti',
            'group' => 'demographics',
            'order' => 3,
        ]);
    }

    /**
     * Aggiunge dati sulla correlazione tra area geografica e ISEE al report.
     *
     * @param Report $report
     * @return void
     */
    private function addGeographicIseeCorrelation(Report $report): void
    {
        $startDate = $report->period_start;
        $endDate = $report->period_end;

        // Correlazione tra area geografica e fasce ISEE
        $geoIseeCorrelation = DB::table('patients')
            ->select('city', DB::raw('AVG(isee_value) as avg_isee'))
            ->where('tenant_id', $report->tenant_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('isee_value')
            ->groupBy('city')
            ->having(DB::raw('COUNT(*)'), '>=', 5) // Solo città con almeno 5 pazienti
            ->orderBy('avg_isee')
            ->get()
            ->pluck('avg_isee', 'city')
            ->toArray();

        ReportData::create([
            'report_id' => $report->id,
            'key' => 'geo_isee_correlation',
            'value' => json_encode($geoIseeCorrelation),
            'data_type' => 'json',
            'description' => 'Correlazione tra area geografica e ISEE medio',
            'group' => 'isee_analysis',
            'order' => 3,
        ]);
    }
}
