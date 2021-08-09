<?php

use Illuminate\Database\Seeder;
use App\Settings;

class AddSeoSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'option' => 'seo_/',
            'value' => '
            <h1 class="section-title orange">отели</h1>
<p>Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности позволяет выполнять важные задания по разработке модели развития. Равным образом укрепление и развитие структуры способствует подготовки и реализации систем массового участия. Таким образом укрепление и развитие структуры позволяет оценить значение систем массового участия. С другой стороны дальнейшее развитие различных форм деятельности требуют определения и уточнения систем массового участия. Не следует, однако забывать, что сложившаяся структура организации позволяет выполнять важные задания по разработке дальнейших направлений развития. Значимость этих проблем настолько очевидна, что начало повседневной работы по формированию позиции требуют от нас анализа новых предложений.</p>
<h1 class="section-title orange">&nbsp;</h1>
<p>Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности позволяет выполнять важные задания по разработке модели развития. Равным образом укрепление и развитие структуры способствует подготовки и реализации систем массового участия. Таким образом укрепление и развитие структуры позволяет оценить значение систем массового участия. С другой стороны дальнейшее развитие различных форм деятельности требуют определения и уточнения систем массового участия. Не следует, однако забывать, что сложившаяся структура организации позволяет выполнять важные задания по разработке дальнейших направлений развития. Значимость этих проблем настолько очевидна, что начало повседневной работы по формированию позиции требуют от нас анализа новых предложений.</p>
            '
        ]);

        Settings::create([
            'option' => 'seo_/hotels',
            'value' => 'HTML код, который можно писать в админке.'
        ]);

        Settings::create([
            'option' => 'seo_/rooms',
            'value' => 'HTML код, который можно писать в админке.'
        ]);

        Settings::create([
            'option' => 'seo_/rooms/hot',
            'value' => 'HTML код, который можно писать в админке.'
        ]);

        \App\Models\PageDescription::create([
            'url' => '/',
            'title' => 'Главная страница',
            'meta_description' => '',
            'meta_keywords' => '',
            'description' => '',
        ]);

        \App\Models\PageDescription::create([
            'url' => '/rooms/',
            'title' => 'Комнаты',
            'meta_description' => '',
            'meta_keywords' => '',
            'description' => '',
            'model_type' => 'App\Models\Room',
        ]);

        \App\Models\PageDescription::create([
            'url' => '/rooms/hot/',
            'title' => 'Топ комнат',
            'meta_description' => '',
            'meta_keywords' => '',
            'description' => '',
            'model_type' => 'App\Models\Room',
        ]);
    }
}
