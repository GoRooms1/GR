<?php

namespace Tests\Feature\Room;

use Bus;
use Carbon\Carbon;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\Jobs\BookRoomJob;
use Domain\Room\Models\Room;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RoomPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexPageOpenesSuccessfully(): void
    {
        $params = ParamsData::getEmptyData();
        $params->room_filter = true;
        $params->hotels->city = 'Москва';

        $rooms = FilterRoomsPaginateAction::run($params);
        
        $response = $this->get(route('rooms.index'));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Objects/Index')             
                ->has('hotels', 0)
                ->has('rooms.data', $rooms->count())
        );
    }
    
    public function testBookingSentSuccessfully(): void
    {       
        Bus::fake();
        $room = Room::moderated()->lowCost()->first();
        $bookingData = [           
            'client_fio' => 'Тест Тест Тест',
            'client_phone' => '+7 (777) 777 77 77',
            'book_type' => 'hour',
            'book_comment' => 'Тестовый комментарий',
            'from_date' => Carbon::now()->format('d.m.Y'),
            'from_time' => Carbon::now()->format('H:i'),
            'to_date' => Carbon::now()->addHours(2)->format('d.m.Y'),
            'to_time' => Carbon::now()->addHours(2)->format('H:i'),
            'hours_count' => 2,
            'days_count' => null,
            'room_id' => $room->id,
            'on_show' => 0,
            'amount' => 1400,
        ];
        $response = $this->from(route('custom.lowcost'))->post(route('rooms.booking'), $bookingData);
        $response->assertRedirect(route('custom.lowcost'));
        $response->assertSessionHasNoErrors();
        Bus::assertDispatched(BookRoomJob::class);
    }
}