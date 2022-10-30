<?php

declare(strict_types=1);

namespace Domain\Attribute\Builders;

use App\Models\Room;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Attribute\Model\Attribute
 * @extends Builder<TModelClass>
 */
final class AttributeBuilder extends Builder
{
    public function forHotels(): self
    {
        return $this->where('model', Hotel::class);
    }

    public function forRooms(): self
    {
        return $this->where('model', Room::class);
    }

    public function filtered(): self
    {
        return $this->where('in_filter', true);
    }
}
