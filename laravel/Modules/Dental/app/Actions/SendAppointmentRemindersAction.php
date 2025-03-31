<?php

declare(strict_types=1);

namespace Modules\Dental\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Dental\Models\Appointment;
use Modules\Notify\Actions\SendAppointmentNotificationAction;
use Spatie\QueueableAction\QueueableAction;

class SendAppointmentRemindersAction
{
    use QueueableAction;

    /**
     * Numero massimo di tentativi per l'invio dei promemoria.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * Invia promemoria per gli appuntamenti imminenti.
     *
     * @param int $daysBeforeAppointment Numero di giorni prima dell'appuntamento per cui inviare il promemoria
     * @param int $batchSize Dimensione del batch di elaborazione
     * 
     * @return int Numero di promemoria inviati
     */
    public function execute(int $daysBeforeAppointment = 1, int $batchSize = 50): int
    {
        $targetDate = Carbon::now()->addDays($daysBeforeAppointment)->startOfDay();
        $remindersSent = 0;

        try {
            Log::info('Inizio invio promemoria per appuntamenti del ' . $targetDate->format('Y-m-d'));

            // Recupera gli appuntamenti per la data target che non hanno ancora ricevuto il promemoria
            $appointments = Appointment::whereDate('date', $targetDate->format('Y-m-d'))
                ->where('status', '!=', Appointment::STATUS_CANCELLED)
                ->where('reminder_sent', false)
                ->take($batchSize)
                ->get();

            Log::info('Trovati ' . $appointments->count() . ' appuntamenti da notificare');

            foreach ($appointments as $appointment) {
                try {
                    // Invia il promemoria tramite l'azione di notifica
                    $sent = app(SendAppointmentNotificationAction::class)->execute(
                        appointment: $appointment,
                        type: 'reminder',
                        additionalData: [
                            'days_before' => $daysBeforeAppointment,
                        ]
                    );

                    // Aggiorna lo stato dell'appuntamento se il promemoria è stato inviato
                    if ($sent) {
                        $appointment->reminder_sent = true;
                        $appointment->reminder_sent_at = Carbon::now();
                        $appointment->save();
                        
                        $remindersSent++;
                        
                        // Registra l'attività
                        activity()
                            ->performedOn($appointment)
                            ->withProperties([
                                'action' => 'send_reminder',
                                'days_before' => $daysBeforeAppointment,
                            ])
                            ->log('Inviato promemoria per appuntamento');
                    }
                } catch (\Exception $e) {
                    Log::error('Errore nell\'invio del promemoria per l\'appuntamento ' . $appointment->id, [
                        'appointment_id' => $appointment->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }

            Log::info('Completato invio promemoria. Inviati: ' . $remindersSent);
            
            return $remindersSent;
        } catch (\Exception $e) {
            Log::error('Errore generale nell\'invio dei promemoria', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }
}
