<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Metro;
use Domain\Filter\DataTransferObjects\ParamsData;

final class MetroSearchData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $name,
        public ?string $color,
        public ?string $img,
        public ?string $city,    
        public ?string $link,
    ) {
    }

    public static function fromModel(Metro $metro): self
    {
        /** @var array<string, string|int|bool|null|array<string, string|int|bool|null>> $params */
        $params = ParamsData::empty([
            'hotels' => [
                'city' => !is_null($metro->hotel->address) ? $metro->hotel->address->city : null,
                'metro' => $metro->name,
            ],
            'isRoomsFilter' => false
        ]);
        
        return self::from([            
            'name' => $metro->name,
            'color' => $metro->color,
            'img' => '/img/metro.svg',
            'city' => !is_null($metro->hotel->address) ? ('г. '.$metro->hotel->address->city) : '',
            'link' => route('hotels.index', $params),
        ]);
    }
}
