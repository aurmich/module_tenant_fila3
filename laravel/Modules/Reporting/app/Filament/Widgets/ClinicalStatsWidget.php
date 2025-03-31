<?php

declare(strict_types=1);

namespace Modules\Reporting\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Modules\Dental\Models\Appointment;
use Modules\Patient\Models\Patient;
use Carbon\Carbon;

class ClinicalStatsWidget extends Widget
{
    protected static ?int $sort = 2;
    
    protected static string $view = 'reporting::widgets.clinical-stats-widget';
    
    /**
     * Ottiene le statistiche cliniche per il widget.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $tenantId = tenant()->id;
        $today = Carbon::now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        
        // Statistiche pazienti
        $totalPatients = Patient::where('tenant_id', $tenantId)->count();
        $newPatientsThisMonth = Patient::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        
        // Statistiche appuntamenti
        $totalAppointments = Appointment::where('tenant_id', $tenantId)->count();
        $pendingAppointments = Appointment::where('tenant_id', $tenantId)
            ->where('status', 'pending')
            ->count();
        $completedAppointments = Appointment::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->count();
        
        // Appuntamenti per questo mese
        $appointmentsThisMonth = Appointment::where('tenant_id', $tenantId)
            ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
            ->count();
        
        // Statistiche ISEE
        $averageIsee = Patient::where('tenant_id', $tenantId)
            ->whereNotNull('isee_value')
            ->avg('isee_value');
        
        $patientsByIseeRange = $this->getPatientsByIseeRange($tenantId);
        
        // Geolocalizzazione pazienti
        $patientsByCity = $this->getTopPatientsByCity($tenantId);
        
        // Tasso di completamento appuntamenti
        $completionRate = $totalAppointments > 0 
            ? round(($completedAppointments / $totalAppointments) * 100, 1) 
            : 0;
        
        // Distribuzioni per mese
        $appointmentsByMonth = $this->getAppointmentsByMonth($tenantId);
        $patientsByMonth = $this->getPatientsByMonth($tenantId);
        
        return [
            'totalPatients' => $totalPatients,
            'newPatientsThisMonth' => $newPatientsThisMonth,
            'totalAppointments' => $totalAppointments,
            'pendingAppointments' => $pendingAppointments,
            'completedAppointments' => $completedAppointments,
            'appointmentsThisMonth' => $appointmentsThisMonth,
            'averageIsee' => $averageIsee,
            'patientsByIseeRange' => $patientsByIseeRange,
            'patientsByCity' => $patientsByCity,
            'completionRate' => $completionRate,
            'appointmentsByMonth' => $appointmentsByMonth,
            'patientsByMonth' => $patientsByMonth,
        ];
    }
    
    /**
     * Ottiene la distribuzione dei pazienti per fascia ISEE.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getPatientsByIseeRange(int $tenantId): array
    {
        $ranges = [
            '0-5000' => [0, 5000],
            '5001-10000' => [5001, 10000],
            '10001-15000' => [10001, 15000],
            '15001-20000' => [15001, 20000],
        ];
        
        $result = [];
        foreach ($ranges as $label => $range) {
            $result[$label] = Patient::where('tenant_id', $tenantId)
                ->whereBetween('isee_value', $range)
                ->count();
        }
        
        return $result;
    }
    
    /**
     * Ottiene le prime 5 città con più pazienti.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getTopPatientsByCity(int $tenantId): array
    {
        return Patient::where('tenant_id', $tenantId)
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->pluck('total', 'city')
            ->toArray();
    }
    
    /**
     * Ottiene la distribuzione degli appuntamenti per mese nell'anno corrente.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getAppointmentsByMonth(int $tenantId): array
    {
        $year = date('Y');
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $startDate = "{$year}-{$month}-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $count = Appointment::where('tenant_id', $tenantId)
                ->whereBetween('appointment_date', [$startDate, $endDate])
                ->count();
            
            $monthName = Carbon::createFromDate($year, $i, 1)->locale('it')->monthName;
            $months[$monthName] = $count;
        }
        
        return $months;
    }
    
    /**
     * Ottiene la distribuzione dei nuovi pazienti per mese nell'anno corrente.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getPatientsByMonth(int $tenantId): array
    {
        $year = date('Y');
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $startDate = "{$year}-{$month}-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $count = Patient::where('tenant_id', $tenantId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            
            $monthName = Carbon::createFromDate($year, $i, 1)->locale('it')->monthName;
            $months[$monthName] = $count;
        }
        
        return $months;
    }
}
