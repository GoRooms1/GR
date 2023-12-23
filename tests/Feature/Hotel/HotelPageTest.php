<?php

namespace Tests\Feature\Hotel;

use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Actions\FilterRoomsInHotelPaginateAction;
use Domain\Room\Models\Room;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\DataTransferObjects\RoomParamsData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HotelPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = 'Москва';

        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get(route('hotels.index'));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count())
                ->has('rooms', 0)
        );
    }
    
    public function testShowPageOpenesSuccessfully(): void
    {       
        $hotel = Hotel::moderated()->withRooms()->firstOrFail();
        $rooms = FilterRoomsInHotelPaginateAction::run($hotel->id, RoomParamsData::from(RoomParamsData::empty()));       

        $response = $this->get(route('hotels.show', $hotel));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Hotel/Show')
                ->has('rooms.data', $rooms->count(), fn (Assert $model) => $model
                    ->where('hotel_id', $hotel->id)
                    ->etc()
                )
        );
    }    
    
}