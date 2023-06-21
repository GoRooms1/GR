<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

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
            })            
            ->leftJoin('addresses', 'addresses.hotel_id', '=', 'hotels.id')
            ->orderBy(\DB::raw("POSITION('Москва' IN addresses.city)"), 'desc');

            return $next($builder);
        }

        $builder->whereHas('address', function ($q) use ($value) {
            $q->where('city', $value);
        })
        ->leftJoin('addresses', 'addresses.hotel_id', '=', 'hotels.id')
        ->orderBy(\DB::raw("POSITION('".$value."' IN addresses.city)"), 'desc');

        return $next($builder);
    }
}
