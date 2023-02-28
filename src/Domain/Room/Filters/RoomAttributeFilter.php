<?php

declare(strict_types=1);

namespace Domain\Room\Filters;

use DB;
use Domain\Room\Builders\RoomBuilder;
use Illuminate\Database\Eloquent\Builder;

final class RoomAttributeFilter extends \Parent\Filters\Filter
{
    /**
     * @param  RoomBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        $value = intval($this->value->toString());
       
        $builder->whereHas('attrs', function($q) use ($value) {
            $q->where('id', $value);
        });

        return $next($builder);
    }
}
