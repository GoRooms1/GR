<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\CostPeriod;
use Lorisleiva\Actions\Action;

/**
 * @method static CostPeriod run(array $data)
 */
final class CreateCostPeriodAction extends Action
{   
    /**    
     * @param array $data
     * @return \Domain\Room\Models\CostPeriod
     */
    public function handle(array $data): CostPeriod
    {
        $costPeriod = CostPeriod::where([
            ["value", "=", $data["value"]],
            ["date_from","=", $data["date_from"]],
            ["date_to", "=", $data["date_to"]],
            ["cost_id","=", $data["cost_id"]],
            ["is_active","=", true],
        ])->first();

        if ($costPeriod !== null)
            return $costPeriod;
        
        $costPeriod = CostPeriod::create($data);
        $costPeriod = CalculateDiscountAction::run($costPeriod, intval($data["value"]));
        $dateFrom = $costPeriod->date_from;
        $dateTo = $costPeriod->date_to;

        $costPeriods = CostPeriod::where("cost_id", $costPeriod->cost_id)
            ->where("is_active", true)
            ->where("id", "!=", $costPeriod->id)
            ->where(function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween("date_from", [$dateFrom, $dateTo])
                ->orWhereBetween("date_to", [$dateFrom, $dateTo])
                ->orWhere(function ($query) use ($dateFrom, $dateTo) {
                    $query->where("date_from", ">=", $dateFrom)
                    ->where("date_to", "<=", $dateTo);
                })
                ->orWhere(function ($query) use ($dateFrom, $dateTo) {
                    $query->where("date_from", "<", $dateFrom)
                    ->where("date_to", ">", $dateTo);
                });                
            })
            ->orderBy("date_from", "asc")
            ->get();       

        foreach ($costPeriods as $cost) {
            if ($cost->date_from->greaterThanOrEqualTo($dateFrom) && $cost->date_to->lessThanOrEqualTo($dateTo)) {
                $cost->is_active = false;
                $cost->save();

                continue;
            }

            if ($cost->date_from->lessThan($dateFrom) && $cost->date_to->greaterThan($dateTo)) {
                $newCost = $cost->replicate();
                $newCost->date_from = $dateTo->addDays(1);
                $newCost->save();
                
                $cost->date_to = $dateFrom->subDays(1);
                $cost->save();
               
                continue;              
            }

            if ($cost->date_from->greaterThanOrEqualTo($dateFrom) && $cost->date_from->lessThanOrEqualTo($dateTo)) {
                $cost->date_from = $dateTo->addDays(1);
                $cost->save();
                
                continue;              
            }

            if ($cost->date_to->greaterThanOrEqualTo($dateFrom) && $cost->date_to->lessThanOrEqualTo($dateTo)) {
                $cost->date_to = $dateFrom->subDays(1);
                $cost->save();
               
                continue;
            }

        }

        return $costPeriod;
    }
}
