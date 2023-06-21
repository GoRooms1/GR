<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Search\DataTransferObjects\HotelParamsData;
use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Models\Hotel;
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

        if (!empty($filters->city)) {
            $city = $filters->city == 'Москва и МО' ? 'Москва' : $filters->city;

            $hotels = $hotels->withCount(['address as city_position' => function($query) use ($city) {
                $query->select(\DB::raw("POSITION('".$city."' IN city)"));
            }])
            ->orderByDesc('city_position');
        }        

        return $hotels->paginate($perPage);
    }
}
