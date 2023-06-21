<?php

declare(strict_types=1);

namespace Domain\Room\Filters;

use Parent\Filters\Filter;

enum Filters: string
{
    case RoomAttributes = 'attrs';
    case IsHot = 'is_hot';
    case LowCost = 'low_cost';
    case PeriodCost = 'period_cost';

    public function createFilter(string $value): Filter
    {
        return match ($this) {
            self::RoomAttributes => new RoomAttributeFilter($value),
            self::IsHot => new IsHotFilter($value),
            self::LowCost => new LowCostFilter($value),
            self::PeriodCost => new PeriodCostFilter($value),
        };
    }
}
