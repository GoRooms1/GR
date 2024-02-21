<?php

declare(strict_types=1);

namespace Domain\Review\DataTransferObjects;

use Domain\Review\Models\Rating;
use Domain\Review\Models\Review;
use Illuminate\Support\Carbon;

final class RatingCardData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public float $value,
        public int $review_id,
        public int $category_id,
        public string $category_name,       
    ) {
    }

    public static function fromModel(Rating $rating): self
    {
        return self::from([
            ...$rating->toArray(), 
            'category_name' => $rating->category->name,
        ]);
    }
}
