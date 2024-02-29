<?php

namespace App\Notifications;

use App\Channels\TelegramChannel;
use Domain\Room\Actions\GenerateOrderedOnTextAction;
use Domain\Room\Actions\GetRoomFullNameAction;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Booking;
use Domain\Room\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Notify user when Client canceling booking
 */
class NotificationHotelBookingCanceled extends Notification
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
        $via[] = 'mail';
        
        if ($notifiable->telegram_id) {
            $via[] = TelegramChannel::class;
        }

        return $via;
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toLog($notifiable)
    {
        \Log::info("Client canceled booking. Phone: ".$notifiable->phone.", book_no: ".$this->booking->book_number);
    }

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toTelegram($notifiable)
    {
        $bookingData = BookingData::fromModel($this->booking);
        $room = Room::where('id', $this->booking->room_id)->with(['hotel', 'category'])->first();
        $hotel = $room->hotel;
        $orderedOn = GenerateOrderedOnTextAction::run($bookingData->book_type, $bookingData->hours_count, $bookingData->days_count);
        $roomName = GetRoomFullNameAction::run($room);
        $phone = '+'.preg_replace('/\D/', '', $bookingData->client_phone);
        $hotelLink = "<a href='".route('hotels.show', ['hotel' => $hotel])."'>".$hotel->name."</a>";
        
        $text  = '<b>Клиент отменил бронирование!</b>'.PHP_EOL;
        $text .= '<b>Бронирование № '.$bookingData->book_number.'</b>'.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Отель "'.$hotelLink.'" id '.$room->hotel_id.':'.PHP_EOL;
        $text .= 'Номер - '.$roomName.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Забронировано на '.$orderedOn.PHP_EOL;
        $text .= 'Заезд - '.$bookingData->from_date->format('d.m.Y H:i').PHP_EOL;
        $text .= 'Выезд - '.$bookingData->to_date->format('d.m.Y H:i').PHP_EOL;           
        $text .= ' '.PHP_EOL;
        $text .= 'Имя: '.$bookingData->client_fio.PHP_EOL;
        $text .= 'Телефон: '.$phone.PHP_EOL;           
        $text .= ' '.PHP_EOL;         

        Telegram::sendMessage([
            'chat_id' => $notifiable->telegram_id,
            'text' => $text,
        ]);
    }    

    /**     
     *
     * @param  mixed  $notifiable    
     */
    public function toMail($notifiable)
    {
        $bookingData = BookingData::fromModel($this->booking);
        $room = Room::where('id', $this->booking->room_id)->with(['hotel', 'category'])->first();

        return (new MailMessage)
            ->subject('Сервис GoRooms – клиент отменил бронирование '.$bookingData->book_number)
            ->view( 'emails.room-bookin-short', ['room' => $room, 'data' => $bookingData]);
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
