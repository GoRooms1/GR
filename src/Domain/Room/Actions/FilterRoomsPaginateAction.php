<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Search\DataTransferObjects\HotelParamsData;
use Domain\Search\DataTransferObjects\RoomParamsData;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Models\Room;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Action;

/**
 * @method static LengthAwarePaginator run(ParamsData $params)
 */
final class FilterRoomsPaginateAction extends Action
{
    /**
     * @param  ParamsData $params     
     * @return LengthAwarePaginator
     */
    public function handle(ParamsData $params): LengthAwarePaginator
    {        
        $filters = $params->rooms;
        $hotelFilters = $params->hotels;
        
        /** @var RoomBuilder $rooms */
        $rooms = Room::filter($filters, $hotelFilters)->sort($params->sort);

        /** @var int $perPage */
        $perPage = config('pagination.rooms_per_page');
        
        return $rooms->paginate($perPage);
    }
}
