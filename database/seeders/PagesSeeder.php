<?php

namespace Database\Seeders;

use Domain\Page\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::where('title', 'Контакты')->first();
        if (! $page) {
            Page::create([
                'title' => 'Контакты',
                'slug' => 'contacts',
                'content' => 'Содержимое контактов',
            ]);
        }

        $page = Page::where('title', 'Правила бронирования')->first();
        if (! $page) {
            Page::create([
                'title' => 'Правила бронирования',
                'slug' => 'rules',
                'content' => 'Правила бронирования',
            ]);
        }

        $page = Page::where('title', 'Бонусная программа')->first();
        if (! $page) {
            Page::create([
                'title' => 'Бонусная программа',
                'slug' => 'bonuse',
                'content' => 'Бонусная программа',
            ]);
        }

        $page = Page::where('title', 'Пользовательское соглашение')->first();
        if (! $page) {
            Page::create([
                'title' => 'Пользовательское соглашение',
                'slug' => 'privacy-policy',
                'content' => 'Пользовательское соглашение',
            ]);
        }

        Page::firstOrCreate(
            [ 'title' => 'Статьи'],
            [
                'title' => 'Статьи',
                'slug' => 'blog',
                'content' => 'Статьи',
                'header' => '',
                'footer' => '',
            ]
        );

        Page::firstOrCreate(
            [ 'title' => 'Инструкции'],
            [
                'title' => 'Инструкции',
                'slug' => 'instructions',
                'content' => 'Инструкции',
                'header' => '',
                'footer' => '',
            ]
        );
    }
}
