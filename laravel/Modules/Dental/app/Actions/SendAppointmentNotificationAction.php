<?php

declare(strict_types=1);

namespace Modules\Dental\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Dental\Models\Appointment;
use Modules\Dental\Models\AppointmentWorkflow;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Patient\Models\Patient;
use Spatie\QueueableAction\QueueableAction;

/**
 * Azione per inviare notifiche relative agli appuntamenti.
 * 
 * Gestisce l'invio di notifiche in diversi step del workflow:
 * - Conferma prenotazione
 * - Promemoria appuntamento
 * - Cambio stato appuntamento
 */
class SendAppointmentNotificationAction
{
    use QueueableAction;

    /**
     * @var SendNotificationAction
     */
    protected SendNotificationAction $sendNotificationAction;

    /**
     * Costruttore.
     */
    public function __construct(SendNotificationAction $sendNotificationAction)
    {
        $this->sendNotificationAction = $sendNotificationAction;
    }

    /**
     * Invia una notifica relativa a un appuntamento.
     * 
     * @param string $type Tipo di notifica
     * @param Appointment|AppointmentWorkflow $subject Oggetto della notifica
     * @param array<string, mixed> $additionalData Dati aggiuntivi per la notifica
     * @return bool Esito dell'invio
     */
    public function execute(string $type, Appointment|AppointmentWorkflow $subject, array $additionalData = []): bool
    {
        $patient = $this->getPatient($subject);
        
        if (!$patient) {
            Log::warning('Impossibile inviare notifica: paziente non trovata', [
                'type' => $type,
                'subject_type' => $subject instanceof Appointment ? 'appointment' : 'workflow',
                'subject_id' => $subject->id,
            ]);
            return false;
        }

        // Prepara i dati per la notifica
        $notificationData = $this->prepareNotificationData($type, $subject, $additionalData);
        
        // Log dell'operazione
        Log::info('Invio notifica appuntamento', [
            'type' => $type,
            'patient_id' => $patient->id,
            'subject_type' => $subject instanceof Appointment ? 'appointment' : 'workflow',
            'subject_id' => $subject->id,
        ]);

        // Invia la notifica tramite il modulo Notify
        return $this->sendNotificationAction->execute(
            $patient,
            $notificationData['title'],
            $notificationData['message'],
            $notificationData['channels'],
            $notificationData['data']
        );
    }

    /**
     * Ottiene la paziente associata all'oggetto.
     * 
     * @param Appointment|AppointmentWorkflow $subject
     * @return Patient|null
     */
    protected function getPatient(Appointment|AppointmentWorkflow $subject): ?Patient
    {
        if ($subject instanceof Appointment) {
            return $subject->patient;
        }
        
        if ($subject instanceof AppointmentWorkflow) {
            return $subject->patient;
        }
        
        return null;
    }

    /**
     * Prepara i dati per la notifica in base al tipo.
     * 
     * @param string $type Tipo di notifica
     * @param Appointment|AppointmentWorkflow $subject Oggetto della notifica
     * @param array<string, mixed> $additionalData Dati aggiuntivi
     * @return array<string, mixed> Dati per la notifica
     */
    protected function prepareNotificationData(string $type, Appointment|AppointmentWorkflow $subject, array $additionalData = []): array
    {
        $appointment = $subject instanceof Appointment ? $subject : $subject->appointment;
        $patient = $this->getPatient($subject);
        
        $data = [
            'appointment_id' => $appointment?->id,
            'workflow_id' => $subject instanceof AppointmentWorkflow ? $subject->id : null,
            'patient_id' => $patient?->id,
        ];
        
        return match ($type) {
            'appointment_confirmation' => [
                'title' => 'Conferma Appuntamento',
                'message' => $this->getAppointmentConfirmationMessage($appointment, $patient),
                'channels' => ['mail', 'sms', 'database'],
                'data' => array_merge($data, $additionalData),
            ],
            'appointment_reminder' => [
                'title' => 'Promemoria Appuntamento',
                'message' => $this->getAppointmentReminderMessage($appointment, $patient),
                'channels' => ['mail', 'sms', 'database'],
                'data' => array_merge($data, $additionalData),
            ],
            'appointment_cancelled' => [
                'title' => 'Appuntamento Cancellato',
                'message' => $this->getAppointmentCancelledMessage($appointment, $patient),
                'channels' => ['mail', 'sms', 'database'],
                'data' => array_merge($data, $additionalData),
            ],
            'eligibility_check' => [
                'title' => 'Verifica Idoneità',
                'message' => $this->getEligibilityCheckMessage($patient, $additionalData),
                'channels' => ['mail', 'database'],
                'data' => array_merge($data, $additionalData),
            ],
            default => [
                'title' => 'Notifica Appuntamento',
                'message' => $additionalData['message'] ?? 'Notifica relativa al tuo appuntamento',
                'channels' => ['mail', 'database'],
                'data' => array_merge($data, $additionalData),
            ],
        };
    }

    /**
     * Ottiene il messaggio di conferma appuntamento.
     * 
     * @param Appointment|null $appointment
     * @param Patient|null $patient
     * @return string
     */
    protected function getAppointmentConfirmationMessage(?Appointment $appointment, ?Patient $patient): string
    {
        if (!$appointment || !$patient) {
            return 'La tua prenotazione è stata confermata.';
        }
        
        $dentistName = $appointment->dentist?->full_name ?? 'il medico assegnato';
        $date = $appointment->date?->format('d/m/Y') ?? 'data da definire';
        $time = $appointment->start_time ?? 'orario da definire';
        
        return "Gentile {$patient->first_name},\n\n" .
            "la tua prenotazione presso il nostro centro è stata confermata.\n" .
            "Dettagli appuntamento:\n" .
            "- Data: {$date}\n" .
            "- Ora: {$time}\n" .
            "- Medico: {$dentistName}\n\n" .
            "Per modificare l'appuntamento o per qualsiasi informazione, accedi alla tua area personale " .
            "o contattaci direttamente.\n\n" .
            "Cordiali saluti,\n" .
            "Team SaluteOra";
    }

    /**
     * Ottiene il messaggio di promemoria appuntamento.
     * 
     * @param Appointment|null $appointment
     * @param Patient|null $patient
     * @return string
     */
    protected function getAppointmentReminderMessage(?Appointment $appointment, ?Patient $patient): string
    {
        if (!$appointment || !$patient) {
            return 'Promemoria per il tuo appuntamento.';
        }
        
        $dentistName = $appointment->dentist?->full_name ?? 'il medico assegnato';
        $date = $appointment->date?->format('d/m/Y') ?? 'data da definire';
        $time = $appointment->start_time ?? 'orario da definire';
        
        return "Gentile {$patient->first_name},\n\n" .
            "questo è un promemoria per il tuo appuntamento di domani.\n" .
            "Dettagli appuntamento:\n" .
            "- Data: {$date}\n" .
            "- Ora: {$time}\n" .
            "- Medico: {$dentistName}\n\n" .
            "Per modificare l'appuntamento o per qualsiasi informazione, accedi alla tua area personale " .
            "o contattaci direttamente.\n\n" .
            "Cordiali saluti,\n" .
            "Team SaluteOra";
    }

    /**
     * Ottiene il messaggio di cancellazione appuntamento.
     * 
     * @param Appointment|null $appointment
     * @param Patient|null $patient
     * @return string
     */
    protected function getAppointmentCancelledMessage(?Appointment $appointment, ?Patient $patient): string
    {
        if (!$appointment || !$patient) {
            return 'Il tuo appuntamento è stato cancellato.';
        }
        
        $date = $appointment->date?->format('d/m/Y') ?? 'data da definire';
        $time = $appointment->start_time ?? 'orario da definire';
        
        return "Gentile {$patient->first_name},\n\n" .
            "ti informiamo che il tuo appuntamento del {$date} alle ore {$time} è stato cancellato.\n\n" .
            "Per prenotare un nuovo appuntamento, accedi alla tua area personale " .
            "o contattaci direttamente.\n\n" .
            "Cordiali saluti,\n" .
            "Team SaluteOra";
    }

    /**
     * Ottiene il messaggio di verifica idoneità.
     * 
     * @param Patient|null $patient
     * @param array<string, mixed> $data
     * @return string
     */
    protected function getEligibilityCheckMessage(?Patient $patient, array $data): string
    {
        if (!$patient) {
            return 'Risultato della verifica idoneità.';
        }
        
        $isEligible = $data['eligible'] ?? false;
        
        if ($isEligible) {
            return "Gentile {$patient->first_name},\n\n" .
                "siamo lieti di informarti che sei risultata idonea a partecipare al programma SaluteOra " .
                "per l'assistenza odontoiatrica gratuita durante la gravidanza.\n\n" .
                "Puoi procedere con la prenotazione di un appuntamento attraverso " .
                "la tua area personale o contattandoci direttamente.\n\n" .
                "Cordiali saluti,\n" .
                "Team SaluteOra";
        }
        
        $reason = $data['reason'] ?? 'requisiti non soddisfatti';
        
        return "Gentile {$patient->first_name},\n\n" .
            "in seguito alla verifica dei requisiti, ti informiamo che attualmente non risulti " .
            "idonea a partecipare al programma SaluteOra.\n\n" .
            "Motivo: {$reason}\n\n" .
            "Se ritieni che ci sia stato un errore o se la tua situazione è cambiata, " .
            "contattaci per una nuova valutazione.\n\n" .
            "Cordiali saluti,\n" .
            "Team SaluteOra";
    }
}
