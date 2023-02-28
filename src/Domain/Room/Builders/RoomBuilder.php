<?php

declare(strict_types=1);

namespace Domain\Room\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Room\Models\Room
 * @extends Builder<TModelClass>
 */
final class RoomBuilder extends \Illuminate\Database\Eloquent\Builder
{
    public function hot(): self
    {
        return $this->where('is_hot', true);
    }

    public function moderated(): self
    {
        return $this->whereHas('hotel', function ($query) {
            $query->where('moderate', false)->where('show', true);
        })
        ->where('moderate', false);
    }

    public function lowCost(): self
    {
        return $this->whereHas('costs', function($query) {
            $query
            ->where('value', '!=', '0')
            ->where('value', '<', function($query) {
                $query->from('filter_costs')->where('cost_type_id', 1)->selectRaw('MIN(cost)');
            })            
            ->whereHas('period', function ($query) {
                $query->where('cost_type_id', 1);
            });
        });
    }

    public function hotelIn(array $hotels_ids): self
    {
        return $this->whereIn('hotel_id', $hotels_ids);
    }
    
}
