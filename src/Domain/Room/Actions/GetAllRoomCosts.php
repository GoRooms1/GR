<?php

declare(strict_types=1);

namespace Domain\Room\Actions;


use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Room\DataTransferObjects\PeriodData;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static DataCollection<MinCostsData> run(Room $room)
 */
final class GetAllRoomCosts extends Action
{
    /**
     * @param  Room  $room
     * @return DataCollection<MinCostsData>
     */
    public function handle(Room $room): DataCollection
    {
        $result = [];

        $minCosts = CostType::selectRaw(
                'cost_types.id, 
                cost_types.name, 
                periods.start_at, 
                periods.end_at, 
                IFNULL(costs.value, 0) as value,
                periods.id as period_id,
                costs.id as cost_id'
            )        
            ->leftJoin('periods','cost_types.id','=','periods.cost_type_id')
            ->leftJoin('costs','costs.period_id','=','periods.id')
            ->leftJoin('rooms','costs.room_id','=','rooms.id')
            ->where('costs.room_id', $room->id)
            ->where('rooms.moderate', false)
            ->orderBy('cost_types.sort','asc')
            ->orderBy('costs.created_at','desc')
            ->get();
        
        $minCosts = $minCosts->unique('id');
        foreach ($minCosts as $minCost) {
            $value = $minCost['value'];
            $cost_id = $minCost['cost_id'];           

            $result[] = new MinCostsData(
                id: $minCost['id'],
                name: $minCost['name'],
                info: GenerateInfoDescForPeriod::run($minCost['start_at'], $minCost['end_at']),
                value: $value,
                description: $value > 0 ? '' : 'Не предоставляется',
                period: new PeriodData(
                    id: $minCost['period_id'],
                    cost_type_id: $minCost['id'],
                    start_at: $minCost['start_at'],
                    end_at: $minCost['end_at'],
                    description: null,
                    created_at: null,
                    info: null,
                    type: null,
                ),
                cost_period: GetCurrentCostPeriodAction::run($cost_id),
            );
        }

        return new DataCollection(MinCostsData::class, $result);
    }
}
