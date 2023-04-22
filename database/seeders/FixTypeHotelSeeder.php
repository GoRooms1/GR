<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FixTypeHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \Domain\Hotel\Models\HotelType::find(1)->update(["single_name" => 'Отель']);
       \Domain\Hotel\Models\HotelType::find(3)->update(["name" => "Апартаменты", "single_name" => 'Апартаменты']);
    }
}
