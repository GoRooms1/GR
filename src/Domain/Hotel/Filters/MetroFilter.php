<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class MetroFilter extends \Parent\Filters\Filter
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

        $builder->whereHas('metros', function($q) use ($value) {
            $q->where('name', $value);
        });

        return $next($builder);
    }
}
