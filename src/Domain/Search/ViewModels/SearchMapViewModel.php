<?php

declare(strict_types=1);

namespace Domain\Search\ViewModels;

use Closure;
use Domain\Address\Actions\GetMapCenterByCityAction;
use Domain\Hotel\Actions\FilterHotelsOnMapAction;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\DataTransferObjects\HotelMapData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\Actions\GetPageDescriptionFromParamsData;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsInHotelAction;
use Domain\Room\DataTransferObjects\RoomCardData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;
use Support\DataProcessing\Traits\ResultsCaching;

final class SearchMapViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    use SearchResultTrait;
    use ResultsCaching;

    /**
     * @param  ParamsData  $params     
     */
    public function __construct(
        protected ParamsData $params,       
    ) {
    }

    /**     
     * @return PageDescriptionData | null
     */
    public function page_description(): PageDescriptionData | null
    {        
        if ( $this->params->filter)
            return null;

        $paramsData = clone $this->params;
        $paramsData->room_filter = true;
        $pageDescription = PageDescriptionData::fromModel(GetPageDescriptionFromParamsData::run($paramsData));

        if ($pageDescription->title == '' || is_null($pageDescription->title))
            $pageDescription = PageDescriptionData::from(GetPageDescriptionByUrlAction::run('/'));

        return $pageDescription;
    }
    
    /**
     * All rooms array
     * @return \Inertia\LazyProp
     */
    public function rooms(): \Inertia\LazyProp
    {  
        if (is_null($this->params->hotel_id))
            return Inertia::lazy(fn() => []);
        
        $params = $this->params;            
        $page = 'all';
        
        return Inertia::lazy(fn() => $this->getCahchedData(
                $params,
                $page, 
                'rooms-hotel-'.$this->params->hotel_id.'-', 
                fn() => RoomCardData::collection(FilterRoomsInHotelAction::run($this->params->hotel_id, $this->params->rooms))
            )
        );
    }

    /**
     * Filtered hotels array
     * @return \Inertia\LazyProp
     */
    public function hotels(): \Inertia\LazyProp
    {       
        $params = $this->params;
        $page = "all";

        return Inertia::lazy(
            fn() => $this->getCahchedData(
                $params, 
                $page, 
                'map', 
                fn() => HotelMapData::fromCollectionWithFilters(FilterHotelsOnMapAction::run($this->params->hotels, $this->params->rooms), $this->params)
            )
        );
    }
    
    public function map_center(): Closure
    {
        return fn() => GetMapCenterByCityAction::run($this->params->hotels->city);
    }
}
