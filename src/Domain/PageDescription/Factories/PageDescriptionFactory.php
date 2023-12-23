<?php

declare(strict_types=1);

namespace Domain\PageDescription\Factories;

use App\User;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PageDescriptionFactory extends Factory
{
    protected $model = PageDescription::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'slug' => $this->faker->slug(),
            'h1' => $this->faker->sentence(5),
            'meta_description' => $this->faker->sentence(5),
            'meta_keywords' => $this->faker->sentence(5),
            'description' => $this->faker->sentence(5),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type' => 'undefined',
            'model_type' => null,
            'model_id' => null,           
        ];
    }
}
