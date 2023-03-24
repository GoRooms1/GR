<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Address\Models\Address;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Room;
use Lang;
use Lorisleiva\Actions\Action;

/**
 * @method static array<string, string> run(BookingData $bookingData)
 */
final class GenerateBookingMessageAction extends Action
{
    /**
     * @param  BookingData  $bookingData
     * @return array<string, string>
     */
    public function handle(BookingData $bookingData): array
    {
        /** @var Room $room */
        $room = Room::where('id', $bookingData->room_id)->with(['hotel', 'category'])->first();

        /** @var string $title */
        $title = 'Бронирование № '.$bookingData->book_number;

        /** @var string $label */
        $label = $room->name ?? $room->id;

        /** @var Address $address */
        $address = $room->hotel->address;

        /** @var string $addressStr */
        $addressStr = $address->city;
        $addressStr .= isset($address->area) ? ', '.$address->area : '';
        $addressStr .= isset($address->city_district) ? ', '.$address->city_district : '';
        $addressStr .= isset($address->street_with_type) ? ', '.$address->street_with_type : '';
        $addressStr .= isset($address->house) ? ', д.'.$address->house : '';
        $addressStr .= isset($address->block) ? ' стр '.$address->block : '';

        /** @var string $orderedOn */
        $orderedOn = '';
        if ($bookingData->book_type == 'hour') {
            /** @var int $hoursCount */
            $hoursCount = $bookingData->hours_count;
            $orderedOn = $bookingData->hours_count.' '.Lang::choice('час|часа|часов', $hoursCount, [], 'ru');
        }

        if ($bookingData->book_type == 'night') {
            $orderedOn = ' ночь';
        }

        if ($bookingData->book_type == 'day') {
            /** @var int $daysCount */
            $daysCount = $bookingData->days_count;
            $orderedOn = $bookingData->days_count.' '.Lang::choice('сутки|суток|суток', $daysCount, [], 'ru');
        }

        /** @var string $body */
        $body = 'Поздравляем!<br>';
        $body .= 'Вы забронировали '.($room->hotel?->type?->single_name ?? 'Отель').' «'.$room->hotel->name.'» номер '.$label.' на '.$orderedOn.'<br>';
        $body .= 'Дата заезда: '.$bookingData->from_date->format('d.m.Y H:i').'.<br>';
        $body .= 'Дата выезда: '.$bookingData->to_date->format('d.m.Y H:i').'.<br>';
        $body .= 'По адресу: '.$addressStr;
        $body .= '<br>Администратор «'.$room->hotel->name.'» свяжется с Вами для подтверждения бронирования.
                    <br>Ждем Вас и приятного отдыха!';

        return [
            'title' => $title,
            'body' => $body,
        ];
    }
}
