<?php

declare(strict_types=1);

namespace Domain\Room\Filters;

use Domain\Room\Builders\RoomBuilder;
use Illuminate\Database\Eloquent\Builder;

final class PeriodCostFilter extends \Parent\Filters\Filter
{
    /**
     * @param  RoomBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {
        $value = $this->value->toString();
        $params = explode('_', $value);
        $cost_type_id = $params[0] ?? null;
        $fromTo = $params[1] ?? null;
        if ($fromTo == null || $cost_type_id == null) {
            return $next($builder);
        }

        $from = explode('-', $fromTo)[0] ?? 0;
        $to = explode('-', $fromTo)[1] ?? PHP_INT_MAX;

        $builder->whereHas('costs', function ($q) use ($from, $to, $cost_type_id) {
            $q->where('value', '>=', $from)->where('value', '<', $to)->where('value', '!=', 0)
            ->whereHas('period', function ($q) use ($cost_type_id) {
                $q->where('cost_type_id', $cost_type_id);
            });
        });

        return $next($builder);
    }
}
