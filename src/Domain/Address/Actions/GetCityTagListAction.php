<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\DataTransferObjects\CityTagListData;
use Domain\Address\Models\Address;
use Domain\Address\Models\RegionalCenter;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;
use Support\DataProcessing\Traits\CustomStr;

/**
 * @method static Collection run(string|null $city)
 */
final class GetCityTagListAction extends Action
{
    public function handle(string|null $city): \Illuminate\Support\Collection
    {
        $cities = collect([]);

        /** If city is empty return default centers*/
        if (empty($city)) {
            $regionalCenters = RegionalCenter::distinct('city')->select('city')->orderBy('city')->get();

            $cities->push(new CityTagListData(                    
                name: 'Москва и МО',
                slug: route('home'),
                is_center: true,      
            ));

            foreach ($regionalCenters as $center) {
                $cities->push(new CityTagListData(                    
                    name: $center->city,
                    slug: $this->getCitySlug($center->city),
                    is_center: true,          
                ));
            }

            return $cities;
        };

        $address = Address::where('city', $city)->first();        
        $region = $address ? $address->region : null;
           
        /** Moscow and Moscow region */ 
        if ($city == 'Москва и МО' || $region == 'Московская' || $city == 'Москва') 
        {
            $cities->push(new CityTagListData(                    
                name: 'Москва и МО',
                slug: route('home'),
                is_center: true,      
            ));

            $cities->push(new CityTagListData(                    
                name: 'Москва',
                slug: $this->getCitySlug('Москва'),
                is_center: true,      
            ));

            $cities = $cities->merge($this->getCitiesInRegionData(['Московская', 'Москва']));
            $regionalCenters = RegionalCenter::distinct('city')->select('city')->orderBy('city')->get();

            foreach ($regionalCenters as $center) {
                $cities->push(new CityTagListData(                    
                    name: $center->city,
                    slug: $this->getCitySlug($center->city),
                    is_center: true,          
                ));
            }

            return $cities;
        }

        /** Other city */
        $regionalCenters = RegionalCenter::where('region', $region)->orWhere('city', $city)->get();
        
        if ($regionalCenters->count() > 0) 
        {
            $regionalCenter = $regionalCenters->first();            
            
            $cities->push(new CityTagListData(                    
                name: $regionalCenter->city,
                slug: $this->getCitySlug($regionalCenter->city),
                is_center: true,   
            ));

            $cities = $cities->merge($this->getCitiesInRegionData($regionalCenters->pluck('region')->all()));
        }
        
        /** Add Other regional centers */
        $regionalCenters = RegionalCenter::distinct('city')
            ->select('city')
            ->whereNot('city', $city)           
            ->get();
        
        $otherCities = collect([]);

        $otherCities->push(new CityTagListData(                    
            name: 'Москва и МО',
            slug: route('home'),
            is_center: true,      
        ));

        $otherCities->push(new CityTagListData(                    
            name: 'Москва',
            slug: $this->getCitySlug('Москва'),
            is_center: true,      
        ));

        foreach ($regionalCenters as $center) {
            $cities->push(new CityTagListData(                    
                name: $center->city,
                slug: $this->getCitySlug($center->city),
                is_center: true,          
            ));
        }

        $cities = $cities->merge($otherCities->sortBy('name'));        
        
        return $cities;
    }

    private function getCitiesInRegionData(array $regions): \Illuminate\Support\Collection
    {
        $citiesData = collect([]);
        $cities = Address::distinctCity()
            ->select('city', 'region')            
            ->whereHas('hotel')           
            ->whereNotNull('city')
            ->whereIn('region', $regions)
            ->whereNotIn('city', $regions)
            ->orderBy('city')
            ->get();

        foreach ($cities as $city) {
            $citiesData->push(new CityTagListData(                    
                name: $city->city,
                slug: $this->getCitySlug($city->city),
                is_center: false,          
            ));
        }

        return $citiesData;
    }

    private function getCitySlug(string $city): string {
        return route('address').'/'.CustomStr::getCustomSlug($city);
    }
}
