<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class HotelAttributeFilter extends \Parent\Filters\Filter
{
    /**
     * @param  HotelBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        $value = intval($this->value->toString());

        $builder->whereHas('attrs', function ($q) use ($value) {
            $q->where('id', $value);
        });

        return $next($builder);
    }
}
