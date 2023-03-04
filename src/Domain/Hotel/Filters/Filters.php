<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Parent\Filters\Filter;

enum Filters: string
{
    case Name = 'name';
    case City = 'city';
    case Metro = 'metro';
    case HotelAttributes = 'attributes';
    case Type = 'hotel_type';

    public function createFilter(string $value): Filter
    {        
        return match ($this) {
            self::Name => new NameFilter($value),
            self::City => new CityFilter($value),
            self::Metro => new MetroFilter($value),
            self::HotelAttributes => new HotelAttributeFilter($value),
            self::Type => new TypeFilter($value),
        };
    }
}
