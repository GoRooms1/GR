<?php

declare(strict_types=1);

namespace Domain\Category\Factories;

use Domain\Category\Models\Category;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'value' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'hotel_id' => Hotel::factory(),
        ];
    }
}
