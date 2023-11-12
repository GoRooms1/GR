<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\CostsCalendar;
use Lorisleiva\Actions\Action;

/**
 * @method static CostsCalendar run(array $data)
 */
final class CreateCostsCalendarAction extends Action
{   
    /**    
     * @param array $data
     * @return \Domain\Room\Models\CostsCalendar
     */
    public function handle(array $data): CostsCalendar
    {        
        $costCalendar = CostsCalendar::where([
            ["value", "=", $data["value"]],
            ["date_from","=", $data["date_from"]],
            ["date_to", "=", $data["date_to"]],
            ["cost_id","=", $data["cost_id"]],
            ["is_active","=", true],
        ])->first();

        if ($costCalendar !== null)
            return $costCalendar;
        
        $costCalendar = CostsCalendar::create($data);
        $costCalendar = CalculateDiscountAction::run($costCalendar, intval($data["value"]));
        $dateFrom = $costCalendar->date_from;
        $dateTo = $costCalendar->date_to;

        $costCalendars = CostsCalendar::where("cost_id", $costCalendar->cost_id)
            ->where("is_active", true)
            ->where("id", "!=", $costCalendar->id)
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

        foreach ($costCalendars as $cost) {
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

        return $costCalendar;
    }
}
