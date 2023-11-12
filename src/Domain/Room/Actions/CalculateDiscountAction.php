<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\Cost;
use Domain\Room\Models\CostsCalendar;
use Lorisleiva\Actions\Action;

/**
 * @method static CostsCalendar run(CostsCalendar $costsCalendar)
 */
final class CalculateDiscountAction extends Action
{    
    /**
     * Calculae discount for Costs Calendar
     * @param \Domain\Room\Models\CostsCalendar $costsCalendar
     * @return \Domain\Room\Models\CostsCalendar
     */
    public function handle(CostsCalendar $costsCalendar, int $value): CostsCalendar
    {
        $cost = Cost::where('id', $costsCalendar->cost_id)->first();    
        $avg_value = $cost->avg_value ?? $cost->value;
        $discount = 0;
        
        if ($avg_value != 0 && $value != 0)
            $discount = 100 - floor($value*100/$avg_value);       
        
        if ($discount < 0 || $discount >= 100) {
            $discount = 0;
        }
        
        $costsCalendar->discount = $discount;
        $costsCalendar->avg_value = $avg_value;
        $costsCalendar->save();

        return $costsCalendar;
    }
}
