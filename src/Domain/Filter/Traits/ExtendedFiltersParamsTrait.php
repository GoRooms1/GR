<?php

declare(strict_types=1);

namespace Domain\Filter\Traits;

use Domain\Address\Actions\GetCityAreasAsParamsAction;
use Domain\Address\Actions\GetCityDistrictsAsParamsAction;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelTypeSelectData;

trait ExtendedFiltersParamsTrait {

    use FiltersParamsTrait;

    public function hotel_types() {
        return HotelTypeSelectData::collection(GetAllHotelTypesAction::run());
    }

    public function city_areas() {
        $city = $this->params['hotels']['city'] ?? null;
        return GetCityAreasAsParamsAction::run($city);
    }

    public function city_districts() {
        $city = $this->params['hotels']['city'] ?? null;
        $city_area = $this->params['hotels']['city_area'] ?? null;
        //dd($city, $city_area, GetCityDistrictsAsParamsAction::run($city, $city_area));
        return GetCityDistrictsAsParamsAction::run($city, $city_area);
    }
    
}