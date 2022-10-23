<?php

declare(strict_types=1);

namespace Domain\Page\Factories;

use App\User;
use Domain\Page\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->sentence(12),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'header' => $this->faker->word(),
            'footer' => $this->faker->word(),

            'user_id' => User::factory(),
        ];
    }
}
