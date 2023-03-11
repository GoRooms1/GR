<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Hotel\Models\HotelType;

final class HotelTypeKeyNameData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public int $key,
        public string $name,

    ) {
    }

    public static function fromModel(HotelType $hotelType): self
    {
        return self::from([
            'key' => $hotelType->id,
            'name' => $hotelType->name,
        ]);
    }
}
