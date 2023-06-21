<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Hotel\Models\HotelType;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class HotelTypeSimpleData extends \Parent\DataTransferObjects\Data
{
    public function __construct(        
        public string $name,
        public ?string $single_name,        
    ) {
    }

    public static function fromModel(HotelType $hotelType): self
    {
        return self::from([
            'name' => $hotelType->name,
            'single_name' => $hotelType->single_name,           
        ]);
    }
}
