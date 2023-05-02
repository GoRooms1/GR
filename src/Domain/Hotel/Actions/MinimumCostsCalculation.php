<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use DB;
use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Actions\GenerateInfoDescForPeriod;
use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\Models\CostType;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static DataCollection<CostData> run(Hotel $hotel)
 */
final class MinimumCostsCalculation extends Action
{
    /**
     * @param  Hotel  $hotel
     * @return DataCollection<MinCostsData>
     */
    public function handle(Hotel $hotel): DataCollection
    {
        $result = [];

        $minCosts = CostType::selectRaw('cost_types.id, cost_types.name, min(periods.start_at) as start_at, min(periods.end_at) as end_at, IFNULL(MIN(costs.value), 0) AS value')
            ->leftJoin('periods','cost_types.id','=','periods.cost_type_id')
            ->leftJoin('costs', function($join) use ($hotel) {
                $join->on('costs.period_id','=', DB::raw('periods.id AND costs.value > 0'))
                ->whereIn('costs.room_id', (function ($query) use ($hotel) {
                    $query->from('rooms')
                        ->select('id')
                        ->where('hotel_id','=', $hotel->id);
                }));                
            })                        
            ->groupBy('cost_types.id','cost_types.name')
            ->orderBy('cost_types.sort','asc')
            ->get();    

        foreach ($minCosts as $minCost) {
            $value = $minCost['value'];
            $result[] = new MinCostsData(
                id: $minCost->id,
                name: $minCost->name,
                info: GenerateInfoDescForPeriod::run($minCost['start_at'], $minCost['end_at']),
                value: $value,
                description: $value > 0 ? '' : 'Не предоставляется',
                period: null,
            );
        }

        return new DataCollection(MinCostsData::class, $result);
    }
}
