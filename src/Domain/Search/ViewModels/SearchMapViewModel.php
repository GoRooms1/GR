<?php

declare(strict_types=1);

namespace Domain\Search\ViewModels;

use Arr;
use Domain\Hotel\Actions\FilterHotelsOnMapAction;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\DataTransferObjects\HotelMapData;
use Domain\PageDescription\Actions\GetPageDescriptionFromParamsData;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsInHotelAction;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;

final class SearchMapViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    use SearchResultTrait;

    /**
     * @param  ParamsData  $params     
     */
    public function __construct(
        protected ParamsData $params,       
    ) {
    }

    /**     
     * @return PageDescriptionData
     */
    public function page_description(): PageDescriptionData
    {        
        $paramsData = $this->params;
        $paramsData->isRoomsFilter = true;
        return PageDescriptionData::fromModel(GetPageDescriptionFromParamsData::run($paramsData));   
    }
    
    /**
     * All rooms array
     * @return \Inertia\LazyProp
     */
    public function rooms(): \Inertia\LazyProp
    {  
        if (is_null($this->params->hotel_id))
            return Inertia::lazy(fn() => []);
        
        return Inertia::lazy(fn() => RoomData::collection(FilterRoomsInHotelAction::run($this->params->hotel_id, $this->params->rooms)));
    }

    /**
     * Filtered hotels array
     * @return \Inertia\LazyProp
     */
    public function hotels(): \Inertia\LazyProp
    {       
        return Inertia::lazy(fn() => HotelMapData::fromCollectionWithFilters(FilterHotelsOnMapAction::run($this->params->hotels, $this->params->rooms), $this->params));
    }        
    
    /**
     * @return string
     */
    public function query_string(): string
    {
        return Arr::query($this->params->toArray());
    }    
}
