<?php

declare(strict_types=1);

namespace Domain\Search\Traits;

use Closure;
use Domain\Address\Actions\GetAllCitiesAction;
use Domain\Address\Actions\GetAllCityMetrosAction;
use Domain\Address\Actions\GetCityAreasAction;
use Domain\Address\Actions\GetCityDistrictsAction;
use Domain\Address\DataTransferObjects\CityAreaKeyNameData;
use Domain\Address\DataTransferObjects\CityDistrictKeyNameData;
use Domain\Address\DataTransferObjects\CityKeyNameData;
use Domain\Address\DataTransferObjects\MetroKeyNameData;
use Domain\Attribute\Actions\GetFilteredAttributeCategoriesAction;
use Domain\Attribute\Actions\GetFilteredAttributesAction;
use Domain\Attribute\DataTransferObjects\AttributeCategoryData;
use Domain\Attribute\DataTransferObjects\AttributeData;
use Domain\Search\Actions\GetNumOfFilteredObjectsAction;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelTypeKeyNameData;
use Domain\Room\Actions\GetCostTypesWithCostRangesKeyNameDataAction;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

trait FiltersParamsTrait
{
    /**
     * @return Closure
     */
    public function cities(): Closure
    {
        return fn() => CityKeyNameData::collection(GetAllCitiesAction::run());
    }

    /**
     * @return Closure
     */
    public function metros(): Closure
    {
        $city = $this->params->hotels->city;
        $area = $this->params->hotels->city_area;
        $district = $this->params->hotels->city_district;

        return fn() => MetroKeyNameData::collection(GetAllCityMetrosAction::run($city, $area, $district));
    }

    /**
     * @return Closure
     */
    public function hotel_types(): Closure
    {
        return fn() => HotelTypeKeyNameData::collection(GetAllHotelTypesAction::run());
    }

    /**
     * @return Closure
     */
    public function city_areas(): Closure
    {
        $city = $this->params->hotels->city;

        return fn() => CityAreaKeyNameData::collection(GetCityAreasAction::run($city));
    }

    /**
     * @return Closure
     */
    public function city_districts(): Closure
    {
        $city = $this->params->hotels->city;
        $city_area = $this->params->hotels->city_area;

        return fn() => CityDistrictKeyNameData::collection(GetCityDistrictsAction::run($city, $city_area));
    }

    /**
     * @return Closure
     */
    public function cost_types(): Closure
    {
        return fn(): DataCollection => GetCostTypesWithCostRangesKeyNameDataAction::run();
    }

    /**    
     * @return Closure
     */
    public function attributes(): Closure
    {
        return fn() => AttributeData::collection(GetFilteredAttributesAction::run());
    }

    /**
     * @return Closure
     */
    public function attribute_categories(): Closure
    {
        return fn() => AttributeCategoryData::collection(GetFilteredAttributeCategoriesAction::run());
    }

    /**
     * @return Closure
     */
    public function total(): Closure
    {
        return fn(): int => GetNumOfFilteredObjectsAction::run($this->params);
    }
}
