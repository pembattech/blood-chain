<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class BloodRequestNotification extends Notification
{
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New blood request near your location',
        ];
    }
}

