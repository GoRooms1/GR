<?php

declare(strict_types=1);

namespace Domain\Room\Filters;

use Domain\Room\Builders\RoomBuilder;
use Illuminate\Database\Eloquent\Builder;

final class IsHotFilter extends \Parent\Filters\Filter
{
    /**
     * @param  RoomBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        $builder->hot();
        return $next($builder);
    }
}
