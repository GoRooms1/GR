<?php

namespace Tests\Feature\ObjectsPages;

use DB;
use Domain\PageDescription\Models\PageDescription;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Support\DataProcessing\Traits\CustomStr;
use Tests\TestCase;

class SeoPathRedirectTest extends TestCase
{
    use DatabaseTransactions;

    public function testHomePageOpenesSuccessfully(): void
    {
        $city = 'Москва и МО';
        $citySlug = CustomStr::getCustomSlug($city);
        $this->checkSlug($city, $citySlug);

        $url = '/';      

        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = $city;       
        
        $response = $this->get('/search?'.$params->toQueryString());

        $response->assertStatus(302);
        $response->assertRedirect($url);
    }

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
        
        $response = $this->get('/search?'.$params->toQueryString());

        $response->assertStatus(302);
        $response->assertRedirect($url);
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
        
        $response = $this->get('/search?'.$params->toQueryString());

        $response->assertStatus(302);
        $response->assertRedirect($url);
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
        
        $response = $this->get('/search?'.$params->toQueryString());

        $response->assertStatus(302);
        $response->assertRedirect($url);
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
        
        $response = $this->get('/search?'.$params->toQueryString());

        $response->assertStatus(302);
        $response->assertRedirect($url);
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