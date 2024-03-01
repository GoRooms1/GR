<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Domain\Room\Models\Booking;
use Domain\Room\Models\Room;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notify user when booking can be reviewed
 */
class NotificationClientForReview extends Notification
{
    use Queueable;

    protected Booking $booking;
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
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
        \Log::info($this->getMessageText($notifiable));
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
        $room = Room::where('id', $this->booking->room_id)->first();
        $hotel = $room->hotel;
        $text = "Для начисления кэшбека, не забудьте оставить отзыв о «".$hotel->name."».";

        if (!empty($notifiable->code) && password_verify($notifiable->code, $notifiable->password)) {
            $phone = new ClientsPhoneNumberValueObject($notifiable->phone);
            $text .= " Логин ЛК: ".$phone->toDisplayValue().", Пароль: ".$notifiable->code;
        }

        return $text;
    }
}
