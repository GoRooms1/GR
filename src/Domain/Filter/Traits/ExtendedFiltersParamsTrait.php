<?php

declare(strict_types=1);

namespace Domain\Filter\Traits;

use Domain\Address\Actions\GetCityAreasAsParamsAction;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelTypeSelectData;

trait ExtendedFiltersParamsTrait {

    use FiltersParamsTrait;

    public function hotel_types() {
        return HotelTypeSelectData::collection(GetAllHotelTypesAction::run());
    }

    public function city_areas() {
        return GetCityAreasAsParamsAction::run($this->params['hotels']['city'] ?? null);
    }
    
}