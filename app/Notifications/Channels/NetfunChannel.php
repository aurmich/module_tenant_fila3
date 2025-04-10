<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications\Channels;

use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Notifications\ThemeNotification;
<<<<<<< HEAD
use Webmozart\Assert\Assert;
=======
>>>>>>> origin/dev

// use Modules\Xot\Contracts\ModelContactContract;

class NetfunChannel
{
    /**
     * Send the given notification.
     */
    public function send(CanThemeNotificationContract $notifiable, ThemeNotification $themeNotification): void
    {
        $smsData = $themeNotification->toSms($notifiable);
<<<<<<< HEAD
        
        // Otteniamo l'istanza dell'action e verifichiamo che sia del tipo corretto
        $netfunSendAction = app(NetfunSendAction::class);
        Assert::isInstanceOf($netfunSendAction, NetfunSendAction::class);
        
        // Eseguiamo l'action e verifichiamo che il risultato sia un array
        $data = $netfunSendAction->execute($smsData);
        Assert::isArray($data, 'Il risultato di NetfunSendAction deve essere un array');
        
        // Incrementiamo il contatore SMS
=======
        // Send notification to the $notifiable instance...
        $data = app(NetfunSendAction::class)->execute($smsData);
>>>>>>> origin/dev
        $notifiable->increase('sms', $data);
        /*
        $data['sms_sent_at'] = now();
        $data['sms_count'] = (int) $notifiable->sms_count + 1;
        $notifiable->update($data);
        */
    }
}
