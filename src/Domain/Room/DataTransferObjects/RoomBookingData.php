<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Category\DataTransferObjects\CategoryData;
use Domain\Hotel\DataTransferObjects\HotelBookingData;
use Domain\Room\Actions\GetRoomFullNameAction;
use Domain\Room\Models\Room;
use Spatie\LaravelData\Lazy;

final class RoomBookingData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?int $number,
        public ?string $full_name,
        public Lazy|CategoryData|null $category,       
        public Lazy|HotelBookingData|null $hotel,
    ) {
    }

    public static function fromModel(Room $room): self
    {       
        return self::from([
            ...$room->toArray(),
            'full_name' => GetRoomFullNameAction::run($room),
            'hotel' => HotelBookingData::fromModel($room->hotel),
            'category' => $room->category ? CategoryData::fromModel($room->category) : null,         
        ]);
    }
}
