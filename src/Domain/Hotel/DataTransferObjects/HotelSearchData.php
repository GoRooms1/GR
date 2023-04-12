<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Hotel\Models\Hotel;

final class HotelSearchData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $name,       
        public ?string $city,    
        public ?string $link,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {  
        return self::from([            
            'name' => $hotel->name,           
            'city' => !is_null($hotel->address) ? ('г. '.$hotel->address->city) : '',
            'link' => route('hotels.show', $hotel),
        ]);
    }
}
