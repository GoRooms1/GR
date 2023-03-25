<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Address;
use Domain\Filter\DataTransferObjects\ParamsData;

final class CitySearchData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $name,       
        public ?string $link,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        /** @var array<string, string|int|bool|null|array<string, string|int|bool|null>> $params */
        $params = ParamsData::empty([
            'hotels' => [
                'city' => $address->city,
            ],
            'isRoomsFilter' => false
        ]);
        
        return self::from([            
            'name' => $address->city,
            'link' => route('hotels.index', $params),
        ]);
    }
}
