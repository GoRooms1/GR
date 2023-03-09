<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Metro;
use Illuminate\Support\Carbon;

final class MetroKeyNameData extends \Parent\DataTransferObjects\Data
{
    public function __construct(     
        public ?string $key,
        public ?string $name,        
        public ?string $color,
        public ?string $api_value       
    ) {
    }

    public static function fromModel(Metro $metro): self
    {
        return self::from([
           'key' => $metro->name,
           'name' => $metro->name,
           'color' => $metro->color,
           'api_value' => $metro->api_value,
        ]);
    }
}
