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
}
