<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Filter\DataTransferObjects\HotelParamsData;
use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Action;

/**
 * @method static LengthAwarePaginator run(HotelParamsData $filters)
 */
final class FilterHotelsPaginateAction extends Action
{
    /**
     * @param  HotelParamsData  $filters   
     * @return LengthAwarePaginator
     */
    public function handle(HotelParamsData $filters): LengthAwarePaginator
    {      
        /** @var HotelBuilder $hotels */
        $hotels = Hotel::filter($filters);
        
        /** @var int */
        $perPage = config('pagination.hotels_per_page');
       
        return $hotels->paginate($perPage);
    }    
}
