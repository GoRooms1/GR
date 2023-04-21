<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Search\DataTransferObjects\HotelParamsData;
use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Models\Hotel;
use Domain\Search\DataTransferObjects\RoomParamsData;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection<int, Hotel> run(HotelParamsData $hotelFilters, RoomParamsData $roomFilters)
 */
final class FilterHotelsOnMapAction extends Action
{
    
    /**     
     * @param HotelParamsData $hotelFilters
     * @param RoomParamsData $roomFilters
     * @return Collection
     */
    public function handle(HotelParamsData $hotelFilters, RoomParamsData $roomFilters): Collection
    {
        /** @var HotelBuilder $hotels */
        $hotels = Hotel::setEagerLoads([])
            ->with(['address'])
            ->filterWithRooms($hotelFilters, $roomFilters);

        /** @var Collection<int, Hotel> */
        return $hotels->get();
    }
}
