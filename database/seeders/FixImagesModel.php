<?php

namespace Database\Seeders;

use Domain\Image\Models\Image;
use Illuminate\Database\Seeder;

class FixImagesModel extends Seeder
{
    public function run(): void
    {
        Image::where('model_type', 'App\Models\Hotel')->update(['model_type' => 'Domain\Hotel\Models\Hotel']);
        Image::where('model_type', 'App\Models\Room')->update(['model_type' => 'Domain\Room\Models\Room']);        
    }
}
