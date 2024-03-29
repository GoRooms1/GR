<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetCitySlugAction;
use Domain\Address\Models\Address;
use Domain\Search\DataTransferObjects\ParamsData;

final class CitySearchData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $name,       
        public ?string $link,
    ) {
    }

    public static function fromModel(Address $address): self
    {       
        return self::from([            
            'name' => $address->city,
            'link' => GetCitySlugAction::run($address),
        ]);
    }
}
