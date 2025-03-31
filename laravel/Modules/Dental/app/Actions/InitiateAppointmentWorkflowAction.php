<?php

declare(strict_types=1);

namespace Modules\Dental\Actions;

use Illuminate\Support\Str;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Patient\Models\Patient;
use Spatie\QueueableAction\QueueableAction;

class InitiateAppointmentWorkflowAction
{
    use QueueableAction;

    /**
     * Inizializza un nuovo workflow per prenotazione appuntamento.
     *
     * @param Patient|null $patient Il paziente (opzionale, può essere associato dopo)
     * @param array<string, mixed> $initialData Dati iniziali opzionali
     * @param int|null $userId ID dell'utente che ha iniziato il workflow
     * @param string|null $sessionId ID della sessione utente (per utenti non autenticati)
     *
     * @return AppointmentWorkflow
     */
    public function execute(
        ?Patient $patient = null,
        array $initialData = [],
        ?int $userId = null,
        ?string $sessionId = null
    ): AppointmentWorkflow {
        // Crea il workflow
        $workflow = new AppointmentWorkflow();
        $workflow->tenant_id = $patient?->tenant_id ?? tenant()->id;
        $workflow->patient_id = $patient?->id;
        $workflow->current_step = 'patient_info';
        $workflow->status = AppointmentWorkflow::STATUS_DRAFT;
        $workflow->step_data = $initialData;
        $workflow->started_at = now();
        $workflow->last_interaction_at = now();
        $workflow->created_by = $userId;
        $workflow->session_id = $sessionId ?? Str::uuid()->toString();
        $workflow->save();
        
        // Logga l'inizializzazione del workflow
        activity()
            ->performedOn($workflow)
            ->withProperties([
                'action' => 'initiate',
                'patient_id' => $patient?->id,
                'user_id' => $userId,
            ])
            ->log('Workflow di prenotazione appuntamento iniziato');
        
        return $workflow;
    }
}
