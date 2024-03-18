<?php

namespace App\Notifications;

use App\Channels\LogChannel;
use App\Channels\SmsChannel;
use App\Channels\WhatsappChannel;
use Domain\Room\Models\Room;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Support\Actions\SendWappiMessageAction;

/**
 * Notify user when Client registered from booking
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
        if (config('services.whatsapp.provider') === 'log') {
            return [LogChannel::class];
        }

        return [WhatsappChannel::class];
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toLog($notifiable)
    {
        \Log::info($this->getMessageText($notifiable));
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toSms($notifiable)
    {       
        $this->toLog($notifiable);
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toWhatsapp($notifiable)
    {        
        SendWappiMessageAction::run($notifiable->phone, $this->getMessageText($notifiable));
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

    private function getMessageText($notifiable) {
        $phone = new ClientsPhoneNumberValueObject($notifiable->phone);
        $text = "Добро пожаловать в GoRooms.ru. Логин ЛК: ".$phone->toDisplayValue().", Пароль: ".$notifiable->code;

        return $text;
    }
}
