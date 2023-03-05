<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

final class CostTypeKeyNameData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public int $key,
        public string $name,
        #[DataCollectionOf(FilterCostRangeData::class)]      
        public readonly null|DataCollection $cost_ranges
    ) {
    }    
}
