<?php

namespace Database\Factories;

use App\Models\HotelType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HotelTypeFactory extends Factory
{
    protected $model = HotelType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'sort' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'single_name' => $this->faker->name(),
        ];
    }
}
