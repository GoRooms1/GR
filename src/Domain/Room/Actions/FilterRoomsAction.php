<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Search\DataTransferObjects\HotelParamsData;
use Domain\Search\DataTransferObjects\RoomParamsData;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(RoomParamsData $filters, HotelParamsData $hotelFilters)
 */
final class FilterRoomsAction extends Action
{
    /**
     * @param  RoomParamsData  $filters
     * @param  HotelParamsData  $hotelFilters
     * @return Collection<int, Room>
     */
    public function handle(RoomParamsData $filters, HotelParamsData $hotelFilters): Collection
    {
        /** @var RoomBuilder $rooms */
        $rooms = Room::filter($filters, $hotelFilters);

        /** @var Collection<int, Room> */
        return $rooms->get();
    }
}
