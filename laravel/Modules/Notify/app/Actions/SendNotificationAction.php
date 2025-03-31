<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification as LaravelNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Models\NotificationLog;
use Modules\Notify\Notifications\GenericNotification;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per l'invio di notifiche multi-canale.
 * Supporta l'invio via email, SMS e notifiche in-app.
 */
class SendNotificationAction
{
    use QueueableAction;

    /**
     * Invia una notifica a un destinatario.
     *
     * @param Model $recipient Il destinatario della notifica
     * @param string $title Il titolo della notifica
     * @param string $message Il contenuto della notifica
     * @param array<string> $channels I canali da utilizzare ('mail', 'sms', 'database')
     * @param array<string, mixed> $data Dati aggiuntivi per la notifica
     * 
     * @return bool Esito dell'invio
     */
    public function execute(
        Model $recipient,
        string $title,
        string $message,
        array $channels = ['mail'],
        array $data = []
    ): bool {
        try {
            // Crea la notifica
            $notification = new GenericNotification(
                $title,
                $message,
                $channels,
                $data
            );
            
            // Invia la notifica
            Notification::send($recipient, $notification);
            
            // Crea un log della notifica
            $this->logNotification($recipient, $title, $message, $channels, $data);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Errore nell\'invio della notifica', [
                'error' => $e->getMessage(),
                'recipient_type' => get_class($recipient),
                'recipient_id' => $recipient->id,
                'title' => $title,
                'channels' => $channels,
            ]);
            
            return false;
        }
    }
    
    /**
     * Registra l'invio della notifica nel log.
     *
     * @param Model $recipient Il destinatario della notifica
     * @param string $title Il titolo della notifica
     * @param string $message Il contenuto della notifica
     * @param array<string> $channels I canali utilizzati
     * @param array<string, mixed> $data Dati aggiuntivi
     */
    protected function logNotification(
        Model $recipient,
        string $title,
        string $message,
        array $channels,
        array $data
    ): void {
        try {
            NotificationLog::create([
                'notifiable_type' => get_class($recipient),
                'notifiable_id' => $recipient->id,
                'title' => $title,
                'content' => $message,
                'channels' => $channels,
                'data' => $data,
                'sent_at' => now(),
                'status' => 'sent',
            ]);
        } catch (\Exception $e) {
            Log::warning('Impossibile loggare la notifica', [
                'error' => $e->getMessage(),
                'recipient_type' => get_class($recipient),
                'recipient_id' => $recipient->id,
            ]);
        }
    }
}
