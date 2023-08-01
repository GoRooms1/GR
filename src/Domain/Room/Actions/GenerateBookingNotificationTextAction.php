<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Room;
use Lang;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(BookingData $bookingData)
 */
final class GenerateBookingNotificationTextAction extends Action
{
    /**
     * @param  BookingData  $bookingData
     * @return string
     */
    public function handle(BookingData $bookingData): string
    {
        /** @var Room $room */
        $room = Room::where('id', $bookingData->room_id)->with(['hotel', 'category'])->first();

        /** @var string $orderedOn */
        $orderedOn = '';
        if ($bookingData->book_type == 'hour') {
            /** @var int $hoursCount */
            $hoursCount = $bookingData->hours_count;
            $orderedOn = $bookingData->hours_count.' '.Lang::choice('час|часа|часов', $hoursCount, [], 'ru');
        }

        if ($bookingData->book_type == 'night') {
            $orderedOn = 'ночь';
        }

        if ($bookingData->book_type == 'day') {
            /** @var int $daysCount */
            $daysCount = $bookingData->days_count;
            $orderedOn = $bookingData->days_count.' '.Lang::choice('сутки|суток|суток', $daysCount, [], 'ru');
        }

        /** @var string $roomName */
        $roomName = ($room->number ? $room->number.' / ' : '')
            .$room->name
            .(strlen($room->category->name ?? '') > 1 ? ' ('.$room->category->name.')' : '');

        /** @var string $text */        
        $text = '<b>Бронирование № '.$bookingData->book_number.PHP_EOL;
        $text .= 'Отель "'.$room->hotel->name.'" id '.$room->hotel_id.':</b>'.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Номер - '.$roomName.PHP_EOL;
        $text .= 'Заезд - '.$bookingData->from_date->format('d.m.Y H:i').PHP_EOL;
        $text .= 'Забронировано на '.$orderedOn.PHP_EOL;
        $text .= 'Выезд - '.$bookingData->to_date->format('d.m.Y H:i').PHP_EOL;
        $text .= 'Сумма - '.$bookingData->amount.' р.'.PHP_EOL;
        $text .= ' '.PHP_EOL;
        $text .= 'Имя: '.$bookingData->client_fio.PHP_EOL;
        $text .= 'Телефон: '.$bookingData->client_phone.PHP_EOL;
        $text .= 'Комментарий: '.$bookingData->book_comment.PHP_EOL;

        return $text;
    }
}
