<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Arr;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\Models\Hotel;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsInHotelPaginateAction;
use Domain\Room\DataTransferObjects\RoomData;
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
     * @return HotelData
     */
    public function hotel(): HotelData
    {
        return $this->hotel->load('attrs')->getData();
    }

    /**
     * @return DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
     */
    public function rooms(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return RoomData::collection(FilterRoomsInHotelPaginateAction::run($this->hotel->id, $this->params->rooms));
    }

    public function query_string(): string
    {
        return Arr::query($this->params->toArray());
    }
}
