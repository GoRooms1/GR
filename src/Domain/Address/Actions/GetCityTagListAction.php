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
        if ($city == 'Москва и МО' || $region == 'Московская') 
        {
            $cities->push(new CityTagListData(                    
                name: 'Москва и МО',
                slug: route('home'),
                is_center: true,      
            ));
           
            $cities = $cities->merge($this->getCitiesInRegionData('Московская'));

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
        $regionalCenter = RegionalCenter::where('region', $region)->orWhere('city', $city)->first();        

        $cities->push(new CityTagListData(                    
            name: $regionalCenter ? $regionalCenter->city : $city,
            slug: $this->getCitySlug($regionalCenter ? $regionalCenter->city : $city),
            is_center: true,   
        ));

        if ($city == 'Москва')
            $cities = $cities->merge($this->getCitiesInRegionData('Московская'));
        
        if ($regionalCenter)
            $cities = $cities->merge($this->getCitiesInRegionData($regionalCenter->region));
        
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

    private function getCitiesInRegionData(string $region): \Illuminate\Support\Collection
    {
        $citiesData = collect([]);
        $cities = Address::distinctCity()
            ->select('city', 'region')            
            ->whereHas('hotel')            
            ->whereNotNull('city')
            ->where('region', $region)
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
