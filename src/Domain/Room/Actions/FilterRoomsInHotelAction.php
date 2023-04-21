<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Search\DataTransferObjects\RoomParamsData;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(int $hotel_id, RoomParamsData $filters)
 */
final class FilterRoomsInHotelAction extends Action
{
    /**
     * @param  int $hotel_id
     * @param  RoomParamsData  $filters     
     * @return Collection<int, Room>
     */
    public function handle(int $hotel_id, RoomParamsData $filters): Collection
    {
        /** @var RoomBuilder $rooms */
        $rooms = Room::filterForHotels($filters)->where('hotel_id', $hotel_id);

        /** @var Collection<int, Room> */
        return $rooms->get();
    }
}
