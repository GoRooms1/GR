<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

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

/**
 * Summary of HotelViewModel
 */
final class HotelViewModel extends \Parent\ViewModels\ViewModel
{
    use SearchResultTrait;
    use FiltersParamsTrait;

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
        return PageDescriptionData::fromHotel($this->hotel);
    }

    /**
     * @return HotelShowData
     */
    public function hotel(): HotelShowData
    {
        return HotelShowData::fromModel($this->hotel->load('attrs'));
    }

    /**
     * @return DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
     */
    public function rooms(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return RoomCardData::collection(FilterRoomsInHotelPaginateAction::run($this->hotel->id, $this->params->rooms));
    }
}
