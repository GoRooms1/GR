<?php

declare(strict_types=1);

namespace Domain\Rooms\Filters;

use Domain\Room\Filters\RoomAttributeFilter;
use Parent\Filters\Filter;

enum Filters: string
{
    
    case RoomAttributes = 'attributes';

    public function createFilter(string $value): Filter
    {        
        return match ($this) {           
            self::RoomAttributes => new RoomAttributeFilter($value),
        };
    }
}
