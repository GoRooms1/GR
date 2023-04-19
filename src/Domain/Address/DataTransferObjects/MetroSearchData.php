<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetMetroSlugAction;
use Domain\Address\Models\Metro;
use Domain\Search\DataTransferObjects\ParamsData;

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
        return self::from([            
            'name' => $metro->name,
            'color' => $metro->color,            
            'city' => !is_null($metro['city']) ? ('г. '.$metro['city']) : '',
            'link' => route('address').GetMetroSlugAction::run($metro->name, $metro['city']),
        ]);
    }
}
