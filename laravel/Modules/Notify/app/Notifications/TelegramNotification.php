<?php

declare(strict_types=1);

/**
 * @see https://iftikhar-ahmed.medium.com/send-push-notifications-in-laravel-using-firebase-on-your-android-device-f585621db900
 * @see https://github.com/laravel-notification-channels/telegram
 */

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use InvalidArgumentException;
use NotificationChannels\Telegram\TelegramMessage;

<<<<<<< HEAD
/**
 * Classe per inviare notifiche tramite Telegram.
 */
=======
>>>>>>> origin/dev
class TelegramNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        // $this->data = $data;
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
     * @param  mixed  $notifiable  the entity to be notified
     *
     * throws InvalidArgumentException if no delivery channels are available for the notifiable entity
     */
    public function via(mixed $notifiable): array
>>>>>>> origin/dev
    {
        return ['telegram'];
    }

    /**
     * Get the array representation of the notification.
     *
<<<<<<< HEAD
     * @param object|null $notifiable The entity to be notified
=======
>>>>>>> origin/dev
     * @return array<string, mixed>
     */
    public function toArray(?object $notifiable): array
    {
        // return $this->data->toArray();
        return [];
    }

<<<<<<< HEAD
    /**
     * Get the Telegram representation of the notification.
     *
     * @param object|null $notifiable The entity to be notified
     * @return TelegramMessage
     */
=======
>>>>>>> origin/dev
    public function toTelegram(?object $notifiable): TelegramMessage
    {
        // $url = url('/invoice/'.$this->invoice->id);
        $url = '#';

        return TelegramMessage::create()
            // Optional recipient user id.
            // ->to(' dddd ')
            // Markdown supported.
            ->content('Hello there!')
            ->line('Your invoice has been *PAID*')
            // ->lineIf($notifiable->amount > 0, "Amount paid: {$notifiable->amount}")
            // ->line('Thank you!')

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            // (Optional) Inline Buttons
            ->button('View Invoice', $url)
            ->button('Download Invoice', $url);
        // (Optional) Inline Button with callback. You can handle callback in your bot instance
        // ->buttonWithCallback('Confirm', 'confirm_invoice '.$this->invoice->id)
    }
}
