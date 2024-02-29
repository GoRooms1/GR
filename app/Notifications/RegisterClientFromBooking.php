<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notify user when Client regetered frim booking
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
        return [SmsChannel::class];
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
        $this->toLog($notifiable);
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toWhatsap($notifiable)
    {
        //TODO
        $this->toLog($notifiable);
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toMail($notifiable)
    {
        //TODO
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
