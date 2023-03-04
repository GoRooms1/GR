<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class TypeFilter extends \Parent\Filters\Filter
{
    /**
     * @param  HotelBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        $value = $this->value;
        if (!isset($value)) {
            return $next($builder);
        }

        $builder->where('type_id', $value);

        return $next($builder);
    }
}
