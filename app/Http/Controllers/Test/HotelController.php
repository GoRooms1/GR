<?php

namespace App\Http\Controllers\Test;

use Arr;
use Cache;
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
use Domain\Hotel\DataTransferObjects\HotelCardData;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\DataTransferObjects\HotelTypeKeyNameData;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\GetCostTypesWithCostRangesKeyNameDataAction;
use Domain\Search\Actions\GetFilterTagTitleAction;
use Domain\Search\Actions\GetNumOfFilteredObjectsAction;
use Domain\Search\DataTransferObjects\FilterTagData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Parent\Controllers\Controller;
use Support\DataProcessing\Traits\ResultsCaching;

class HotelController extends Controller
{   
    use ResultsCaching;
    public function index(Request $request): Response | ResponseFactory
    {
        $params = ParamsData::fromRequest($request);
       
        if (!$params->filter) {
            $params->hotels->city = 'Москва';            
        }

        $city = $params->hotels->city;
        $area = $params->hotels->area;
        $district = $params->hotels->district;
        $city_area = $params->hotels->area;

        $tags = [];
        $srcTags = array_merge(
            Arr::dot(['hotels' => $params->hotels->toArray()]), 
            Arr::dot(['rooms' => $params->rooms->toArray()])
        );
        
        foreach($srcTags as $key => $value) {
            if (empty($value)) 
                continue;

            $keys = explode(".", $key);
            $tagKey = $keys[1] == 'attrs' ? 'attr_'.$value : $keys[1];

            $tags[] =  new FilterTagData(
                title: GetFilterTagTitleAction::run($tagKey, $value),
                modelType: $keys[0],
                key: $tagKey,
                isAttribute: $keys[1] == 'attrs',
                value: $value,
            );
        }
        
        $page = request()->get("page", 1);        

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
            'hotels' => Cache::remember($this->getHashFor($params, $page, 'hotels'), now()->addDays(7), function () use($params) {            
                return HotelCardData::collection(FilterHotelsPaginateAction::run($params->hotels));
            }),
            'filters' => $params,            
            'filter_tags' => $tags,
        ]);
    }
}
