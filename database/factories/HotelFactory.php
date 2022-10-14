<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\HotelType;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'name' => 'Elysium hotel',
            'description' => $this->faker->realText(50),
            'phone' => $this->faker->phoneNumber(),
            'user_id' => User::first()->id,
            'is_popular' => $this->faker->boolean(),
            'type_id' => HotelType::first()->id,
            'show' => true,
            'old_moderate' => true,
            'email' => $this->faker->email(),
        ];
    }
}
