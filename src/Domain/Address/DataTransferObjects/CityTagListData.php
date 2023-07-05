<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Models\Address;
use Support\DataProcessing\Traits\CustomStr;

final class CityTagListData extends \Parent\DataTransferObjects\Data
{
    public function __construct(       
        public ?string $name,
        public ?string $slug,
        public bool $is_center = false,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return self::from([
            'name' => $address->city,
            'slug' => route('address').'/'.CustomStr::getCustomSlug($address->city),
            'is_center' => false,          
        ]);
    }
}
