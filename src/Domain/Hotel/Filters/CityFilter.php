<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Address\Models\Address;
use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class CityFilter extends \Parent\Filters\Filter
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

        if ($value == 'Москва и МО') {
            $builder->whereHas('address', function ($q) {
                $q->where('city', 'Москва')->orWhere('region', 'Московская');
            });            

            return $next($builder);
        }

        $builder->whereHas('address', function ($q) use ($value) {
            $q->where('city', $value);
        });

        return $next($builder);
    }
}
