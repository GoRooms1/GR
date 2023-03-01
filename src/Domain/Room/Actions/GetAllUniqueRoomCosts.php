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
use Lorisleiva\Actions\Action;

/**
 * @method static Collection<Cost> run(Room $room)
 */
final class GetAllUniqueRoomCosts extends Action
{
    /**
     * @param  Room  $room
     * @return Collection<Cost>
     */
    public function handle(Room $room): Collection
    {
        $costs = $room->costs()->with('period.type')->get()
            ->unique('period.type.id')->sortBy('period.type.sort');
        
        $collection = new Collection();
        foreach ($costs as $cost) {
            $collection->add($cost);
        }
        return $collection;
    }
}
