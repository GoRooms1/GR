<?php

namespace Database\Seeders;

use Domain\Settings\Models\Settings;
use Illuminate\Database\Seeder;

class AddContactsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['option' => 'notify', 'value' => 'info@gorooms.ru'],
            ['option' => 'instagram', 'value' => 'https://instagram.com/walfter'],
            ['option' => 'fb', 'value' => 'https://facebook.com/walfter'],
            ['option' => 'vk', 'value' => 'https://vk.com/rf_ra'],
            ['option' => 'youtube', 'value' => 'https://www.youtube.com/channel/UCGIan3XXUZB-oaEG_rGH91A'],
            ['option' => 'phone', 'value' => '+7 (985) 909-91-23'],
            ['option' => 'phone2', 'value' => '+7 495 969-55-85'],
            ['option' => 'telegram', 'value' => 'https://t.me/telegram'],
            ['option' => 'address', 'value' => '111558, Москва, Напольный проезд, д. 10'],
            ['option' => 'org_name', 'value' => 'ООО «Го Румс»'],
            ['option' => 'ogrn', 'value' => '1217700386738'],
            ['option' => 'inn', 'value' => '7720853164'],
            ['option' => 'kpp', 'value' => '772001001'],
            ['option' => 'bank_name', 'value' => 'АО «Райффайзенбанк», г. Москва'],
            ['option' => 'bank_acc', 'value' => '40702810100000193243'],
            ['option' => 'bank_сorr_acc', 'value' => '30101810200000000700'],
            ['option' => 'bank_bik', 'value' => '044525700'],
            ['option' => 'bank_inn', 'value' => '7744000302'],
            ['option' => 'bank_kpp', 'value' => '770201001'],
        ];

        Settings::upsert($data, ['option']);
    }
}
