<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetCityAreaSlugAction;
use Domain\Address\Actions\GetCityDistrictSlugAction;
use Domain\Address\Actions\GetCitySlugAction;
use Domain\Address\Models\Address;

final class AddressSlugsData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $city,
        public ?string $city_area,
        public ?string $city_district,
    ) {
    }

    public static function fromAddress(Address $address): self
    {
        return self::from([
           'city' => $address->city ? GetCitySlugAction::run($address) : null,
           'city_area' => $address->city_area ? GetCityAreaSlugAction::run($address) : null,
           'city_district' => $address->city_district ? GetCityDistrictSlugAction::run($address) : null,
        ]);
    }
}
