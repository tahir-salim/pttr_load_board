<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {

        $message = $notification->toFirebase($notifiable);


        // Send the notification using Firebase Cloud Messaging or your preferred method.
    }
}
