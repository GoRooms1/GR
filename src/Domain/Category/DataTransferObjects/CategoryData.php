<?php

declare(strict_types=1);

namespace Domain\Category\DataTransferObjects;

use Domain\Category\Models\Category;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Room\DataTransferObjects\RoomData;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class CategoryData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public int $hotel_id,
        public ?int $value,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
        public Lazy|HotelData|null $hotel,
        /** @var DataCollection<RoomData> */
        public readonly null|Lazy|DataCollection $rooms,
    ) {
    }

    public static function fromModel(Category $category): self
    {
        return self::from([
            ...$category->toArray(),
            'hotel' => Lazy::whenLoaded('hotel', $category, fn () => HotelData::from($category->hotel)),
            'rooms' => Lazy::whenLoaded('room', $category, fn () => RoomData::collection($category->rooms)),
        ]);
    }
}
