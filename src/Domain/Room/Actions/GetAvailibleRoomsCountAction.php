<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Cache;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetAvailibleRoomsCountAction extends Action
{
    public function handle(): int
    {        
        $count = Cache::remember('rooms_count', now()->addDays(7), function () {            
            return Room::count();
        });
        
        return intval($count);
    }
}
