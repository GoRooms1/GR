<?php

namespace Database\Seeders;

use Domain\PageDescription\Models\PageDescription;
use Illuminate\Database\Seeder;

class FixRoomsPageDescriptionSeeder extends Seeder
{
    public function run(): void
    {
        PageDescription::where('url', '/rooms')
            ->update([
                'title' => 'Номер на Час [ мини-отель на час, ночь, сутки ]  GoRooms',
                'meta_description' => 'Далеко не каждый отель сдает номера на час, мы собрали все почасовые отели и гостиницы в одном месте. Выбирайте подходящий и бронируйте без комиссий, по лучшим ценам!',
                'meta_keywords' => 'Отель на час Номер на час'
            ]);        
    }
}
