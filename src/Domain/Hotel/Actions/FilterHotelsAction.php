<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Filter\DataTransferObjects\HotelParamsData;
use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection<int, Hotel> run(HotelParamsData $filters)
 */
final class FilterHotelsAction extends Action
{
    /**
     * @param  HotelParamsData  $filters
     * @return Collection<int, Hotel>
     */
    public function handle(HotelParamsData $filters): Collection
    {
        /** @var HotelBuilder $hotels */
        $hotels = Hotel::filter($filters);

        /** @var Collection<int, Hotel> */
        return $hotels->get();
    }
}
