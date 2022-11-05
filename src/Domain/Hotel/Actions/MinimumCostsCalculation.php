<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Room\Actions\GenerateInfoDescForPeriod;
use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\DataTransferObjects\CostTypeData;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static DataCollection<CostData> run(HotelData $hotelData)
 */
final class MinimumCostsCalculation extends Action
{
    /**
     * @param  HotelData  $hotelData
     * @return DataCollection<MinCostsData>
     */
    public function handle(HotelData $hotelData): DataCollection
    {
        $result = [];
        /** @var CostTypeData[] $types */
        $types = CostType::orderBy('sort')->get()->map->getData();
        $rooms = $hotelData->rooms;
        $roomsId = $rooms->toCollection()->pluck('id')->toArray();
        /** @var array{cost_type_id: int, value: float, start_at: string, end_at: string}[] $costs */
        $costs = Cost::selectRaw('periods.cost_type_id, min(value) as value, min(periods.start_at) as start_at, min(periods.end_at) as end_at')->join('periods', 'costs.period_id', '=', 'periods.id')->whereIn('room_id', $roomsId)->where('value', '>', 0)->groupBy('periods.cost_type_id')->get()->mapWithKeys(function (Model $item, int $key) {
            /** @var array{cost_type_id: int, value: float, start_at: string, end_at: string} $attributes */
            $attributes = $item->getAttributes();

            return [$attributes['cost_type_id'] => $attributes];
        })->all();

        foreach ($types as $type) {
            if (isset($costs[$type->id])) {
                $result[] = new MinCostsData(
                    id: $type->id,
                    name: $type->name,
                    info: GenerateInfoDescForPeriod::run($costs[$type->id]['start_at'], $costs[$type->id]['end_at']),
                    value: $costs[$type->id]['value']
                );
            }
        }

        return new DataCollection(MinCostsData::class, $result);
    }
}
