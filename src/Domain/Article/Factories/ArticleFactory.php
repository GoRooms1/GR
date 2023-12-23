<?php

declare(strict_types=1);

namespace Domain\Article\Factories;

use App\User;
use Domain\Article\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->sentence(12),
            'notice' => $this->faker->sentence(3),
            'published' => true,
            'meta_title' => $this->faker->word(),
            'meta_description' => $this->faker->sentence(3),
            'meta_keywords' => $this->faker->sentence(3),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,         

            'user_id' => User::first() ? User::first()->id : User::factory(),
        ];
    }
}
