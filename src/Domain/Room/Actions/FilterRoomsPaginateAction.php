<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Search\DataTransferObjects\HotelParamsData;
use Domain\Search\DataTransferObjects\RoomParamsData;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Action;

/**
 * @method static LengthAwarePaginator run(RoomParamsData $filters, HotelParamsData $hotelFilters)
 */
final class FilterRoomsPaginateAction extends Action
{
    /**
     * @param  RoomParamsData  $filters
     * @param  HotelParamsData  $hotelFilters
     * @return LengthAwarePaginator
     */
    public function handle(RoomParamsData $filters, HotelParamsData $hotelFilters): LengthAwarePaginator
    {
        /** @var RoomBuilder $rooms */
        $rooms = Room::filter($filters, $hotelFilters);

        /** @var int $perPage */
        $perPage = config('pagination.rooms_per_page');
        
        return $rooms->paginate($perPage);
    }
}
