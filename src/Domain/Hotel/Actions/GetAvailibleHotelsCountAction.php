<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Cache;
use Domain\Hotel\Models\Hotel;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetAvailibleHotelsCountAction extends Action
{
    /**
     * Availible rooms count
     *
     * @return int
     */
    public function handle(): int
    {
        $count = Cache::remember('hotels_count', now()->addDays(7), function () {            
            return Hotel::count();
        });

        return intval($count);
    }
}
