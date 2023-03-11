<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Address;

final class CityAreaKeyNameData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $key,
        public ?string $name,
        public ?string $city,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return self::from([
            'key' => $address->city_area,
            'name' => $address->city_area,
            'city' => $address->city,
        ]);
    }
}
