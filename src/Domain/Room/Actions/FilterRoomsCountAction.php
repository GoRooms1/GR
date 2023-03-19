<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Filter\DataTransferObjects\HotelParamsData;
use Domain\Filter\DataTransferObjects\RoomParamsData;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static int run(RoomParamsData $filters, HotelParamsData $hotelFilters)
 */
final class FilterRoomsCountAction extends Action
{
    /**
     * @param  RoomParamsData  $filters
     * @param  HotelParamsData  $hotelFilters     
     * @return int
     */
    public function handle(RoomParamsData $filters, HotelParamsData $hotelFilters): int
    {
        /** @var RoomBuilder $rooms */
        $rooms = Room::filter($filters, $hotelFilters);

        return $rooms->count();
    }
}
