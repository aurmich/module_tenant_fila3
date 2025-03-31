<?php

declare(strict_types=1);

namespace Modules\Dental\Filament\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextEntry;
use Filament\Support\Enums\IconPosition;
use Modules\Dental\Models\AppointmentWorkflow;

class AppointmentWorkflowProgress extends Component
{
    /**
     * Crea un nuovo componente per la visualizzazione del progresso del workflow.
     *
     * @param AppointmentWorkflow $workflow Il workflow di appuntamento
     * @param int $currentStepIndex L'indice del passo corrente
     * @param array<string, string> $steps L'elenco dei passi disponibili
     */
    public static function make(
        AppointmentWorkflow $workflow,
        int $currentStepIndex,
        array $steps
    ): Grid {
        // Calcola la percentuale di completamento
        $totalSteps = count($steps);
        $completionPercentage = $totalSteps > 0 ? intval(($currentStepIndex / $totalSteps) * 100) : 0;
        
        $stepsSchema = [];
        
        // Crea un TextEntry per ogni passo
        foreach ($steps as $stepKey => $stepLabel) {
            $stepIndex = array_search($stepKey, array_keys($steps));
            $isCompleted = $workflow->isStepCompleted($stepKey);
            $isCurrent = $stepKey === $workflow->current_step;
            
            $stepsSchema[] = TextEntry::make("step_{$stepKey}")
                ->label('')
                ->state($stepLabel)
                ->badge()
                ->color(
                    $isCurrent ? 'warning' : ($isCompleted ? 'success' : 'gray')
                )
                ->icon(
                    $isCurrent ? 'heroicon-o-arrow-right' : ($isCompleted ? 'heroicon-o-check' : 'heroicon-o-circle')
                )
                ->iconPosition(IconPosition::Before);
        }
        
        return Grid::make()
            ->schema([
                Section::make('Progresso Workflow')
                    ->description("Completamento: {$completionPercentage}%")
                    ->schema([
                        TextEntry::make('current_step')
                            ->label('Passo corrente')
                            ->state($steps[$workflow->current_step] ?? $workflow->current_step),
                            
                        TextEntry::make('status')
                            ->label('Stato')
                            ->state(fn () => match($workflow->status) {
                                AppointmentWorkflow::STATUS_DRAFT => 'Bozza',
                                AppointmentWorkflow::STATUS_PATIENT_INFO => 'Informazioni Paziente Completate',
                                AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'Dentista Selezionato',
                                AppointmentWorkflow::STATUS_DATE_SELECTED => 'Data Selezionata',
                                AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'Trattamento Definito',
                                AppointmentWorkflow::STATUS_CONFIRMED => 'Confermato',
                                AppointmentWorkflow::STATUS_CANCELLED => 'Cancellato',
                                default => $workflow->status,
                            })
                            ->badge()
                            ->color(fn (string $state): string => match($workflow->status) {
                                AppointmentWorkflow::STATUS_DRAFT => 'gray',
                                AppointmentWorkflow::STATUS_PATIENT_INFO => 'info',
                                AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'warning',
                                AppointmentWorkflow::STATUS_DATE_SELECTED => 'warning',
                                AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'warning',
                                AppointmentWorkflow::STATUS_CONFIRMED => 'success',
                                AppointmentWorkflow::STATUS_CANCELLED => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2),
                    
                Section::make('Passi')
                    ->schema($stepsSchema)
                    ->columns(count($stepsSchema) > 3 ? 3 : count($stepsSchema)),
            ])
            ->columns(1);
    }
}
