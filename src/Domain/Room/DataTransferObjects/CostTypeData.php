<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Room\Models\CostType;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class CostTypeData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public int $sort,
        public ?string $description,
        public ?string $slug,
        #[DataCollectionOf(PeriodData::class)]
        public readonly null|Lazy|DataCollection $periods,
    ) {
    }

    public static function fromModel(CostType $costType): self
    {
        return self::from([
            ...$costType->toArray(),
            'periods' => Lazy::whenLoaded('periods', $costType, fn () => PeriodData::collection($costType->periods)),
        ]);
    }
}
