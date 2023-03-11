<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\DataTransferObjects\CostTypeData;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Room;
use Illuminate\Support\Collection;
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
                $costData = new MinCostsData(
                    id: $type->id,
                    name: $type->name,
                    info: '',
                    value: 0,
                    description: 'Не предоставляется'
                );
                $collection->add($costData);
            } else {
                /** @var Cost $cost */
                $cost = $costs->firstWhere('period.type.id', '=', $type->id);
                $costData = MinCostsData::fromModel($cost);
                $collection->add($costData);
            }
        }

        return $collection;
    }
}
