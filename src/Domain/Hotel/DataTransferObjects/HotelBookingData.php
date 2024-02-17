<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Hotel\Models\Hotel;

final class HotelBookingData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $name,       
        public ?string $link,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {  
        return self::from([            
            'name' => $hotel->name,
            'link' => route('hotels.show', $hotel),
        ]);
    }
}
