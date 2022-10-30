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
}
