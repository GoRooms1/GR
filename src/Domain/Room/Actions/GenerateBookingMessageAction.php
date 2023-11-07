<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Address\Models\Address;
use Domain\Hotel\Models\Hotel;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Room;
use Domain\Settings\Models\Settings;
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

        /** @var Hotel $hotel */
        $hotel = $room->hotel;

        /** @var string $title */
        $title = 'Бронирование № '.$bookingData->book_number;

        /** @var string $roomName */
        $roomName = GetRoomFullNameAction::run($room);

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
        $orderedOn = GenerateOrderedOnTextAction::run($bookingData->book_type, $bookingData->hours_count, $bookingData->days_count);

        /** @var string $phones */
        $phones = '';
        $isShowPhones = Settings::option('show_phones_booking');

        if ($isShowPhones && isset($hotel)) {           
            $phonesArray = array();
            
            if (!empty($hotel->phone))
                array_push($phonesArray, $hotel->phone);

            if (!empty($hotel->phone_2))
                array_push($phonesArray, $hotel->phone_2);

            if(count($phonesArray) > 0)
                $phones = 'Тел.: '.implode(', ', $phonesArray);        
        }

        /** @var string $body */        
        $body = 'Вы отправили заявку в '.($hotel?->type?->single_name ?? 'Отель').' «'.$hotel->name.'» номер '.$roomName.' на '.$orderedOn.'<br>';
        $body .= 'Пожалуйста, дождитесь подтверждения от отеля в течение 10-15 минут.'.'<br>';
        $body .= '<br>';
        $body .= 'Дата заезда: '.$bookingData->from_date->format('d.m.Y H:i').'<br>';
        $body .= 'Дата выезда: '.$bookingData->to_date->format('d.m.Y H:i').'<br>';
        $body .= 'По адресу: '.$addressStr.'<br>';
        $body .= $phones;

        /** @var string $notice */
        $notice = 'В случае, если отель с Вами не связался для подтверждения бронирования, <br class="hidden md:block">';
        $notice .= 'рекомендуем Вам выбрать другой отель. А данный отель будет помечен как отель с <br class="hidden md:block">';
        $notice .= 'низкой клиентоориентиорованностью.<br>';

        return [
            'title' => $title,
            'body' => $body,
            'notice' => $notice,
        ];
    }
}
