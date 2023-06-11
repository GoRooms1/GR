<?php

declare(strict_types=1);

namespace Domain\Search\ViewModels;

use Closure;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\DataTransferObjects\HotelCardData;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\PageDescription\Actions\GetPageDescriptionFromParamsData;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomCardData;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;
use Support\DataProcessing\Traits\ResultsCaching;

/**
 * Summary of SearchViewModel
 */
final class SearchViewModel extends \Parent\ViewModels\ViewModel
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
     * @return Closure
     */
    public function page_description(): Closure
    {        
        return fn() => PageDescriptionData::fromModel(GetPageDescriptionFromParamsData::run($this->params));
    }

    /**
     * Paginated hotels array
     *
     * @return \Inertia\LazyProp
     */
    public function hotels(): \Inertia\LazyProp
    {       
        $params = $this->params;
        $page = request()->get("page", 1);
        
        return Inertia::lazy(
            fn() => $this->params->room_filter == true ? 
            HotelData::collection([])
                :
            $this->getCahchedData($params, $page, 'hotels', fn() => HotelCardData::collection(FilterHotelsPaginateAction::run($params->hotels)))
        );
    }

    
    /**
     * Paginated rooms array
     * @return \Inertia\LazyProp
     */
    public function rooms(): \Inertia\LazyProp
    {        
        $params = $this->params;
        $page = request()->get("page", 1);

        return  Inertia::lazy(
            fn() => $this->params->room_filter == false ? 
            RoomData::collection([]) 
                : 
            $this->getCahchedData($params, $page, 'rooms', fn() => RoomCardData::collection(FilterRoomsPaginateAction::run($this->params->rooms, $this->params->hotels)))
        );
    }

    /**    
     * @return \Closure
     */
    public function objects_type(): Closure {        
        return fn() => $this->params->room_filter ? 'rooms' : 'hotels';
    }
}
