<?php

declare(strict_types=1);

namespace Domain\Search\ViewModels;

use Arr;
use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\FilterRoomsAction;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

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
     * @return array{page: PageData}
     */
    public function model(): array
    {
        if ($this->params->isRoomsFilter == true)
            return [
                'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/rooms')),
            ];
        
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/hotels')),
        ];       
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
