<?php

namespace Tests\Feature\Hotel;

use App\User;
use Domain\Hotel\Actions\MinimumCostsCalculation;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Models\HotelType;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Period;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CostsCalculationTest extends TestCase
{
    use DatabaseTransactions;

    protected Hotel $hotel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generateHotelWithCosts();
    }

    public function testMinimumCostsCalculationAction(): void
    {
        /** @var MinCostsData[] $calcResult */
        $calcResult = MinimumCostsCalculation::run(HotelData::fromModel($this->hotel));
        $this->assertCount(3, $calcResult);
        $this->assertEquals(111.0, $calcResult[0]->value);
        $this->assertEquals(444.0, $calcResult[1]->value);
        $this->assertEquals(777.0, $calcResult[2]->value);
    }

    protected function generateHotelWithCosts(): Hotel
    {
        User::factory()->createOne();
        HotelType::factory()->createOne();
        /** @var Hotel $hotel */
        $hotel = Hotel::withoutEvents(fn () => Hotel::factory()->createOne());

        /** @var \Domain\Room\Models\Room[] $rooms */
        $rooms = Room::withoutEvents(fn () => Room::factory()->count(10)->create([
            'hotel_id' => $hotel->id,
        ]));

        /** @var CostType[] $costTypes */
        $costTypes = CostType::factory()->count(3)->state(new Sequence(
            ['sort' => 1],
            ['sort' => 2],
            ['sort' => 3],
        ))->create();
        $cost = 111;
        foreach ($costTypes as $key => $costType) {
            /** @var Period[] $periods */
            $periods = Period::factory()->count(3)->create([
                'cost_type_id' => $costType->id,
            ]);
            Cost::factory()->count(3)->state(new Sequence([
                'room_id' => $rooms[$key]->id,
                'period_id' => $periods[0]->id,
                'value' => $cost,
            ],
                [
                    'room_id' => $rooms[$key]->id,
                    'period_id' => $periods[0]->id,
                    'value' => $cost * 2,
                ],
                [
                    'room_id' => $rooms[$key]->id,
                    'period_id' => $periods[0]->id,
                    'value' => $cost * 3,
                ]))->create();
            $cost += 333;
        }
        $hotel->refresh();
        $this->hotel = $hotel;

        return $this->hotel;
    }
}
