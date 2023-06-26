<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetCitySlugAction;
use Domain\Address\Models\Address;

final class CityKeyNameData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $key,
        public ?string $name,
        public ?string $slug,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return self::from([
            'key' => $address->city,
            'name' => $address->city,
            'slug' => GetCitySlugAction::run($address)
        ]);
    }
}
