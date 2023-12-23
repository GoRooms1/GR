<?php

namespace Domain\Hotel\Factories;

use App\User;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Models\HotelType;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->realText(50),
            'phone' => $this->faker->phoneNumber(),
            'user_id' => User::first()?->id,
            'is_popular' => $this->faker->boolean(),
            'type_id' => HotelType::first()?->id,
            'show' => true,
            'old_moderate' => true,
            'moderate' => false,
            'email' => $this->faker->email(),
        ];
    }
}
