<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressSimpleData;
use Domain\Address\DataTransferObjects\MetroSimpleData;
use Domain\Hotel\Actions\MinimumCostsCalculation;
use Domain\Hotel\Models\Hotel;
use Domain\Media\DataTransferObjects\MediaImageData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class HotelCardData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,        
        public bool $moderate,        
        public ?string $slug,
        #[DataCollectionOf(MediaImageData::class)]     
        public null|Lazy|DataCollection $images,
        public Lazy|AddressSimpleData|null $address,
        public Lazy|HotelTypeSimpleData|null $type,
        #[DataCollectionOf(MetroSimpleData::class)]
        public readonly null|Lazy|DataCollection $metros,       
        #[DataCollectionOf(MinCostsData::class)]
        public readonly null|DataCollection $min_costs,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        return self::from([
            'id' => $hotel->id,
            'name' => $hotel->name,
            'moderate' => $hotel->moderate,
            'slug' => $hotel->slug,            
            'images' => MediaImageData::collection($hotel->getMedia('images')),
            'address' => Lazy::whenLoaded('address', $hotel, fn () => AddressSimpleData::from($hotel->address)),
            'type' => Lazy::whenLoaded('type', $hotel, fn () => HotelTypeSimpleData::from($hotel->type)),                        
            'metros' => Lazy::whenLoaded('metros', $hotel, fn () => MetroSimpleData::collectionWithAddressSlug($hotel->metros, $hotel->address)),            
            'min_costs' => MinimumCostsCalculation::run($hotel),
        ]);
    }
}
