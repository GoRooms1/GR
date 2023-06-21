<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Cache;
use Domain\Address\Models\Address;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetAvailibleCitiesCountAction extends Action
{
    public function handle(): int
    {
        $count = Cache::remember('cities_count', now()->addDays(7), function () {            
            return Address::joinModeratedObjects()->distinctCity()->whereNotNull('city')->count('city');
        });
        
        return intval($count);
    }
}
