<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Filter\DataTransferObjects\HotelParamsData;
use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Models\Hotel;
use Lorisleiva\Actions\Action;

/**
 * @method static int run(HotelParamsData $filters)
 */
final class FilterHotelsCountAction extends Action
{
    /**
     * @param  HotelParamsData $filters
     * @return int
     */
    public function handle(HotelParamsData $filters): int
    {
        /** @var HotelBuilder $hotels */
        $hotels = Hotel::filter($filters);
        
        return $hotels->count();
    }
}
