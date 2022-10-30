<?php

declare(strict_types=1);

namespace Domain\Room\Factories;

use Domain\Room\Models\CostType;
use Domain\Room\Models\Period;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PeriodFactory extends Factory
{
    protected $model = Period::class;

    public function definition(): array
    {
        return [
            'start_at' => $this->faker->time('H:i'),
            'end_at' => $this->faker->time('H:i'),
            'description' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'cost_type_id' => CostType::factory(),
        ];
    }
}
