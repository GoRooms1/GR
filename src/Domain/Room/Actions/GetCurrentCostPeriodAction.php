<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Carbon\Carbon;
use Domain\Room\Models\CostPeriod;
use Lorisleiva\Actions\Action;

/**
 * @method static CostPeriod run(?int $cost_id)
 */
final class GetCurrentCostPeriodAction extends Action
{    
    public function handle(?int $cost_id): CostPeriod|null
    {        
        if ($cost_id === null)
            return null;

        $costPeriod = CostPeriod::where("cost_id", $cost_id)
            ->where("is_active", true)
            ->where('date_from', '<=', Carbon::now()->startOfDay())
            ->where('date_to', '>=', Carbon::now()->startOfDay())
            ->first();

        return $costPeriod;
    }
}
