<?php

declare(strict_types=1);

namespace Domain\Search\ViewModels;

use Arr;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\PageDescription\Actions\GetPageDescriptionFromParamsData;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;

/**
 * Summary of SearchViewModel
 */
final class SearchViewModel extends \Parent\ViewModels\ViewModel
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
        return PageDescriptionData::fromModel(GetPageDescriptionFromParamsData::run($this->params));   
    }

    /**
     * Paginated hotels array
     *
     * @return \Inertia\LazyProp
     */
    public function hotels(): \Inertia\LazyProp
    {       
        return Inertia::lazy(
            fn() => $this->params->isRoomsFilter == true ? 
            HotelData::collection([])
                :
            HotelData::collection(FilterHotelsPaginateAction::run($this->params->hotels))
        );
    }

    
    /**
     * Paginated rooms array
     * @return \Inertia\LazyProp
     */
    public function rooms(): \Inertia\LazyProp
    {        
        return  Inertia::lazy(
            fn() => $this->params->isRoomsFilter == false ? 
            RoomData::collection([]) 
                : 
            RoomData::collection(FilterRoomsPaginateAction::run($this->params->rooms, $this->params->hotels))
        );
    }

    /**
     * @return string
     */
    public function query_string(): string
    {
        return Arr::query($this->params->toArray());
    }

    /**    
     * @return bool
     */
    public function is_rooms_filter(): Bool
    {
        return $this->params->isRoomsFilter;
    }
}
