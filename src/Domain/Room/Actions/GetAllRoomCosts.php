<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\DataTransferObjects\CostTypeData;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Room;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection<CostData> run(Room $room)
 */
final class GetAllRoomCosts extends Action
{
    /**
     * @param  Room  $room
     * @return Collection<CostData>
     */
    public function handle(Room $room): Collection
    {
        $costs = $room->costs()->with('period.type')->get()->sortBy('type.sort');

        /** @var CostTypeData[] $types */
        $types = CostType::orderBy('sort')->get()->map(fn (CostType $costType) => $costType->getData());

        $collection = new Collection();

        foreach ($types as $type) {
            $check = $costs->contains('period.type.id', $type->id);
            if (! $check) {
                $cost = new CostData(
                    id: null, value: 'Не предоставляется', room_id: $room->id, period_id: 0, created_at: Carbon::now(), period: null, room: RoomData::fromModel($room)
                );
                $collection->add($cost);
            } else {
                /** @var Cost $cost */
                $cost = $costs->firstWhere('period.type.id', '=', $type->id);
                $collection->add($cost->getData());
            }
        }

        return $collection;
    }
}
