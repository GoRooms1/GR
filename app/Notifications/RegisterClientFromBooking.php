<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notify user when created general User-Hotel
 */
class RegisterClientFromBooking extends Notification
{
    use Queueable;
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        $registerChannel = config('client.notifications.register');       
        return [config('client.notifications.channels.'.$registerChannel)];
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toLog($notifiable)
    {
        \Log::info("Registred new client user. Phone: ".$notifiable->phone.", password: ".$notifiable->code);
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toSms($notifiable)
    {
        //TODO
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toWhatsap($notifiable)
    {
        //TODO
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toMail($notifiable)
    {
        $this->toLog($notifiable);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}
