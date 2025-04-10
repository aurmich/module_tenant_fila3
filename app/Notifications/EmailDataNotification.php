<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\EmailData;

<<<<<<< HEAD
/**
 * Classe per inviare notifiche email utilizzando EmailData.
 */
=======
>>>>>>> origin/dev
class EmailDataNotification extends Notification
{
    use Queueable;

<<<<<<< HEAD
    /**
     * I dati dell'email da inviare.
     *
     * @var EmailData
     */
    protected EmailData $emailData;

    /**
     * Create a new notification instance.
     *
     * @param EmailData $emailData I dati dell'email da inviare
     */
=======
    protected EmailData $emailData;

>>>>>>> origin/dev
    public function __construct(EmailData $emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Get the notification's delivery channels.
     *
<<<<<<< HEAD
     * @param object $notifiable The entity to be notified
     * @return array<string>
     */
    public function via(object $notifiable): array
=======
     * @return array<string>
     */
    public function via(mixed $notifiable): array
>>>>>>> origin/dev
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
<<<<<<< HEAD
     *
     * @param object $notifiable The entity to be notified
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
=======
     */
    public function toMail(mixed $notifiable): MailMessage
>>>>>>> origin/dev
    {
        $mailMessage = (new MailMessage())
            ->subject($this->emailData->subject)
            ->line($this->emailData->body);

        if (! empty($this->emailData->body_html)) {
            $mailMessage->view('notify::emails.template', [
                'content' => $this->emailData->body_html,
            ]);
        }

        if (! empty($this->emailData->from_email) && ! empty($this->emailData->from)) {
            $mailMessage->from($this->emailData->from_email, $this->emailData->from);
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
<<<<<<< HEAD
     * @param object $notifiable The entity to be notified
     * @return array<string, string|null>
     */
    public function toArray(object $notifiable): array
=======
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
>>>>>>> origin/dev
    {
        return [
            'to' => $this->emailData->to,
            'from' => $this->emailData->from,
            'from_email' => $this->emailData->from_email,
            'subject' => $this->emailData->subject,
            'body' => $this->emailData->body,
        ];
    }
}
