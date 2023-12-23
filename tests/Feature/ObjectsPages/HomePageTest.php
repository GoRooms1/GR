<?php

namespace Tests\Feature\ObjectsPages;

use Domain\Hotel\Actions\FilterHotelsOnMapAction;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Room\Actions\FilterRoomsInHotelAction;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use DatabaseTransactions;

    public function testHotelsListPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = 'Москва и МО';

        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get(route('home'));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count())
                ->has('rooms', 0)
        );
    }

    public function testRoomsListPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->room_filter = true;
        $params->hotels->city = 'Москва и МО';
        $params->rooms->low_cost = true;

        $rooms = FilterRoomsPaginateAction::run($params);
        
        $response = $this->get(route('home', ['rooms[low_cost]' => true]));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels', 0)
                ->has('rooms.data', $rooms->count())
        );
    }
    
    public function testMapPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = 'Москва и МО';

        $hotels = FilterHotelsOnMapAction::run($params->hotels, $params->rooms);
        $hotel_id = $hotels->first() ? $hotels->first()->id : 0;   
        $rooms = FilterRoomsInHotelAction::run($hotel_id, $params->rooms);
        
        $response = $this->get(route('home', ['as' => 'map', 'hotel_id' => $hotel_id]));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels', $hotels->count())
                ->has('rooms', $rooms->count())
        );
    }
}