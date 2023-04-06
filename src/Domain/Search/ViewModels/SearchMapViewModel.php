<?php

declare(strict_types=1);

namespace Domain\Search\ViewModels;

use Arr;
use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\FilterRoomsAction;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

/**
 * Summary of SearchMapViewModel
 */
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
     * All hotels array
     *
     * @return DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
     */
    public function hotels(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        if ($this->params->isRoomsFilter == true)
            return HotelData::collection([]);

        return HotelData::collection(FilterHotelsAction::run($this->params->hotels));
    }

    
    /**
     * All rooms array
     * @return DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
     */
    public function rooms(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        if ($this->params->isRoomsFilter == false)
            return RoomData::collection([]);

        return RoomData::collection(FilterRoomsAction::run($this->params->rooms, $this->params->hotels));
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