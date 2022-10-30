<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Illuminate\Support\Carbon;

final class AddressData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public ?string $postal_code,
        public ?string $country,
        public ?string $region,
        public ?string $area,
        public ?string $city,
        public ?string $street,
        public ?string $house,
        public ?string $block,
        public ?string $flat,
        public ?string $office,
        public ?string $geo_lat,
        public ?string $geo_lon,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
        public int $hotel_id,
        public ?string $value,
        public ?string $city_district,
        public ?string $city_area,
        public ?string $street_type,
        public ?string $street_with_type,
        public ?string $comment,
    ) {
    }
}
