<?php

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
        \App\Models\Page::create([
            'title' => 'Контакты',
            'slug' => 'contacts',
            'content' => 'Содержимое контактов',
        ]);
        \App\Models\Page::create([
            'title' => 'Правила бронирования',
            'slug' => 'rules',
            'content' => 'Правила бронирования',
        ]);
        \App\Models\Page::create([
            'title' => 'Бонусная программа',
            'slug' => 'bonuse',
            'content' => 'Бонусная программа',
        ]);
        \App\Models\Page::create([
            'title' => 'Пользовательское соглашение',
            'slug' => 'privacy-policy',
            'content' => 'Пользовательское соглашение',
        ]);
    }
}
