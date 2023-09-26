<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Hotel\Models\Hotel;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Room;
use Lang;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(BookingData $bookingData)
 */
final class GenerateBookingBotNotificationTextAction extends Action
{
    /**
     * @param  BookingData  $bookingData
     * @return string
     */
    public function handle(BookingData $bookingData): string
    {
        /** @var Room $room */
        $room = Room::where('id', $bookingData->room_id)->with(['hotel', 'category'])->first();

        /** @var Hotel $hotel */
        $hotel = $room->hotel;

        /** @var string $orderedOn */
        $orderedOn = GenerateOrderedOnTextAction::run($bookingData->book_type, $bookingData->hours_count, $bookingData->days_count);        

        /** @var string $roomName */
        $roomName = GetRoomFullNameAction::run($room);

        $phone = '+'.preg_replace('/\D/', '', $bookingData->client_phone);

        $hotelLink = "<a href='".route('hotels.show', ['hotel' => $hotel])."'>".$hotel->name."</a>";

        /** @var string $text */      
        $text = '<b>Бронирование № '.$bookingData->book_number.'</b>'.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Отель "'.$hotelLink.'" id '.$room->hotel_id.':'.PHP_EOL;
        $text .= 'Номер - '.$roomName.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Забронировано на '.$orderedOn.PHP_EOL;
        $text .= 'Заезд - '.$bookingData->from_date->format('d.m.Y H:i').PHP_EOL;
        $text .= 'Выезд - '.$bookingData->to_date->format('d.m.Y H:i').PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Сумма - '.$bookingData->amount.' р.'.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Имя: '.$bookingData->client_fio.PHP_EOL;
        $text .= 'Телефон: '.$phone.PHP_EOL;
        $text .= 'Комментарий: '.$bookingData->book_comment.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= '<b>Во избежание репутационных потерь, убедительная просьба незамедлительно связаться с клиентом  подтвердить или отменить бронирование!</b>'.PHP_EOL;

        return $text;
    }
}
