<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetAvailibleCitiesCountAction extends Action
{
    public function handle(): int
    {        
        return Address::selectRaw('DISTINCT city')
            ->join('rooms', 'addresses.hotel_id', 'rooms.hotel_id')
            ->join('hotels', 'addresses.hotel_id', 'hotels.id')
            ->where('rooms.moderate', false)
            ->where('hotels.moderate', false)->where('hotels.show', true)->where('hotels.old_moderate', true)
            ->get()->count();       
    }
}
