<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Hotel\Models\HotelType;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class HotelTypeData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public int $sort,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
        public ?string $single_name,
        #[DataCollectionOf(HotelData::class)]
        public readonly null|Lazy|DataCollection $hotels
    ) {
    }

    public static function fromModel(HotelType $hotelType): self
    {
        return self::from([
            ...$hotelType->toArray(),
            'hotels' => Lazy::whenLoaded('hotels', $hotelType, fn () => HotelData::collection($hotelType->hotels)),
        ]);
    }
}
