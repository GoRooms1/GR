<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Metro;
use Domain\Hotel\DataTransferObjects\HotelData;
use Spatie\LaravelData\Lazy;
use Support\DataProcessing\Traits\CustomStr;

final class MetroData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $color,
        public string $name,
        public string $api_value,
        public int $distance,
        public int $hotel_id,
        public bool $custom,
        public string $slug,
        public Lazy|HotelData|null $hotel,
    ) {
    }

    public static function fromModel(Metro $metro): self
    {
        $slug = CustomStr::getCustomSlug($metro->name);

        return self::from([
            ...$metro->toArray(),
            'slug' => $slug,
            'hotel' => Lazy::whenLoaded('hotel', $metro, fn () => HotelData::fromModel($metro->hotel)),
        ]);
    }
}
