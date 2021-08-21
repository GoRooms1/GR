<?php

use App\Models\PageDescription;
use Illuminate\Database\Seeder;

class FixPageDescriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pageDescriptions = PageDescription::all();
        foreach ($pageDescriptions as $description) {
            if(substr($description->url, -1) == '/' && $description->url != '/') {
                $description->update([
                    'url' => substr($description->url,0,-1)
                ]);
            }
        }

        $pages = ['/', 'hotels', 'rooms', 'rooms/hot'];
        foreach ($pages as $page) {
            $currentPage = PageDescription::where('url', $page)->first();
            if ($currentPage) {
                $currentPage->update([
                    'model_type' => null
                ]);
            } else {
                PageDescription::create([
                    'url' => '/'.$page,
                    'model_type' => null,
                    'title' => 'gorooms.ru'
                ]);
            }
        }
    }
}
