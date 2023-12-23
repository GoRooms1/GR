<?php

namespace Tests\Feature\ObjectsPages;

use DB;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\PageDescription\Models\PageDescription;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Support\DataProcessing\Traits\CustomStr;
use Tests\TestCase;

class AddressPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testCityPageOpenesSuccessfully(): void
    {
        $city = 'Москва';
        $citySlug = CustomStr::getCustomSlug($city);
        $this->checkSlug($city, $citySlug);

        $url = '/address/'.$citySlug;
        $pageDescription = PageDescription::where('slug', $url);

        if (is_null($pageDescription))
            $pageDescription = PageDescription::factory()->createOne([
                'slug' => $url,
                'type' => 'city'
            ]);

        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = $city;
        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get($url);

        $response->assertStatus(200);   
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count(), fn (Assert $model) => $model
                    ->where('address.city', $city)
                    ->etc()
                )
                ->has('rooms', 0)
        );
    }

    public function testAreaPageOpenesSuccessfully(): void
    {
        $city = 'Москва';
        $citySlug = CustomStr::getCustomSlug($city);
        $this->checkSlug($city, $citySlug);

        $area = 'Центральный';
        $areaSlug = CustomStr::getCustomSlug($area);
        $this->checkSlug($area, $areaSlug);
        
        $url = '/address/'.$citySlug.'/area-'.$areaSlug;
        $pageDescription = PageDescription::where('slug', $url);

        if (is_null($pageDescription))
            $pageDescription = PageDescription::factory()->createOne([
                'slug' => $url,
                'type' => 'area'
            ]);

        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = $city;
        $params->hotels->area = $area;
        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get($url);

        $response->assertStatus(200);   
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count(), fn (Assert $model) => $model
                    ->where('address.city', $city)
                    ->where('address.city_area', $area)
                    ->etc()
                )
                ->has('rooms', 0)
        );
    }

    public function testDistrictPageOpenesSuccessfully(): void
    {
        $city = 'Москва';
        $citySlug = CustomStr::getCustomSlug($city);
        $this->checkSlug($city, $citySlug);

        $area = 'Центральный';
        $areaSlug = CustomStr::getCustomSlug($area);
        $this->checkSlug($area, $areaSlug);

        $district = 'Якиманка';
        $districtSlug = CustomStr::getCustomSlug($district);
        $this->checkSlug($district, $districtSlug);
        
        $url = '/address/'.$citySlug.'/area-'.$areaSlug.'/district-'.$districtSlug;
        $pageDescription = PageDescription::where('slug', $url);

        if (is_null($pageDescription))
            $pageDescription = PageDescription::factory()->createOne([
                'slug' => $url,
                'type' => 'district'
            ]);

        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = $city;
        $params->hotels->area = $area;
        $params->hotels->district = $district;
        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get($url);

        $response->assertStatus(200);   
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count(), fn (Assert $model) => $model
                    ->where('address.city', $city)
                    ->where('address.city_area', $area)
                    ->where('address.city_district', $district)
                    ->etc()
                )
                ->has('rooms', 0)
        );
    }

    public function testMetroPageOpenesSuccessfully(): void
    {
        $city = 'Москва';
        $citySlug = CustomStr::getCustomSlug($city);
        $this->checkSlug($city, $citySlug);

        $metro = 'Давыдково';
        $metroSlug = CustomStr::getCustomSlug($metro);
        $this->checkSlug($metro, $metroSlug);
        
        $url = '/address/'.$citySlug.'/metro-'.$metroSlug;
        $pageDescription = PageDescription::where('slug', $url);

        if (is_null($pageDescription))
            $pageDescription = PageDescription::factory()->createOne([
                'slug' => $url,
                'type' => 'metro'
            ]);

        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = $city;
        $params->hotels->metro = $metro;
        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get($url);

        $response->assertStatus(200);   
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count(), fn (Assert $model) => $model
                    ->where('address.city', $city)
                    ->has('metros', fn (Assert $model) => $model
                        ->whereContains('name', $metro)
                        ->etc()
                    )
                    ->etc()
                )
                ->has('rooms', 0)
        );
    }

    private function checkSlug(string $address, string $slug)
    {       
        $addressSlug = DB::table('address_slug')->where('slug', $slug)->first();

        if (is_null($addressSlug)) {
            DB::table('address_slug')->updateOrInsert(['slug' =>  $slug], [
                'address' => $address,
                'slug' => $slug,
            ]);
        }

        return $addressSlug;
    }
    
}