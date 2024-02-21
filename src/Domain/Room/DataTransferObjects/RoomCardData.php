<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Attribute\DataTransferObjects\AttributeSimpleData;
use Domain\Category\DataTransferObjects\CategoryData;
use Domain\Hotel\DataTransferObjects\RoomHotelData;
use Domain\Media\DataTransferObjects\MediaImageData;
use Domain\Review\Actions\GetRoomAvgRatingsAction;
use Domain\Review\Actions\GetRoomAvgRatingValueAction;
use Domain\Review\DataTransferObjects\RatingAvgData;
use Domain\Room\Actions\GetAllRoomCosts;
use Domain\Room\Actions\GetMaxDiscountAction;
use Domain\Room\Models\Room;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class RoomCardData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?int $number,
        public ?int $order,
        public ?int $category_id,
        public ?bool $moderate,
        public ?string $description,
        public int $hotel_id,        
        public ?bool $is_hot,
        #[DataCollectionOf(AttributeSimpleData::class)]
        public readonly null|Lazy|DataCollection $attrs,
        #[DataCollectionOf(MediaImageData::class)]
        public null|Lazy|DataCollection $images,        
        public Lazy|RoomHotelData|null $hotel,
        public Lazy|CategoryData|null $category,
        #[DataCollectionOf(RoomCostsData::class)]
        public readonly null|Lazy|DataCollection $costs,
        public readonly ?int $max_discount,
        #[DataCollectionOf(RatingAvgData::class)]
        public null|Lazy|DataCollection $ratings,
        public ?int $reviews_count,
        public float|int $avg_rating,
    ) {
    }

    public static function fromModel(Room $room): self
    {        
        $costs = GetAllRoomCosts::run($room);        
        return self::from([
            ...$room->toArray(),
            'created_at' => $room->created_at,
            'updated_at' => $room->updated_at,           
            'images' => MediaImageData::collection($room->getMedia('images')),
            'attrs' => AttributeSimpleData::collection($room->attrs),            
            'hotel' => RoomHotelData::fromModel($room->hotel),
            'category' => $room->category ? CategoryData::fromModel($room->category) : null,
            'costs' => $costs,
            'max_discount' => GetMaxDiscountAction::run($costs),
            'ratings' => RatingAvgData::collection(GetRoomAvgRatingsAction::run($room)),
            'reviews_count' => $room->reviews->count(),
            'avg_rating' => GetRoomAvgRatingValueAction::run($room),
        ]);
    }
}
