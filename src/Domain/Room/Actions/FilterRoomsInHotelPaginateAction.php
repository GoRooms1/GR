<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Search\DataTransferObjects\RoomParamsData;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Action;

/**
 * @method static LengthAwarePaginator run(int $hotel_id, RoomParamsData $filters)
 */
final class FilterRoomsInHotelPaginateAction extends Action
{
    /**
     * @param  int $hotel_id
     * @param  RoomParamsData  $filters     
     * @return LengthAwarePaginator
     */
    public function handle(int $hotel_id, RoomParamsData $filters): LengthAwarePaginator
    {
        /** @var RoomBuilder $rooms */
        $rooms = Room::filterForHotels($filters)->where('hotel_id', $hotel_id);

        /** @var int $perPage */
        $perPage = config('pagination.rooms_per_page');
        
        return $rooms->paginate($perPage);
    }
}
