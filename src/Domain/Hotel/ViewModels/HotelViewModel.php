<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\Models\Hotel;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\GetAllRoomsInHotelPaginatedAction;
use Domain\Room\DataTransferObjects\RoomData;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

/**
 * Summary of HotelViewModel
 */
final class HotelViewModel extends \Parent\ViewModels\ViewModel
{       
    public function __construct (
        public Hotel $hotel,
        public string $url = '/hotels'
    ) {       
    }

    /**    
     * @return array{page: PageData}
     */
    public function model(): array {      
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run($this->url)),
        ];
    }

    /**     
     * @return HotelData
     */
    public function hotel(): HotelData
    {        
        return $this->hotel->getData()->include('attrs');
    }

    /**     
     * @return DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
     */
    public function rooms(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return RoomData::collection(GetAllRoomsInHotelPaginatedAction::run($this->hotel));
    }
}
