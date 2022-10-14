<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\HotelType;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * Название модели, соответствующей фабрике.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Elysium hotel',
            'description' => $this->faker->realText(50),
            'phone' => $this->faker->phoneNumber,
            'user_id' => User::first()->id,
            'is_popular' => $this->faker->boolean,
            'type_id' => HotelType::first()->id,
            'show' => true,
            'old_moderate' => true,
            'email' => $this->faker->email,
        ];
    }
}
