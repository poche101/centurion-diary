<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class PrayerReminder extends Notification
{
    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('Centurion Diary 👑')
            ->body('Time to pray! 🙏')
            ->icon('/images/icon-192.png')
            ->data(['url' => '/dashboard']);
    }
}
