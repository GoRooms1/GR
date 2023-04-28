<?php

namespace Database\Seeders;

use Domain\Attribute\Model\Attribute;
use Illuminate\Database\Seeder;

class FixAttributesModel extends Seeder
{
    public function run(): void
    {
        Attribute::where('model', 'App\Models\Hotel')->update(['model' => 'Domain\Hotel\Models\Hotel']);
        Attribute::where('model', 'App\Models\Room')->update(['model' => 'Domain\Room\Models\Room']);
    }
}
