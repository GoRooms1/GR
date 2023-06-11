<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Address;

final class AddressSimpleData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $city,       
        public ?string $house,
        public ?string $block,
        public ?string $city_district,
        public ?string $city_area,        
        public ?string $street_with_type,
        public ?string $geo_lat,
        public ?string $geo_lon,
        public ?AddressSlugsData $slugs,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return self::from([
            ...$address->toArray(),
            'slugs' => AddressSlugsData::fromAddress($address),
        ]);
    }
}
