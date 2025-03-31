<?php

declare(strict_types=1);

namespace Modules\Reporting\Filament\Resources\ReportResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Reporting\Filament\Resources\ReportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Reporting\Services\ReportGenerator;
use Illuminate\Database\Eloquent\Model;

class EditReport extends XotBaseEditRecord
{
    protected static string $resource = ReportResource::class;

    /**
     * Definisce le azioni disponibili nella pagina di modifica.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('regenerate')
                ->label('Rigenera Report')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function () {
                    // Ottiene il record corrente
                    $record = $this->getRecord();
                    
                    // Prepara i parametri per la rigenerazione
                    $parameters = $record->parameters ?? [];
                    $parameters['name'] = $record->name;
                    $parameters['description'] = $record->description;
                    $parameters['period_start'] = $record->period_start;
                    $parameters['period_end'] = $record->period_end;
                    
                    // Aggiorna lo stato del report
                    $record->update(['status' => 'pending']);
                    
                    // Esecuzione asincrona dell'azione con Spatie QueueableAction
                    app(\Modules\Reporting\Actions\GenerateReportAction::class)
                        ->onQueue('reports')
                        ->execute($record, $parameters);
                    
                    $this->notify('success', 'Rigenerazione del report avviata in background');
                    $this->redirect(static::getResource()::getUrl('edit', ['record' => $record]));
                }),
        ];
    }
}
