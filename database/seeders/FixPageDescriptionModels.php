<?php

namespace Database\Seeders;

use Domain\PageDescription\Models\PageDescription;
use Illuminate\Database\Seeder;

class FixPageDescriptionModels extends Seeder
{
    public function run(): void
    {
        PageDescription::where('model_type', 'App\Models\Hotel')->update(['model_type' => 'Domain\Hotel\Models\Hotel']);
        PageDescription::where('model_type', 'App\Models\Room')->update(['model_type' => 'Domain\Room\Models\Room']);
    }
}
