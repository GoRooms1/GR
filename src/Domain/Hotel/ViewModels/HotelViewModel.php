<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Cache;
use Domain\Hotel\DataTransferObjects\HotelShowData;
use Domain\Hotel\Models\Hotel;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsInHotelPaginateAction;
use Domain\Room\DataTransferObjects\RoomCardData;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Search\Traits\SearchResultTrait;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Support\DataProcessing\Traits\ResultsCaching;

/**
 * Summary of HotelViewModel
 */
final class HotelViewModel extends \Parent\ViewModels\ViewModel
{
    use SearchResultTrait;
    use FiltersParamsTrait;
    use ResultsCaching;

    public function __construct(        
        public Hotel $hotel,
        protected ParamsData $params,        
    ) {
    }

    
    /**     
     * @return PageDescriptionData
     */
    public function page_description(): PageDescriptionData
    {        
        return Cache::remember('hotel-'.$this->hotel->id.'-pd', now()->addDays(7), fn() => PageDescriptionData::fromHotel($this->hotel));
    }

    /**
     * @return HotelShowData
     */
    public function hotel(): HotelShowData
    {        
        return Cache::remember('hotel-'.$this->hotel->id, now()->addDays(7), fn() => HotelShowData::fromModel($this->hotel->load('attrs')));
    }
    
    public function rooms()
    {
        $params = $this->params;
        $params->hotel_id = $this->hotel->id;
        $page = request()->get("page", 1);

        return $this->getCahchedData(
            $params,
            $page,
            'rooms-hotel-'.$this->hotel->id.'-',
            fn() => RoomCardData::collection(FilterRoomsInHotelPaginateAction::run($this->hotel->id, $this->params->rooms))
        );
    }

    public function ad_params() 
    {
        $city = $this->hotel->address->city;

        return [
            'city' => $city,
            'page_type' => 'hotel',
        ];
    }
}
