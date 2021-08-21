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

        PageDescription::where('url', '/')->first()->update([
            'model_type' => null
        ]);
        PageDescription::where('url', 'hotels')->first()->update([
            'model_type' => null
        ]);
        PageDescription::where('url', 'rooms')->first()->update([
            'model_type' => null
        ]);
        PageDescription::where('url', 'rooms/hot')->first()->update([
            'model_type' => null
        ]);
    }
}
