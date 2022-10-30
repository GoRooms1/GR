<?php

declare(strict_types=1);

namespace Domain\Room\Factories;

use App\Models\Room;
use Domain\Category\Models\Category;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber(),
            'order' => $this->faker->randomNumber(),
            'moderate' => false,
            'description' => $this->faker->text(),
            'hotel_id' => Hotel::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'is_hot' => $this->faker->boolean(),

            'category_id' => Category::factory(),
        ];
    }
}
