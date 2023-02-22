<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Illuminate\Support\Carbon;

final class CityData extends \Parent\DataTransferObjects\Data
{
    public function __construct(     
        public ?string $region,        
        public ?string $name,             
    ) {
    }
}
