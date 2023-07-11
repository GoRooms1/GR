<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Address\Actions\GetUnitedCities;
use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class UnitedCityFilter extends \Parent\Filters\Filter
{
    /**
     * @param  HotelBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        $value = $this->value;
        if ($value->length() < 3) {
            return $next($builder);
        }
        
        $city = explode(';', $value->toString())[0];
        $metro = explode(';', $value->toString())[1];
        
        /** @var array<string> $unitedCities*/
        $unitedCities = GetUnitedCities::run($city)->toArray();

        if (count($unitedCities) == 0) {
            $builder->whereHas('address', function ($q) use ($city) {
                $q->where('city', $city);
            });

            return $next($builder);
        }
        
        $builder->whereHas('address', function ($q) use ($unitedCities) {
            $q->whereIn('city', $unitedCities);
        })
        ->whereRaw("(
            SELECT count(*) FROM addresses as addr
            INNER JOIN metros as metr ON (addr.hotel_id = metr.hotel_id)
            WHERE addr.city = '{$city}' AND metr.name = '{$metro}'
        ) > 0");

        return $next($builder);
    }
}
