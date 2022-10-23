<?php

namespace Database\Seeders;

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
        $page = \Domain\Page\Models\Page::where('title', 'Контакты')->first();
        if (! $page) {
            \Domain\Page\Models\Page::create([
                'title' => 'Контакты',
                'slug' => 'contacts',
                'content' => 'Содержимое контактов',
            ]);
        }
        $page = \Domain\Page\Models\Page::where('title', 'Правила бронирования')->first();
        if (! $page) {
            \Domain\Page\Models\Page::create([
                'title' => 'Правила бронирования',
                'slug' => 'rules',
                'content' => 'Правила бронирования',
            ]);
        }
        $page = \Domain\Page\Models\Page::where('title', 'Бонусная программа')->first();
        if (! $page) {
            \Domain\Page\Models\Page::create([
                'title' => 'Бонусная программа',
                'slug' => 'bonuse',
                'content' => 'Бонусная программа',
            ]);
        }
        $page = \Domain\Page\Models\Page::where('title', 'Пользовательское соглашение')->first();
        if (! $page) {
            \Domain\Page\Models\Page::create([
                'title' => 'Пользовательское соглашение',
                'slug' => 'privacy-policy',
                'content' => 'Пользовательское соглашение',
            ]);
        }
    }
}
