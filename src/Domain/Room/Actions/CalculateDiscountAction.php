<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\Cost;
use Domain\Room\Models\CostPeriod;
use Lorisleiva\Actions\Action;

/**
 * @method static CostPeriod run(CostPeriod $costPeriod)
 */
final class CalculateDiscountAction extends Action
{    
    /**
     * Calculae discount for Costs Calendar
     * @param \Domain\Room\Models\CostPeriod $costPeriod
     * @return \Domain\Room\Models\CostPeriod
     */
    public function handle(CostPeriod $costPeriod, int $value): CostPeriod
    {
        $cost = Cost::where('id', $costPeriod->cost_id)->first();    
        $avg_value = $cost->avg_value ?? $cost->value;
        $discount = 0;
        
        if ($avg_value != 0 && $value != 0)
            $discount = 100 - floor($value*100/$avg_value);       
        
        if ($discount < 0 || $discount >= 100) {
            $discount = 0;
        }
        
        $costPeriod->discount = $discount;
        $costPeriod->avg_value = $avg_value;
        $costPeriod->save();

        return $costPeriod;
    }
}
