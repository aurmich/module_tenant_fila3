<?php

declare(strict_types=1);

namespace Modules\Reporting\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Reporting\Filament\Resources\ReportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Reporting\Services\ReportGenerator;
use Illuminate\Database\Eloquent\Model;

class CreateReport extends XotBaseCreateRecord
{
    protected static string $resource = ReportResource::class;

    /**
     * Sovrascrive il metodo handleRecordCreation per integrare la generazione del report.
     *
     * @param array<string, mixed> $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        // Crea il record del report con status 'pending'
        $report = new \Modules\Reporting\Models\Report();
        $report->name = $data['name'];
        $report->description = $data['description'] ?? '';
        $report->type = $data['type'];
        $report->period_start = $data['period_start'];
        $report->period_end = $data['period_end'];
        $report->status = 'pending';
        $report->parameters = $data;
        $report->created_by = auth()->id();
        $report->tenant_id = tenant()->id;
        $report->save();
        
        // Esecuzione asincrona dell'azione con Spatie QueueableAction
        app(\Modules\Reporting\Actions\GenerateReportAction::class)
            ->onQueue('reports')
            ->execute($report, $data);
        
        // Notifica l'utente
        $this->notify('success', 'Report creato con successo. La generazione è stata avviata in background.');
        
        return $report;
    }
}
