<?php

declare(strict_types=1);

namespace Domain\Room\Factories;

use Domain\Room\Models\CostType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CostTypeFactory extends Factory
{
    protected $model = CostType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'sort' => $this->faker->randomNumber(1),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'description' => $this->faker->text(),
            'slug' => $this->faker->slug(),
        ];
    }
}
