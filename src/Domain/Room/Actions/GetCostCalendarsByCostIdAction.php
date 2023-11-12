<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\CostsCalendar;
use Lorisleiva\Actions\Action;

/**
 * @method static mixed run(int $cost_id)
 */
final class GetCostCalendarsByCostIdAction extends Action
{    
    /**     
     * @param int $cost_id
     * @return mixed
     */
    public function handle(int $cost_id): mixed
    {
        return CostsCalendar::where("cost_id", $cost_id)->where('is_active', true)->orderBy('date_from', 'desc')->get();
    }
}
