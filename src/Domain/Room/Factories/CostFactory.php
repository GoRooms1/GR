<?php

declare(strict_types=1);

namespace Domain\Room\Factories;

use App\Models\Room;
use Domain\Room\Models\Cost;
use Domain\Room\Models\Period;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CostFactory extends Factory
{
    protected $model = Cost::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'room_id' => Room::factory(),
            'period_id' => Period::factory(),
        ];
    }
}
