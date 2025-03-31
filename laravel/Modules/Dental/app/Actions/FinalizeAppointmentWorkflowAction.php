<?php

declare(strict_types=1);

namespace Modules\Dental\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Dental\Models\Dentist;
use Modules\Notify\Actions\SendAppointmentNotificationAction;
use Modules\Patient\Models\Patient;
use Spatie\QueueableAction\QueueableAction;

class FinalizeAppointmentWorkflowAction
{
    use QueueableAction;

    /**
     * Costruttore dell'azione.
     */
    public function __construct(
        private ?SendAppointmentNotificationAction $notificationAction = null
    ) {
        $this->notificationAction = $notificationAction ?? app(SendAppointmentNotificationAction::class);
    }

    /**
     * Finalizza un workflow di prenotazione creando l'appuntamento.
     *
     * @param AppointmentWorkflow $workflow
     * @param bool $sendNotifications Se inviare notifiche dopo la creazione
     * 
     * @return Appointment
     * @throws \Exception
     */
    public function execute(
        AppointmentWorkflow $workflow,
        bool $sendNotifications = true
    ): Appointment {
        // Verifica che il workflow sia completo
        if ($workflow->status !== AppointmentWorkflow::STATUS_CONFIRMED) {
            throw new \InvalidArgumentException('Il workflow non è completo, impossibile finalizzare l\'appuntamento');
        }
        
        // Se esiste già un appuntamento associato, aggiornalo invece di crearne uno nuovo
        if ($workflow->appointment_id !== null) {
            return $this->updateExistingAppointment($workflow, $sendNotifications);
        }
        
        try {
            // Transazione DB per garantire l'integrità dei dati
            return DB::transaction(function () use ($workflow, $sendNotifications) {
                $stepData = $workflow->step_data ?? [];
                
                // Recupera i dati necessari dai passi del workflow
                $patientId = $workflow->patient_id;
                $dentistId = $stepData['dentist_selection']['dentist_id'] ?? null;
                $dateData = $stepData['date_selection'] ?? [];
                $treatmentData = $stepData['treatment_definition'] ?? [];
                
                // Verifica che i dati essenziali esistano
                if (!$patientId || !$dentistId || empty($dateData)) {
                    throw new \InvalidArgumentException('Dati insufficienti per creare l\'appuntamento');
                }
                
                // Crea l'appuntamento
                $appointment = new Appointment();
                $appointment->tenant_id = $workflow->tenant_id;
                $appointment->patient_id = $patientId;
                $appointment->dentist_id = $dentistId;
                $appointment->date = $dateData['date'] ?? now()->toDateString();
                $appointment->start_time = $dateData['start_time'] ?? null;
                $appointment->end_time = $dateData['end_time'] ?? null;
                $appointment->type = $treatmentData['type'] ?? 'check-up';
                $appointment->status = 'confirmed';
                $appointment->notes = $treatmentData['notes'] ?? '';
                $appointment->treatment_plan = $treatmentData['treatment_plan'] ?? '';
                $appointment->is_emergency = $treatmentData['is_emergency'] ?? false;
                $appointment->save();
                
                // Aggiorna il workflow con il riferimento all'appuntamento creato
                $workflow->appointment_id = $appointment->id;
                $workflow->save();
                
                // Invia notifiche se richiesto
                if ($sendNotifications) {
                    $this->sendNotifications($appointment);
                }
                
                // Logga la creazione dell'appuntamento
                activity()
                    ->performedOn($appointment)
                    ->withProperties([
                        'action' => 'create',
                        'workflow_id' => $workflow->id,
                    ])
                    ->log('Appuntamento creato da workflow di prenotazione');
                
                return $appointment;
            });
        } catch (\Exception $e) {
            Log::error('Errore nella finalizzazione del workflow di prenotazione', [
                'workflow_id' => $workflow->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Aggiorna un appuntamento esistente con i dati del workflow.
     *
     * @param AppointmentWorkflow $workflow
     * @param bool $sendNotifications
     * 
     * @return Appointment
     * @throws \Exception
     */
    private function updateExistingAppointment(
        AppointmentWorkflow $workflow,
        bool $sendNotifications
    ): Appointment {
        try {
            // Transazione DB per garantire l'integrità dei dati
            return DB::transaction(function () use ($workflow, $sendNotifications) {
                $appointment = Appointment::findOrFail($workflow->appointment_id);
                $stepData = $workflow->step_data ?? [];
                
                // Aggiorna l'appuntamento con i nuovi dati
                if (isset($stepData['dentist_selection']['dentist_id'])) {
                    $appointment->dentist_id = $stepData['dentist_selection']['dentist_id'];
                }
                
                if (!empty($stepData['date_selection'])) {
                    $dateData = $stepData['date_selection'];
                    $appointment->date = $dateData['date'] ?? $appointment->date;
                    $appointment->start_time = $dateData['start_time'] ?? $appointment->start_time;
                    $appointment->end_time = $dateData['end_time'] ?? $appointment->end_time;
                }
                
                if (!empty($stepData['treatment_definition'])) {
                    $treatmentData = $stepData['treatment_definition'];
                    $appointment->type = $treatmentData['type'] ?? $appointment->type;
                    $appointment->notes = $treatmentData['notes'] ?? $appointment->notes;
                    $appointment->treatment_plan = $treatmentData['treatment_plan'] ?? $appointment->treatment_plan;
                    $appointment->is_emergency = $treatmentData['is_emergency'] ?? $appointment->is_emergency;
                }
                
                // Aggiorna sempre lo stato a confirmed
                $appointment->status = 'confirmed';
                $appointment->save();
                
                // Invia notifiche se richiesto
                if ($sendNotifications) {
                    $this->sendNotifications($appointment);
                }
                
                // Logga l'aggiornamento dell'appuntamento
                activity()
                    ->performedOn($appointment)
                    ->withProperties([
                        'action' => 'update',
                        'workflow_id' => $workflow->id,
                    ])
                    ->log('Appuntamento aggiornato da workflow di prenotazione');
                
                return $appointment;
            });
        } catch (\Exception $e) {
            Log::error('Errore nell\'aggiornamento dell\'appuntamento da workflow', [
                'workflow_id' => $workflow->id,
                'appointment_id' => $workflow->appointment_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Invia le notifiche relative all'appuntamento.
     *
     * @param Appointment $appointment
     */
    private function sendNotifications(Appointment $appointment): void
    {
        try {
            $this->notificationAction
                ->onQueue('notifications')
                ->execute($appointment, 'appointment_confirmed');
        } catch (\Exception $e) {
            // Logga l'errore ma non bloccare il processo
            Log::error('Errore nell\'invio delle notifiche di appuntamento', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
