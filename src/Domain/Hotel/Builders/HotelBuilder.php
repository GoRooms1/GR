<?php

declare(strict_types=1);

namespace Domain\Hotel\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Hotel\Models\Hotel
 * @extends Builder<TModelClass>
 */
final class HotelBuilder extends Builder
{
    public function popular(): self
    {
        return $this->where('is_popular', true);
    }

    public function moderated(): self
    {       
        return $this->where('moderate', false)->where('show', true)->where('old_moderate', true);
    }

    public function withRooms(): self
    {
        return $this->withCount(['rooms' => function ($query) {
            $query->where('moderate', false);
        }])
        ->having('rooms_count', '>', 0);
    }
}
