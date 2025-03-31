<?php

declare(strict_types=1);

namespace Modules\Dental\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Dental\Models\AppointmentWorkflow;
use Spatie\QueueableAction\QueueableAction;

class UpdateAppointmentWorkflowStepAction
{
    use QueueableAction;

    /**
     * Aggiorna un passo del workflow di prenotazione appuntamento.
     *
     * @param AppointmentWorkflow $workflow
     * @param string $step
     * @param array<string, mixed> $data
     * @param bool $moveToNextStep
     * 
     * @return AppointmentWorkflow
     */
    public function execute(
        AppointmentWorkflow $workflow,
        string $step,
        array $data,
        bool $moveToNextStep = true
    ): AppointmentWorkflow {
        // Verifica che il passo corrente sia valido
        $steps = array_keys(AppointmentWorkflow::getSteps());
        if (!in_array($step, $steps)) {
            throw new \InvalidArgumentException("Il passo '{$step}' non è valido");
        }

        // Aggiorna i dati del passo
        $stepData = $workflow->step_data ?? [];
        $stepData[$step] = $data;
        $workflow->step_data = $stepData;
        
        // Aggiorna lo stato in base al passo
        $this->updateStatus($workflow, $step);
        
        // Aggiorna il passo corrente se richiesto
        if ($moveToNextStep) {
            $this->moveToNextStep($workflow, $step);
        }
        
        // Aggiorna il timestamp dell'ultima interazione
        $workflow->last_interaction_at = now();
        $workflow->save();
        
        // Logga l'aggiornamento del workflow
        activity()
            ->performedOn($workflow)
            ->withProperties([
                'action' => 'update_step',
                'step' => $step,
                'move_to_next' => $moveToNextStep,
            ])
            ->log("Passo '{$step}' del workflow di prenotazione appuntamento aggiornato");
        
        return $workflow;
    }
    
    /**
     * Aggiorna lo stato del workflow in base al passo completato.
     *
     * @param AppointmentWorkflow $workflow
     * @param string $step
     */
    private function updateStatus(AppointmentWorkflow $workflow, string $step): void
    {
        $statusMap = [
            'patient_info' => AppointmentWorkflow::STATUS_PATIENT_INFO,
            'dentist_selection' => AppointmentWorkflow::STATUS_DENTIST_SELECTED,
            'date_selection' => AppointmentWorkflow::STATUS_DATE_SELECTED,
            'treatment_definition' => AppointmentWorkflow::STATUS_TREATMENT_DEFINED,
            'confirmation' => AppointmentWorkflow::STATUS_CONFIRMED,
        ];
        
        if (isset($statusMap[$step])) {
            $workflow->status = $statusMap[$step];
            
            // Se è l'ultimo passo, imposta anche il timestamp di completamento
            if ($step === 'confirmation') {
                $workflow->completed_at = now();
            }
        }
    }
    
    /**
     * Passa al passo successivo del workflow.
     *
     * @param AppointmentWorkflow $workflow
     * @param string $currentStep
     */
    private function moveToNextStep(AppointmentWorkflow $workflow, string $currentStep): void
    {
        $steps = array_keys(AppointmentWorkflow::getSteps());
        $currentIndex = array_search($currentStep, $steps);
        
        if ($currentIndex !== false && $currentIndex < count($steps) - 1) {
            $workflow->current_step = $steps[$currentIndex + 1];
        }
    }
}
