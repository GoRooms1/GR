<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Illuminate\Support\Carbon;

final class SimpleMetroData extends \Parent\DataTransferObjects\Data
{
    public function __construct(     
        public ?string $name,        
        public ?string $color,
        public ?string $api_value       
    ) {
    }
}
