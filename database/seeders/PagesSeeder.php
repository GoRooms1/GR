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
        $page = Page::where('slug', 'contacts')->first();
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

        $page = Page::where('slug', 'privacy-policy')->first();
        if (! $page) {
            Page::create([
                'title' => 'Пользовательское соглашение',
                'slug' => 'privacy-policy',
                'content' => 'Пользовательское соглашение',
            ]);
        }

        Page::firstOrCreate(
            [ 'slug' => 'blog'],
            [
                'title' => 'Статьи',
                'slug' => 'blog',
                'content' => 'Статьи',
                'header' => '',
                'footer' => '',
            ]
        );

        Page::firstOrCreate(
            [ 'slug' => 'instructions'],
            [
                'title' => 'Инструкции',
                'slug' => 'instructions',
                'content' => 'Инструкции',
                'header' => '',
                'footer' => '',
            ]
        );
        
        Page::firstOrCreate(
            [ 'slug' => 'about'],
            [
                'title' => 'О GoRooms',
                'slug' => 'about',
                'content' => 'О GoRooms',
                'header' => '',
                'footer' => '',
            ]
        );
    }
}
