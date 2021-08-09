<?php

use Illuminate\Database\Seeder;

class AddMapToContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Page::where("title", "Контакты")->first()->update(["content"=>'
        <div class="row">
    <div class="col-lg-5 contacts-info">
    <div class="contacts-list"><a class="contacts-list-item contacts-list-item-tel" href="tel:+74955996674"> +7 (495) 599 66 74&nbsp; &nbsp; &nbsp;info@gorooms.ru</a>
    <p class="contacts-list-item contacts-list-item-address">г. Люберцы, квартал 3, дом 57 ул. оф. 1</p>
    </div>
    <div class="text-section">
    <p></p>
    </div>
    </div>
    <div class="col-lg-5 contacts-info">
        <div class="contacts-list">
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A41126df763f7d92380a8f348f43df796fa3e00459fa23bd2f99ec86442d52007&amp;source=constructor" width="500" height="400" frameborder="0"></iframe>
        </div>
    </div>
    <form id="contacts-form" class="form-section" action="/form" method="post">
    <h2 class="section-title">Обратная связь</h2>
    <div class="row">
    <div class="col-lg-4">
    <div class="form-group"><input id="contacts-name" class="form-control form-control-border" name="contacts-name" required="" type="text" placeholder="Имя*" /></div>
    </div>
    <div class="col-lg-4">
    <div class="form-group"><input id="contacts-tel" class="form-control form-control-border" name="contacts-tel" required="" type="tel" placeholder="Тел:* +7 (___) ___ __ __" /></div>
    </div>
    <div class="col-lg-4">
    <div class="form-group"><input id="contacts-email" class="form-control form-control-border" name="contacts-email" type="email" placeholder="E-mail" /></div>
    </div>
    </div>
    <div class="row">
    <div class="offset-xl-4 col-xl-8">
    <div class="form-group"><textarea id="contacts-comment" class="form-control form-control-border" name="contacts-comment" required="" placeholder="Сообщение*"></textarea></div>
    <p class="form-disclaimer">Нажимая &laquo;Отправить&raquo; Вы даете согласие на&nbsp;обработку персональных данных и&nbsp;соглашаетесь c&nbsp;<a href="../../../privacy-policy">пользовательским соглашением и&nbsp;политикой конфиденциальности</a>.</p>
    <button class="btn btn-blue btn-big" type="submit">Отправить</button></div>
    </div>
    </form>
']);
    }
}
