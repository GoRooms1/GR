<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetCityDistrictSlugAction;
use Domain\Address\Models\Address;
use Domain\Search\DataTransferObjects\ParamsData;

final class CityDistrictSearchData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $name,       
        public ?string $city,    
        public ?string $link,
    ) {
    }

    public static function fromModel(Address $address): self
    {        
        return self::from([            
            'name' => $address->city_district,            
            'city' => 'г. '.$address->city,
            'link' => route('address').GetCityDistrictSlugAction::run($address),
        ]);
    }
}
