<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Carbon\Carbon;
use Domain\Room\Models\CostPeriod;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class CostPeriodData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public float|string|null $value,
        public float|string|null $avg_value,
        public ?int $discount = null,
        public int $cost_id,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public ?Carbon $date_from,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public ?Carbon $date_to,

    ) {
    }

    public static function fromModel(CostPeriod $costPeriod): self
    {        
        return self::from([
            ...$costPeriod->toArray(),        
        ]);
    }
}
