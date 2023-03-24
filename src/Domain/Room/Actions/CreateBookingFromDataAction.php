<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Booking;
use Lorisleiva\Actions\Action;

/**
 * @method static Booking run(BookingData $data)
 */
final class CreateBookingFromDataAction extends Action
{
    /**
     * @param  BookingData  $data
     * @return Booking
     */
    public function handle(BookingData $data): Booking
    {
        $booking = Booking::create(
            array_merge(
                $data->toArray(),
                [
                    'from-date' => $data->from_date,
                    'to-date' => $data->to_date,
                ]
            )
        );
        $booking->room()->associate($data->room_id);
        $booking->save();

        return $booking;
    }
}
