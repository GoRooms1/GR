<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

use Domain\Address\Actions\GetSlugFromAddress;
use Domain\Address\Models\Address;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

final class AddressSimpleData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?string $city,       
        public ?string $house,
        public ?string $block,
        public ?string $city_district,
        public ?string $city_area,        
        public ?string $street_with_type,        
        #[DataCollectionOf(AddressSlugData::class)]
        public readonly null|DataCollection $slugs,
    ) {
    }

    public static function fromModel(Address $address): self
    {
        return self::from([
            'city' => $address->city,
            'house' => $address->house,
            'block' => $address->block,
            'city_district' => $address->city_district,
            'city_area' => $address->city_area,
            'street_with_type' => $address->street_with_type,
            'slugs' => GetSlugFromAddress::run($address),
        ]);
    }
}
