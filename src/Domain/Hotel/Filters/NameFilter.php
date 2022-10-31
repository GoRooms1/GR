<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class NameFilter extends \Parent\Filters\Filter
{
    /**
     * @param  HotelBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        if ($this->value->length() < 3) {
            return $next($builder);
        }

        $builder->where('name', 'LIKE', '%'.$this->value->toString().'%');

        return $next($builder);
    }
}
