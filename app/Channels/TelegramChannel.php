<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class TelegramChannel
{
    /**
     * Отправить переданное уведомление.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTelegram($notifiable);        
    }
}