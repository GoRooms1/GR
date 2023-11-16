<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Carbon\Carbon;
use DB;
use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Actions\GenerateInfoDescForPeriod;
use Domain\Room\Actions\GetCurrentCostPeriodAction;
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

        $minCosts = CostType::selectRaw(
            'cost_types.id, 
            cost_types.name, 
            periods.start_at as start_at, 
            periods.end_at as end_at, 
            LEAST(IFNULL(costs.value, cost_periods.value), IFNULL(cost_periods.value,costs.value)) AS value,
            costs.id as cost_id'          
        )
        ->leftJoin('periods','cost_types.id','=','periods.cost_type_id')
        ->leftJoin('costs', function($join) use ($hotel) {
            $join->on('costs.period_id','=', DB::raw('periods.id AND costs.value > 0'))
            ->whereIn('costs.room_id', (function ($query) use ($hotel) {
                $query->from('rooms')
                    ->select('id')
                    ->where('hotel_id','=', $hotel->id)
                    ->where('moderate', false);
            }));                
        })
        ->leftJoin('cost_periods', function($join) {
            $join->on('costs.id','=', DB::raw('cost_periods.cost_id'))
            ->where('date_from', '<=', Carbon::now()->startOfDay())
            ->where('date_to','>=', Carbon::now()->startOfDay())
            ->where('is_active', true);
        })
        ->orderBy('cost_types.sort','asc')
        ->get();

        $minCosts = $minCosts->unique(function ($item) {
            return $item['id'] . $item['value'];
        })->groupBy('id')->map(function($group) {
            return $group->firstWhere('value', $group->min('value'));
        });
        
        foreach ($minCosts as $minCost) {
            $value = $minCost['value'] ?? 0;
            $cost_id = $minCost['cost_id'];            

            $result[] = new MinCostsData(
                id: $minCost->id,
                name: $minCost->name,
                info: GenerateInfoDescForPeriod::run($minCost['start_at'], $minCost['end_at']),
                value: $value,
                description: $value > 0 ? '' : 'Не предоставляется',
                period: null,
                cost_period: GetCurrentCostPeriodAction::run($cost_id),
            );
        }

        return new DataCollection(MinCostsData::class, $result);
    }
}
