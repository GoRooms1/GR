<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Carbon\Carbon;
use Domain\Room\Models\CostPeriod;
use Lorisleiva\Actions\Action;

/**
 * @method static mixed run(int $cost_id)
 */
final class GetActualCostPeriodsByCostIdAction extends Action
{    
    /**     
     * @param int $cost_id
     * @return mixed
     */
    public function handle(int $cost_id): mixed
    {
        return CostPeriod::where("cost_id", $cost_id)
            ->where('is_active', true)
            ->where('date_to', '>=', Carbon::now()->startOfDay())
            ->orderBy('date_from', 'asc')
            ->get();
    }
}
