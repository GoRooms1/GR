<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Carbon\Carbon;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Cost;
use Domain\Room\Models\Room;
use Domain\Search\DataTransferObjects\ParamsData;
use Lorisleiva\Actions\Action;

/**
 * @method static float run(Hotel $hotel, ParamsData $paramsData)
 */
final class MinimumDiscountCostFilteredValueCalculation extends Action
{    
    /**    
     * @param Hotel $hotel
     * @param  ParamsData $paramsData
     * @return float
     */
    public function handle(Hotel $hotel, ParamsData $paramsData): float
    {
        $filters =  $paramsData->rooms;
        
        $minCost = Cost::selectRaw('min(cost_periods.value) as value')
        ->leftJoin('cost_periods','costs.id','=','cost_periods.cost_id')
        ->whereIn('room_id', Room::filterForHotels($filters)->withoutGlobalScopes()->where('hotel_id', $hotel->id)->where('moderate', false)->select('id'))          
        ->where('costs.value', '>', 0)
        ->where('cost_periods.value', '>', 0)
        ->where('cost_periods.is_active', true)
        ->where('cost_periods.date_from', '<=', Carbon::now()->startOfDay())
        ->where('cost_periods.date_to', '>=', Carbon::now()->startOfDay())        
        ->first();
        
        /** @var float */
        return $minCost->value ?? 0;
    }
}
