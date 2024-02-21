<?php

declare(strict_types=1);

namespace Domain\Review\DataTransferObjects;

use Domain\Review\Models\Rating;


final class RatingAvgData extends \Parent\DataTransferObjects\Data
{
    public function __construct(        
        public float $value,       
        public int $category_id,
        public string $category_name,
    ) {
    }

    public static function fromModel(Rating $rating): self
    {
        return self::from([
            ...$rating->toArray(),            
        ]);
    }
}
