<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Address;
use Illuminate\Support\Carbon;

final class CityDistrictKeyNameData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $key,
        public ?string $name,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return self::from([
           'key' => $address->city_district,
           'name' => $address->city_district,           
        ]);
    }
    
}
