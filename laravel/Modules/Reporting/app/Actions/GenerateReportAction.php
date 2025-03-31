<?php

declare(strict_types=1);

namespace Modules\Reporting\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Reporting\Models\Report;
use Modules\Reporting\Services\ReportGenerator;
use Spatie\QueueableAction\QueueableAction;

class GenerateReportAction
{
    use QueueableAction;

    /**
     * Numero di tentativi massimi.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * Timeout dell'azione in secondi.
     *
     * @var int
     */
    public int $timeout = 600; // 10 minuti

    /**
     * Crea una nuova istanza dell'azione.
     */
    public function __construct(
        private readonly ReportGenerator $generator
    ) {
    }

    /**
     * Esegue l'azione di generazione del report.
     *
     * @param Report $report
     * @param array<string, mixed> $parameters
     */
    public function execute(Report $report, array $parameters = []): void
    {
        try {
            // Aggiorna lo stato del report
            $report->update(['status' => 'processing']);

            // Elimina dati precedenti se presenti
            $report->reportData()->delete();

            // Ottieni i dati necessari
            $reportType = $report->type;
            $userId = $report->created_by;
            $tenantId = $report->tenant_id;

            // Unisci i parametri dal database con quelli forniti all'azione
            $mergedParameters = array_merge($report->parameters ?? [], $parameters);
            $mergedParameters['name'] = $report->name;
            $mergedParameters['description'] = $report->description;
            $mergedParameters['period_start'] = $report->period_start;
            $mergedParameters['period_end'] = $report->period_end;

            // Genera il report
            $this->generator->generate($reportType, $mergedParameters, $userId, $tenantId);

            // Aggiorna lo stato del report a completato
            $report->update([
                'status' => 'completed',
                'last_generated_at' => now()
            ]);

            Log::info('Report generato con successo', [
                'report_id' => $report->id,
                'report_type' => $reportType
            ]);
        } catch (\Exception $e) {
            Log::error('Errore nella generazione del report', [
                'report_id' => $report->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Aggiorna lo stato del report a errore
            $report->update(['status' => 'error']);

            throw $e;
        }
    }
}
