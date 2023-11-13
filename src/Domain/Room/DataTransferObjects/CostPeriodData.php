<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Room\Models\CostPeriod;

final class CostPeriodData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public float|string|null $value,
        public float|string|null $avg_value,        
        public int $cost_id,       
    ) {
    }

    public static function fromModel(CostPeriod $costPeriod): self
    {
        return self::from([
            ...$costPeriod->toArray(),         
        ]);
    }
}
