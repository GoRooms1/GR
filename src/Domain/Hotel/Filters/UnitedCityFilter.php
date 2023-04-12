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

        /** @var array<string> $unitedCities*/
        $unitedCities = GetUnitedCities::run($value)->toArray();

        if (count($unitedCities) == 0) {
            $builder->whereHas('address', function ($q) use ($value) {
                $q->where('city', $value);
            });

            return $next($builder);
        }            
        
        $builder->whereHas('address', function ($q) use ($unitedCities) {
            $q->whereIn('city', $unitedCities);
        });

        return $next($builder);
    }
}
