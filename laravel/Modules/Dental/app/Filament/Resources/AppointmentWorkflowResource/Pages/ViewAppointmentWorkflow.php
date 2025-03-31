<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Resources\AppointmentWorkflowResource\Pages;

use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Modules\Dental\Filament\Resources\AppointmentWorkflowResource;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewAppointmentWorkflow extends XotBaseViewRecord
{
    protected static string $resource = AppointmentWorkflowResource::class;

    /**
     * Configura l'infolist per visualizzare i dettagli del workflow.
     */
    public function infolist(Infolist $infolist): void
    {
        $infolist
            ->schema([
                Section::make('Informazioni Workflow')
                    ->schema([
                        TextEntry::make('patient.full_name')
                            ->label('Paziente'),
                            
                        TextEntry::make('status')
                            ->label('Stato')
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                AppointmentWorkflow::STATUS_DRAFT => 'Bozza',
                                AppointmentWorkflow::STATUS_PATIENT_INFO => 'Informazioni Paziente Completate',
                                AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'Dentista Selezionato',
                                AppointmentWorkflow::STATUS_DATE_SELECTED => 'Data Selezionata',
                                AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'Trattamento Definito',
                                AppointmentWorkflow::STATUS_CONFIRMED => 'Confermato',
                                AppointmentWorkflow::STATUS_CANCELLED => 'Cancellato',
                                default => $state,
                            })
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                AppointmentWorkflow::STATUS_DRAFT => 'gray',
                                AppointmentWorkflow::STATUS_PATIENT_INFO => 'info',
                                AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'warning',
                                AppointmentWorkflow::STATUS_DATE_SELECTED => 'warning',
                                AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'warning',
                                AppointmentWorkflow::STATUS_CONFIRMED => 'success',
                                AppointmentWorkflow::STATUS_CANCELLED => 'danger',
                                default => 'gray',
                            }),
                            
                        TextEntry::make('current_step')
                            ->label('Passo Corrente')
                            ->formatStateUsing(fn (string $state): string => AppointmentWorkflow::getSteps()[$state] ?? $state),
                            
                        TextEntry::make('started_at')
                            ->label('Data Inizio')
                            ->dateTime(),
                            
                        TextEntry::make('last_interaction_at')
                            ->label('Ultima Interazione')
                            ->dateTime(),
                            
                        TextEntry::make('completed_at')
                            ->label('Data Completamento')
                            ->dateTime(),
                    ])
                    ->columns(2),
                
                Section::make('Passi del Workflow')
                    ->schema([
                        ViewEntry::make('workflow_steps')
                            ->label('')
                            ->columnSpanFull()
                            ->view('dental::appointment-workflow.workflow-steps-view'),
                    ]),
                
                Section::make('Dati del Workflow')
                    ->schema([
                        ViewEntry::make('step_data')
                            ->label('')
                            ->columnSpanFull()
                            ->view('dental::appointment-workflow.step-data-view'),
                    ]),
            ]);
    }

    /**
     * Definisce le azioni nell'header della pagina.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('continue')
                ->label('Continua Workflow')
                ->icon('heroicon-o-play')
                ->color('primary')
                ->url(fn (AppointmentWorkflow $record): string => static::getResource()::getUrl('workflow', ['record' => $record->id]))
                ->visible(fn (AppointmentWorkflow $record): bool => !$record->isCompleted() && !$record->isCancelled()),
                
            Actions\Action::make('cancel')
                ->label('Cancella Workflow')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (AppointmentWorkflow $record): void {
                    $record->status = AppointmentWorkflow::STATUS_CANCELLED;
                    $record->save();
                    
                    activity()
                        ->performedOn($record)
                        ->log('Workflow prenotazione cancellato');
                    
                    $this->redirect(static::getResource()::getUrl('index'));
                })
                ->visible(fn (AppointmentWorkflow $record): bool => !$record->isCompleted() && !$record->isCancelled()),
                
            Actions\EditAction::make(),
        ];
    }
}
