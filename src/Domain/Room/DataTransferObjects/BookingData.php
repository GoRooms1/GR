<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Room\Actions\GenerateBookingNumberAction;
use Domain\Room\Requests\BookingRequest;
use Illuminate\Support\Carbon;

final class BookingData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $book_number,
        public string $client_fio,
        public string $client_phone,
        public string $book_type,
        public ?string $book_comment,
        public Carbon $from_date,
        public Carbon $to_date,
        public ?int $hours_count,
        public ?int $days_count,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
        public ?int $room_id,
        public int $on_show,

    ) {
    }

    /**
     * @param  BookingRequest  $request
     * @return BookingData
     */
    public static function fromRequest(BookingRequest $request): self
    {
        return self::from([
            'book_number' => GenerateBookingNumberAction::run(),
            'client_fio' => $request->get('client_fio', ''),
            'client_phone' => $request->get('client_phone', ''),
            'book_type' => $request->get('book_type', 'hour'),
            'book_comment' => $request->get('book_comment', null),
            'from_date' => Carbon::createFromFormat('d.m.Y H:i', $request->get('from_date').' '.$request->get('from_time')),
            'to_date' => Carbon::createFromFormat('d.m.Y H:i', $request->get('to_date').' '.$request->get('to_time')),
            'hours_count' => $request->get('hours_count', null),
            'days_count' => $request->get('days_count', null),
            'room_id' => $request->get('room_id', null),
            'on_show' => 0,
        ]);
    }
}
