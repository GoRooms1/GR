<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Domain\Hotel\Models\Hotel;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\GetAllRoomsInHotelPaginatedAction;
use Domain\Room\DataTransferObjects\RoomData;

final class HotelViewModel extends \Parent\ViewModels\ViewModel
{
       
    public function __construct (
        public Hotel $hotel,
        public string $url = '/hotels'
    ) {       
    }

    public function model() {      
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run($this->url))->toArray(),
        ];
    }

    public function hotel() {        
        return $this->hotel->load('attrs')->getData();
    }

    public function rooms() {
        return RoomData::collection(GetAllRoomsInHotelPaginatedAction::run($this->hotel));
    }
}
