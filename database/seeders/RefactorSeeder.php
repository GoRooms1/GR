<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefactorSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(PageContactSeeder::class);
        $this->call(AddContactsSettingsSeeder::class);
        $this->call(FixTypeHotelSeeder::class);
        $this->call(FixPageDescriptionModels::class);
    }
}
