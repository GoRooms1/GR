<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Hotel\Models\Hotel;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Action;

/**
 * @method static LengthAwarePaginator run(Hotel  $hotel)
 */
final class GetAllRoomsInHotelPaginatedAction extends Action
{
    /**
     * @param  Hotel  $hotel
     * @return LengthAwarePaginator
     */
    public function handle(Hotel $hotel): LengthAwarePaginator
    {
        /** @var int $perPage */
        $perPage = config('pagination.rooms_per_page');

        return $hotel->rooms()->paginate($perPage);
    }
}
