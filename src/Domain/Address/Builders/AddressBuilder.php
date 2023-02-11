<?php

declare(strict_types=1);

namespace Domain\Address\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Address\Models\Address
 * @extends Builder<TModelClass>
 */
final class AddressBuilder extends Builder
{
    public function joinModeratedObjects(): self
    {
        return $this
            ->join('rooms', 'addresses.hotel_id', 'rooms.hotel_id')
            ->join('hotels', 'addresses.hotel_id', 'hotels.id')
            ->where('rooms.moderate', false)
            ->where('hotels.moderate', false)->where('hotels.show', true)->where('hotels.old_moderate', true);
    }
    
    public function distinctCity(): self
    {
        return $this->distinct('city');     
    }
}
