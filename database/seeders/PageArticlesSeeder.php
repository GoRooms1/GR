<?php

namespace Database\Seeders;

use Domain\Page\Models\Page;
use Illuminate\Database\Seeder;

class PageArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
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
    }
}
