<?php

declare(strict_types=1);

namespace Domain\Filter\Traits;

use Domain\Address\Actions\GetAllCityMetrosAction;
use Domain\Address\Actions\GetAllCitiesAction;
use Domain\Address\DataTransferObjects\CityKeyNameData;
use Domain\Address\DataTransferObjects\MetroKeyNameData;
use Domain\Filter\Actions\GetNumOfFilteredObjectsAction;
use Domain\Address\Actions\GetCityAreasAction;
use Domain\Address\Actions\GetCityDistrictsAction;
use Domain\Address\DataTransferObjects\CityAreaKeyNameData;
use Domain\Address\DataTransferObjects\CityDistrictKeyNameData;
use Domain\Attribute\Actions\GetFilteredAttributeCategoriesAction;
use Domain\Attribute\Actions\GetFilteredAttributesAction;
use Domain\Attribute\DataTransferObjects\AttributeCategoryData;
use Domain\Attribute\DataTransferObjects\AttributeData;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelTypeKeyNameData;
use Domain\Room\Actions\GetCostTypesWithCostRangesKeyNameDataAction;

trait FiltersParamsTrait {

    public function cities() {       
        return CityKeyNameData::collection(GetAllCitiesAction::run());
    }

    public function metros() {
        $city = $this->params['hotels']['city'] ?? null;        
        return MetroKeyNameData::collection(GetAllCityMetrosAction::run($city));
    }

    public function hotel_types() {
        return HotelTypeKeyNameData::collection(GetAllHotelTypesAction::run());
    }

    public function city_areas() {
        $city = $this->params['hotels']['city'] ?? null;        
        return CityAreaKeyNameData::collection(GetCityAreasAction::run($city));
    }

    public function city_districts() {
        $city = $this->params['hotels']['city'] ?? null;
        $city_area = $this->params['hotels']['city_area'] ?? null;               
        return CityDistrictKeyNameData::collection(GetCityDistrictsAction::run($city, $city_area));
    }

    public function cost_types() {
        return GetCostTypesWithCostRangesKeyNameDataAction::run();
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