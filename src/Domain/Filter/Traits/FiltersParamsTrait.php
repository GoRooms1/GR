<?php

declare(strict_types=1);

namespace Domain\Filter\Traits;

use Domain\Address\Actions\GetAllMetrosByCityNameAction;
use Domain\Address\Actions\GetAllUniqueCitiesAction;
use Domain\Address\DataTransferObjects\CityData;
use Domain\Address\DataTransferObjects\SimpleMetroData;
use Domain\Filter\Actions\GetNumOfFilteredObjectsAction;
use Domain\Address\Actions\GetCityAreasAsParamsAction;
use Domain\Address\Actions\GetCityDistrictsAsParamsAction;
use Domain\Attribute\Actions\GetFilteredAttributeCategoriesAction;
use Domain\Attribute\Actions\GetFilteredAttributesAction;
use Domain\Attribute\DataTransferObjects\AttributeCategoryData;
use Domain\Attribute\DataTransferObjects\AttributeData;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelTypeSelectData;
use Domain\Room\Actions\GetCostTypesWithCostRangesAsParamsAction;

trait FiltersParamsTrait {

    public function cities() {
        return CityData::collection(GetAllUniqueCitiesAction::run());
    }

    public function metros() {
        return SimpleMetroData::collection(GetAllMetrosByCityNameAction::run($this->params['hotels']['city'] ?? null));
    }

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
        return GetCityDistrictsAsParamsAction::run($city, $city_area);
    }

    public function cost_types() {
        return GetCostTypesWithCostRangesAsParamsAction::run();
    }

    public function attributes() {        
        return AttributeData::collection(GetFilteredAttributesAction::run());
    }

    public function attribute_categories() {        
        return AttributeCategoryData::collection(GetFilteredAttributeCategoriesAction::run());
    }

    public function total() {
        return GetNumOfFilteredObjectsAction::run($this->params);
    }
}