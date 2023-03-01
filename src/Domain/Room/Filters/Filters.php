<?php

declare(strict_types=1);

namespace Domain\Room\Filters;

use Domain\Room\Filters\RoomAttributeFilter;
use Parent\Filters\Filter;

enum Filters: string
{
    
    case RoomAttributes = 'attributes';
    case IsHot = 'is_hot';
    case LowCost = 'low_cost';

    public function createFilter(string $value): Filter
    {        
        return match ($this) {           
            self::RoomAttributes => new RoomAttributeFilter($value),
            self::IsHot => new IsHotFilter($value),
            self::LowCost => new LowCostFilter($value),
        };
    }
}
