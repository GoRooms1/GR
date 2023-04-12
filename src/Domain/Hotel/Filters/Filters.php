<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Parent\Filters\Filter;

enum Filters: string
{
    case Name = 'name';
    case City = 'city';
    case UnitedCity = 'united_city';
    case CityArea = 'city_area';
    case CityDistrict = 'city_district';
    case Metro = 'metro';
    case HotelAttributes = 'attributes';
    case Type = 'hotel_type';

    /**
     * @param  non-empty-string  $value
     * @return Filter
     */
    public function createFilter(string $value): Filter
    {
        return match ($this) {
            self::Name => new NameFilter($value),
            self::City => new CityFilter($value),
            self::UnitedCity => new UnitedCityFilter($value),
            self::Metro => new MetroFilter($value),
            self::HotelAttributes => new HotelAttributeFilter($value),
            self::Type => new TypeFilter($value),
            self::CityArea => new CityAreaFilter($value),
            self::CityDistrict => new CityDistrictFilter($value),
        };
    }
}
