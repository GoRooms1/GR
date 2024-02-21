<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressSimpleData;
use Domain\Address\DataTransferObjects\MetroSimpleData;
use Domain\Attribute\DataTransferObjects\AttributeSimpleData;
use Domain\Hotel\Actions\MinimumCostsCalculation;
use Domain\Hotel\Models\Hotel;
use Domain\Media\DataTransferObjects\MediaImageData;
use Domain\Review\Actions\GetHotelAvgRatingsAction;
use Domain\Review\Actions\GetHotelAvgRatingValueAction;
use Domain\Review\DataTransferObjects\RatingAvgData;
use Domain\Review\DataTransferObjects\ReviewCardData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class HotelShowData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,        
        public bool $moderate,        
        public ?string $slug,
        public ?string $description,
        #[DataCollectionOf(MediaImageData::class)]     
        public null|DataCollection $images,
        public AddressSimpleData|null $address,
        public HotelTypeSimpleData|null $type,
        #[DataCollectionOf(MetroSimpleData::class)]
        public readonly null|DataCollection $metros,       
        #[DataCollectionOf(AttributeSimpleData::class)]
        public readonly null|DataCollection $attrs,    
        #[DataCollectionOf(MinCostsData::class)]
        public readonly null|DataCollection $min_costs,       
        public ?int $reviews_count,
        public float|int $avg_rating,
        #[DataCollectionOf(ReviewCardData::class)]
        public null|Lazy|DataCollection $reviews,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        return self::from([
            'id' => $hotel->id,
            'name' => $hotel->name,
            'moderate' => $hotel->moderate,
            'slug' => $hotel->slug,
            'description' => $hotel->description,          
            'images' => MediaImageData::collection($hotel->getMedia('images')),
            'address' => AddressSimpleData::from($hotel->address),
            'type' => HotelTypeSimpleData::from($hotel->type),                        
            'metros' => MetroSimpleData::collectionWithAddressSlug($hotel->metros, $hotel->address),
            'attrs' => AttributeSimpleData::collection($hotel->attrs),        
            'min_costs' => MinimumCostsCalculation::run($hotel),            
            'reviews_count' => $hotel->reviews->count(),
            'avg_rating' => GetHotelAvgRatingValueAction::run($hotel),
            'reviews' => ReviewCardData::collection($hotel->reviews)
        ]);
    }
}
