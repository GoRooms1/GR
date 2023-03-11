<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\Cost;
use Domain\Room\Models\Room;
use Domain\Room\RoomConfig;
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
        // @todo Static strings to constants
        $costs = $room->costs()->with('period.type')->get()
            ->unique(RoomConfig::PERIOD_TYPE_ID)->sortBy('period.type.sort');

        $collection = new Collection();
        foreach ($costs as $cost) {
            $collection->add($cost);
        }

        return $collection;
    }
}
