<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\Models\Cost;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static DataCollection<int|string, CostData> run(array $rooms)
 */
final class GetMinValuesCostsFromRooms extends Action
{
    /**
     * @param  int[]  $rooms
     * @return DataCollection<(int|string), CostData>
     */
    public function handle(array $rooms): DataCollection
    {
        $costs = Cost::query()
            ->whereIn('room_id', $rooms)->min('value')
            ->with([
                'period.type' => function ($query) {
                    $query->groupBy('id');
                },
            ])->get();

        return CostData::collection($costs);
    }
}
