<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Cost;
use Domain\Room\Models\Room;
use Domain\Search\DataTransferObjects\ParamsData;
use Lorisleiva\Actions\Action;

/**
 * @method static float run(Hotel $hotel, ParamsData $paramsData)
 */
final class MinimumCostFilteredValueCalculation extends Action
{    
    /**    
     * @param Hotel $hotel
     * @param  ParamsData $paramsData
     * @return float
     */
    public function handle(Hotel $hotel, ParamsData $paramsData): float
    {
        $filters =  $paramsData->rooms;
        
        $minCost = Cost::selectRaw('min(costs.value) as value')        
        ->whereIn('room_id', Room::filterForHotels($filters)->withoutGlobalScopes()->where('hotel_id', $hotel->id)->select('id'))
        ->where('value', '>', 0)
        ->first();
        
        /** @var float */
        return $minCost->value ?? 0;
    }
}
