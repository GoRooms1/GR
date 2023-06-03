<?php

namespace App\Http\Controllers\Test;

use Arr;
use Domain\Address\Actions\GetAllCitiesAction;
use Domain\Address\Actions\GetAllCityMetrosAction;
use Domain\Address\Actions\GetCityAreasAction;
use Domain\Address\Actions\GetCityDistrictsAction;
use Domain\Address\DataTransferObjects\CityAreaKeyNameData;
use Domain\Address\DataTransferObjects\CityDistrictKeyNameData;
use Domain\Address\DataTransferObjects\CityKeyNameData;
use Domain\Address\DataTransferObjects\MetroKeyNameData;
use Domain\Attribute\Actions\GetFilteredAttributeCategoriesAction;
use Domain\Attribute\DataTransferObjects\AttributeCategoryData;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\DataTransferObjects\HotelTypeKeyNameData;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\GetCostTypesWithCostRangesKeyNameDataAction;
use Domain\Search\Actions\GetNumOfFilteredObjectsAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Parent\Controllers\Controller;

class HotelController extends Controller
{   
    public function index(Request $request): Response | ResponseFactory
    {
        $params = ParamsData::fromRequest($request);

        $city = $params->hotels->city;
        $area = $params->hotels->city_area;
        $district = $params->hotels->city_district;
        $city_area = $params->hotels->city_area;

        return Inertia::render('Hotel/Index', [
            'page_description' => PageDescriptionData::fromModel(GetPageDescriptionByUrlAction::run('/hotels')),
            'query_string' => Arr::query($params->toArray()),
            'cities' => CityKeyNameData::collection(GetAllCitiesAction::run()),
            'metros' => MetroKeyNameData::collection(GetAllCityMetrosAction::run($city, $area, $district)),
            'hotel_types' => HotelTypeKeyNameData::collection(GetAllHotelTypesAction::run()),
            'city_areas' => CityAreaKeyNameData::collection(GetCityAreasAction::run($city)),
            'city_districts' => CityDistrictKeyNameData::collection(GetCityDistrictsAction::run($city, $city_area)),
            'cost_types' => GetCostTypesWithCostRangesKeyNameDataAction::run(),
            'attributes' => AttributeCategoryData::collection(GetFilteredAttributeCategoriesAction::run()),
            'total' => GetNumOfFilteredObjectsAction::run($params),
            'hotels' => HotelData::collection(FilterHotelsPaginateAction::run($params->hotels)),
        ]);
    }
}
