<?php

namespace Tests\Feature\ObjectsPages;

use Domain\Attribute\Model\Attribute;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CustomSeoPagesTest extends TestCase
{
    use DatabaseTransactions;

    public function testHotPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->rooms->is_hot = true;
        $params->room_filter = true;
        $params->hotels->city = 'Москва';

        $rooms = FilterRoomsPaginateAction::run($params);
        
        $response = $this->get(route('rooms.hot', ['city' => 'Москва']));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels', 0)
                ->has('rooms.data', $rooms->count())
        );
    }

    public function testJacuzziPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->rooms->attrs = [
            optional(Attribute::forRooms()->where('name', 'Джакузи')->first())->id ?? 0
        ];
        $params->room_filter = true;
        $params->hotels->city = 'Москва';

        $rooms = FilterRoomsPaginateAction::run($params);
        
        $response = $this->get(route('custom.jacuzzi'));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels', 0)
                ->has('rooms.data', $rooms->count())
        );
    }

    public function testLowcostPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->rooms->low_cost = true;
        $params->room_filter = true;
        $params->hotels->city = 'Москва';

        $rooms = FilterRoomsPaginateAction::run($params);
        
        $response = $this->get(route('custom.lowcost'));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels', 0)
                ->has('rooms.data', $rooms->count())
        );
    }

    public function testCentrePageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = 'Москва';       
        $params->hotels->area = 'Центральный';

        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get(route('custom.centre'));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count())
                ->has('rooms', 0)
        );
    }

    public function testFiveMinutePageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = 'Москва';       
        $params->hotels->attrs = [
            optional(Attribute::forHotels()->where('name', '5 минут до метро')->first())->id ?? 0
        ];

        $hotels = FilterHotelsPaginateAction::run($params->hotels);
        
        $response = $this->get(route('custom.centre'));

        $response->assertStatus(200);   
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels.data', $hotels->count())
                ->has('rooms', 0)
        );
    }
}