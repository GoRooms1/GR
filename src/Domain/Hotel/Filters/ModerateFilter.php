<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class ModerateFilter extends \Parent\Filters\Filter
{
    /**
     * @param  HotelBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {        
        if ($this->value != false)
            $builder->where('moderate', true);

        return $next($builder);
    }
}
