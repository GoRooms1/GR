<?php

declare(strict_types=1);

namespace Domain\Filter\Traits;

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
use Domain\Filter\Actions\GetNumOfFilteredObjectsAction;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelTypeKeyNameData;
use Domain\Room\Actions\GetCostTypesWithCostRangesKeyNameDataAction;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

trait FiltersParamsTrait
{
    /**
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function cities(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {
        return CityKeyNameData::collection(GetAllCitiesAction::run());
    }

    /**
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function metros(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {
        $city = $this->params->hotels->city;

        return MetroKeyNameData::collection(GetAllCityMetrosAction::run($city));
    }

    /**
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function hotel_types(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {
        return HotelTypeKeyNameData::collection(GetAllHotelTypesAction::run());
    }

    /**
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function city_areas(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {
        $city = $this->params->hotels->city;

        return CityAreaKeyNameData::collection(GetCityAreasAction::run($city));
    }

    /**
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function city_districts(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {
        $city = $this->params->hotels->city;
        $city_area = $this->params->hotels->city_area;

        return CityDistrictKeyNameData::collection(GetCityDistrictsAction::run($city, $city_area));
    }

    /**
     * @return DataCollection
     */
    public function cost_types(): DataCollection
    {
        return GetCostTypesWithCostRangesKeyNameDataAction::run();
    }

    /**
     * Summary of attributes
     *
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function attributes(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {
        return AttributeData::collection(GetFilteredAttributesAction::run());
    }

    /**
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function attribute_categories(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {
        return AttributeCategoryData::collection(GetFilteredAttributeCategoriesAction::run());
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return GetNumOfFilteredObjectsAction::run($this->params);
    }
}
