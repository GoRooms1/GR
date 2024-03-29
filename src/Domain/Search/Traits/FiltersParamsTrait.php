<?php

declare(strict_types=1);

namespace Domain\Search\Traits;

use Arr;
use Cache;
use Closure;
use Domain\Address\Actions\GetAllCityMetrosAction;
use Domain\Address\Actions\GetAvailibleCitiesAction;
use Domain\Address\Actions\GetCityAreasAction;
use Domain\Address\Actions\GetCityDistrictsAction;
use Domain\Address\Actions\GetCityTagListAction;
use Domain\Address\DataTransferObjects\CityAreaKeyNameData;
use Domain\Address\DataTransferObjects\CityDistrictKeyNameData;
use Domain\Address\DataTransferObjects\CityKeyNameData;
use Domain\Address\DataTransferObjects\MetroKeyNameData;
use Domain\Attribute\Actions\GetFilteredAttributeCategoriesAction;
use Domain\Attribute\Actions\GetFilteredAttributesAction;
use Domain\Attribute\DataTransferObjects\AttributeCategorySimpleData;
use Domain\Attribute\DataTransferObjects\AttributeSimpleData;
use Domain\Search\Actions\GetNumOfFilteredObjectsAction;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\DataTransferObjects\HotelTypeKeyNameData;
use Domain\Room\Actions\GetCostTypesWithCostRangesKeyNameDataAction;
use Domain\Search\Actions\GetFilterTagTitleAction;
use Domain\Search\DataTransferObjects\FilterTagData;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Str;

trait FiltersParamsTrait
{
    /**
     * @return Closure
     */
    public function cities(): Closure
    {
        return fn() => Cache::remember('params_cities', now()->addDays(30), function () {            
            $cities = collect([]);
            $cities->push(new CityKeyNameData(
                key: 'Москва и МО',
                name: 'Москва и МО',               
            ));
            $cities = $cities->merge(CityKeyNameData::collection(GetAvailibleCitiesAction::run())->toArray());    

            return $cities;
        });
    }

    public function city_tag_list(): Closure
    {
        $city = $this->params->hotels->city;

        return fn() => Cache::remember('city_tag_list_'.$city, now()->addDays(30), function () use ($city) {
            return GetCityTagListAction::run($city);
        });
    }

    /**
     * @return Closure
     */
    public function metros(): Closure
    {
        $city = $this->params->hotels->city;
        $area = $this->params->hotels->area;
        $district = $this->params->hotels->district;

        if ($city == 'Москва и МО')
            $city = 'Москва';
      
        return fn() => Cache::remember('params_metros_'.Str::slug($city).'_'.Str::slug($area).'_'.Str::slug($district), now()->addDays(30), function () use ($city, $area, $district) {            
            return MetroKeyNameData::collection(GetAllCityMetrosAction::run($city, $area, $district));
        });
    }    

    /**
     * @return Closure
     */
    public function hotel_types(): Closure
    {
        return fn() => Cache::remember('params_hotel_types', now()->addDays(30), function () {            
            return HotelTypeKeyNameData::collection(GetAllHotelTypesAction::run());
        });
    }

    /**
     * @return Closure
     */
    public function city_areas(): Closure
    {
        $city = $this->params->hotels->city;

        if ($city == 'Москва и МО')
            $city = 'Москва';
        
        return fn() => Cache::remember('params_areas_'.Str::slug($city), now()->addDays(30), function () use ($city) {            
            return CityAreaKeyNameData::collection(GetCityAreasAction::run($city));
        });
    }

    /**
     * @return Closure
     */
    public function city_districts(): Closure
    {
        $city = $this->params->hotels->city;
        $area = $this->params->hotels->area;

        if ($city == 'Москва и МО')
            $city = 'Москва';
        
        return fn() => Cache::remember('params_districts_'.Str::slug($city).'_'.Str::slug($area), now()->addDays(30), function () use ($city, $area) {            
            return CityDistrictKeyNameData::collection(GetCityDistrictsAction::run($city, $area));
        });
    }

    /**
     * @return Closure
     */
    public function cost_types(): Closure
    {        
        return fn() => Cache::remember('params_cost_types', now()->addDays(30), function () {            
            return GetCostTypesWithCostRangesKeyNameDataAction::run();
        });
    }

    /**    
     * @return Closure
     */
    public function attributes(): Closure
    {        
        return fn() => Cache::remember('params_attributes', now()->addDays(30), function () {            
            return AttributeSimpleData::collection(GetFilteredAttributesAction::run());
        });
    }

    /**
     * @return Closure
     */
    public function attribute_categories(): Closure
    { 
        return fn() => Cache::remember('params_attribute_categories', now()->addDays(30), function () {            
            return AttributeCategorySimpleData::collection(GetFilteredAttributeCategoriesAction::run());
        });
    }

    /**
     * @return Closure
     */
    public function total(): Closure
    {
        return fn(): int => GetNumOfFilteredObjectsAction::run($this->params);
    }

    public function filters() {
        return $this->params;
    }

    public function filter_tags() {
        $tags = [];
        $srcTags = array_merge(
            Arr::dot(['hotels' => $this->params->hotels->toArray()]), 
            Arr::dot(['rooms' => $this->params->rooms->toArray()])
        );
        
        foreach($srcTags as $key => $value) {
            if (empty($value)) 
                continue;
                
            if ($key == 'hotels.city')
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

        return $tags;
    }

    public function has_filters(): bool 
    {
        return true;
    }
}
