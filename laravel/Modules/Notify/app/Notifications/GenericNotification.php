<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

/**
 * Notifica generica configurabile per il sistema SaluteOra.
 * Supporta l'invio tramite email, SMS (Twilio) e database.
 */
class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string Il titolo della notifica
     */
    protected string $title;

    /**
     * @var string Il contenuto della notifica
     */
    protected string $message;

    /**
     * @var array<string> I canali da utilizzare per la notifica
     */
    protected array $channels;

    /**
     * @var array<string, mixed> Dati aggiuntivi per la notifica
     */
    protected array $data;

    /**
     * Crea una nuova istanza della notifica.
     *
     * @param string $title Il titolo della notifica
     * @param string $message Il contenuto della notifica
     * @param array<string> $channels I canali da utilizzare ('mail', 'sms', 'database')
     * @param array<string, mixed> $data Dati aggiuntivi per la notifica
     */
    public function __construct(string $title, string $message, array $channels = ['mail'], array $data = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->channels = $channels;
        $this->data = $data;
    }

    /**
     * Ottiene i canali di consegna della notifica.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return $this->channels;
    }

    /**
     * Ottiene la rappresentazione mail della notifica.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage())
            ->subject($this->title)
            ->greeting('Gentile ' . $this->getRecipientName($notifiable))
            ->line($this->message);

        // Aggiungi eventuali azioni se specificate nei dati
        if (isset($this->data['action_text']) && isset($this->data['action_url'])) {
            $mail->action($this->data['action_text'], $this->data['action_url']);
        }

        // Aggiungi eventuali linee aggiuntive
        if (isset($this->data['additional_lines']) && is_array($this->data['additional_lines'])) {
            foreach ($this->data['additional_lines'] as $line) {
                $mail->line($line);
            }
        }

        return $mail->salutation('Cordiali saluti,')
            ->line('Team SaluteOra');
    }

    /**
     * Ottiene la rappresentazione SMS della notifica.
     *
     * @param mixed $notifiable
     * @return TwilioSmsMessage
     */
    public function toTwilio($notifiable): TwilioSmsMessage
    {
        $content = "SaluteOra: {$this->title}\n{$this->message}";
        
        // Limita la lunghezza del messaggio SMS
        if (mb_strlen($content) > 320) {
            $content = mb_substr($content, 0, 317) . '...';
        }
        
        return (new TwilioSmsMessage())
            ->content($content);
    }

    /**
     * Ottiene la rappresentazione database della notifica.
     *
     * @param mixed $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
            'created_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Ottiene il nome del destinatario per il saluto personalizzato.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function getRecipientName($notifiable): string
    {
        // Tenta di ottenere il nome dal destinatario in vari modi
        if (method_exists($notifiable, 'getFullName')) {
            return $notifiable->getFullName();
        }
        
        if (property_exists($notifiable, 'full_name') && $notifiable->full_name) {
            return $notifiable->full_name;
        }
        
        if (property_exists($notifiable, 'first_name') && $notifiable->first_name) {
            return $notifiable->first_name;
        }
        
        if (property_exists($notifiable, 'name') && $notifiable->name) {
            return $notifiable->name;
        }
        
        return 'Utente';
    }
}
