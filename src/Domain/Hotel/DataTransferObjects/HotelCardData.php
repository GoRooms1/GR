<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressSimpleData;
use Domain\Address\DataTransferObjects\MetroSimpleData;
use Domain\Hotel\Actions\MinimumCostsCalculation;
use Domain\Hotel\Models\Hotel;
use Domain\Media\DataTransferObjects\MediaImageData;
use Domain\Room\Actions\GetMaxDiscountAction;
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
        public null|DataCollection $images,
        public AddressSimpleData|null $address,
        public HotelTypeSimpleData|null $type,
        #[DataCollectionOf(MetroSimpleData::class)]
        public readonly null|DataCollection $metros,       
        #[DataCollectionOf(MinCostsData::class)]
        public readonly null|DataCollection $min_costs,
        public readonly ?int $max_discount,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        $minCosts = MinimumCostsCalculation::run($hotel);
        return self::from([
            'id' => $hotel->id,
            'name' => $hotel->name,
            'moderate' => $hotel->moderate,
            'slug' => $hotel->slug,            
            'images' => MediaImageData::collection($hotel->getMedia('images')),
            'address' => AddressSimpleData::from($hotel->address),
            'type' => HotelTypeSimpleData::from($hotel->type),                        
            'metros' => MetroSimpleData::collectionWithAddressSlug($hotel->metros, $hotel->address),            
            'min_costs' => $minCosts,
            'max_discount' => GetMaxDiscountAction::run($minCosts),
        ]);
    }
}
