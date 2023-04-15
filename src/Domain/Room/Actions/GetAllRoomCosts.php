<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Carbon\Carbon;
use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\DataTransferObjects\PeriodData;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static DataCollection<CostData> run(Room $room)
 */
final class GetAllRoomCosts extends Action
{
    /**
     * @param  Room  $room
     * @return DataCollection<CostData>
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
                periods.id as period_id'
            )        
            ->leftJoin('periods','cost_types.id','=','periods.cost_type_id')
            ->leftJoin('costs','costs.period_id','=','periods.id')
            ->where('costs.room_id', $room->id)        
            ->orderBy('cost_types.sort','asc')
            ->get();

        foreach ($minCosts as $minCost) {
            $value = $minCost->value;
            $result[] = new MinCostsData(
                id: $minCost->id,
                name: $minCost->name,
                info: GenerateInfoDescForPeriod::run($minCost->start_at, $minCost->end_at),
                value: $value,
                description: $value > 0 ? '' : 'Не предоставляется',
                period: new PeriodData(
                    id: $minCost->period_id,
                    cost_type_id: $minCost->id,
                    start_at: $minCost->start_at,
                    end_at: $minCost->end_at,
                    description: null,
                    created_at: null,
                    info: null,
                    type: null,
                ),
            );
        }

        return new DataCollection(MinCostsData::class, $result);
    }
}
