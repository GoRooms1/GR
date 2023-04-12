<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetCityAreaSlugAction;
use Domain\Address\Models\Address;
use Domain\Search\DataTransferObjects\ParamsData;

final class CityAreaSearchData extends \Parent\DataTransferObjects\Data
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
            'name' => $address->city_area,           
            'city' => 'г. '.$address->city,
            'link' => route('address').GetCityAreaSlugAction::run($address),
        ]);
    }
}
