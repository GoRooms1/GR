<?php

declare(strict_types=1);

namespace Domain\Room\Filters;

use Domain\Room\Builders\RoomBuilder;
use Illuminate\Database\Eloquent\Builder;

final class LowCostFilter extends \Parent\Filters\Filter
{
    /**
     * @param  RoomBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        $value = $this->value ?? null;
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN) == false) {
            return $next($builder);
        }

        $builder->lowCost();

        return $next($builder);
    }
}
