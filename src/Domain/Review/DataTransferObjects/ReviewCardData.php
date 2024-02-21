<?php

declare(strict_types=1);

namespace Domain\Review\DataTransferObjects;

use Domain\Media\DataTransferObjects\MediaImageData;
use Domain\Review\Actions\GetReviewAvgRatingValueAction;
use Domain\Review\Models\Review;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class ReviewCardData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $text,
        public ?Carbon $created_at,
        #[DataCollectionOf(RatingCardData::class)]
        public readonly null|Lazy|DataCollection $ratings,
        #[DataCollectionOf(MediaImageData::class)]
        public null|Lazy|DataCollection $images,    
        public int|float $avg_rating,
    ) {
    }

    public static function fromModel(Review $review): self
    {
        return self::from([
            ...$review->toArray(),
            'ratings' => RatingCardData::collection($review->ratings),
            'images' => MediaImageData::collection($review->getMedia('images')),
            'avg_rating' => GetReviewAvgRatingValueAction::run($review),
        ]);
    }
}
