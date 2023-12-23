<?php

namespace Tests\Feature\Room;

use App\User;
use Domain\Room\Actions\GetAllRoomCosts;
use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Period;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GetAllRoomCostsTest extends TestCase
{
    use DatabaseTransactions;

    public function testDataGeneratedSuccessfully(): void
    {
        User::factory()->createOne();
        /** @var CostType[] $costTypes */
        $costTypes = CostType::factory()->count(3)->state(new Sequence(
            ['name' => 'test1', 'sort' => 1],
            ['name' => 'test3', 'sort' => 3],
            ['name' => 'test2', 'sort' => 2],
        ))->create();
        /** @var Period[] $periods */
        $periods = Period::factory()->count(9)->state(new Sequence(
            ['cost_type_id' => $costTypes[0]->id],
            ['cost_type_id' => $costTypes[1]->id],
        ))->create();
        /** @var Room $room */
        $room = Room::factory()->createOne();
        Cost::factory()->count(10)->state(new Sequence(
            ['period_id' => $periods[0]->id, 'room_id' => $room->id],
            ['period_id' => $periods[1]->id, 'room_id' => $room->id],
        ))->create();
        /** @var Collection<CostData> $result */
        $result = GetAllRoomCosts::run($room);
        $this->assertCount(CostType::count(), $result);
        $this->assertTrue($result->contains('period_id', 0));
        $this->assertTrue($result->contains(fn (CostData $data) => $data->period?->resolve()->type?->resolve()->name === 'test1'));
        $this->assertTrue($result->contains(fn (CostData $data) => $data->period?->resolve()->type?->resolve()->name === 'test3'));
    }
}
