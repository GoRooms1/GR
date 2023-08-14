<?php

namespace Database\Seeders;

use Domain\Settings\Models\Settings;
use Illuminate\Database\Seeder;

class UpdateSeoSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        Settings::where('option', 'seo_/hotels')->update([
            'value' =>
                '<div class="py-4 xl:flex">
                    <div class="xl:w-1/3 pr-2">
                    <h3 class="font-bold mb-4">Основные нюансы выбора гостиницы на час</h3>
                    <div class="text-xs xs:text-sm">
                        <p class="mb-4">
                        Услуга гостиница на час распространена и востребована в отелях
                        разного типа, ведь не всегда целесообразно арендовать номер на
                        сутки, если пробыть в нем необходимо несколько часов. Зачастую, к
                        такой услуге прибегают люди, которые проездом в городе, нужно
                        переждать короткий промежуток времени до следующего отправления,
                        отдохнуть или провести время со второй половинкой. Но как правильно
                        выбирать гостиницу с почасовой оплатой?
                        </p>
                    </div>
                    </div>
                    <div class="xl:w-1/3 px-2">
                    <h3 class="font-bold mb-4">
                        Выбирая, какую снять гостиницу на час, обращают внимание на такие
                        нюансы:
                    </h3>
                    <div class="text-xs xs:text-sm">
                        <ul>
                        <li class="flex mb-2">
                            <div class="mr-2">
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle cx="8" cy="8" r="8" fill="white"></circle>
                                <path
                                d="M8.66309 3.04688L8.57422 10.1904H7.43262L7.33691 3.04688H8.66309ZM7.2959 12.3643C7.2959 12.1592 7.35742 11.986 7.48047 11.8447C7.60807 11.7035 7.79492 11.6328 8.04102 11.6328C8.28255 11.6328 8.46712 11.7035 8.59473 11.8447C8.72689 11.986 8.79297 12.1592 8.79297 12.3643C8.79297 12.5602 8.72689 12.7288 8.59473 12.8701C8.46712 13.0114 8.28255 13.082 8.04102 13.082C7.79492 13.082 7.60807 13.0114 7.48047 12.8701C7.35742 12.7288 7.2959 12.5602 7.2959 12.3643Z"
                                fill="#515561"
                                ></path>
                            </svg>
                            </div>
                            <div>
                            Если человек находится в городе проездом, в рабочей поездке,
                            может потребоваться номер, чтобы отдохнуть перед важным
                            совещанием, встречей или перед отправлением домой.
                            </div>
                        </li>
                        <li class="flex mb-2">
                            <div class="mr-2">
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle cx="8" cy="8" r="8" fill="white"></circle>
                                <path
                                d="M8.66309 3.04688L8.57422 10.1904H7.43262L7.33691 3.04688H8.66309ZM7.2959 12.3643C7.2959 12.1592 7.35742 11.986 7.48047 11.8447C7.60807 11.7035 7.79492 11.6328 8.04102 11.6328C8.28255 11.6328 8.46712 11.7035 8.59473 11.8447C8.72689 11.986 8.79297 12.1592 8.79297 12.3643C8.79297 12.5602 8.72689 12.7288 8.59473 12.8701C8.46712 13.0114 8.28255 13.082 8.04102 13.082C7.79492 13.082 7.60807 13.0114 7.48047 12.8701C7.35742 12.7288 7.2959 12.5602 7.2959 12.3643Z"
                                fill="#515561"
                                ></path>
                            </svg>
                            </div>
                            <div>
                            Если вы рассматриваете номер в гостинице на час перед решением
                            рабочих дел, то выбирать отель стоит недалеко от того места, где
                            вам предстоит появиться. Таким образом, вы сэкономите время на
                            дорогу в пользу отдыха.
                            </div>
                        </li>
                        <li class="flex mb-2">
                            <div class="mr-2">
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle cx="8" cy="8" r="8" fill="white"></circle>
                                <path
                                d="M8.66309 3.04688L8.57422 10.1904H7.43262L7.33691 3.04688H8.66309ZM7.2959 12.3643C7.2959 12.1592 7.35742 11.986 7.48047 11.8447C7.60807 11.7035 7.79492 11.6328 8.04102 11.6328C8.28255 11.6328 8.46712 11.7035 8.59473 11.8447C8.72689 11.986 8.79297 12.1592 8.79297 12.3643C8.79297 12.5602 8.72689 12.7288 8.59473 12.8701C8.46712 13.0114 8.28255 13.082 8.04102 13.082C7.79492 13.082 7.60807 13.0114 7.48047 12.8701C7.35742 12.7288 7.2959 12.5602 7.2959 12.3643Z"
                                fill="#515561"
                                ></path>
                            </svg>
                            </div>
                            <div>
                            Если же место отдыха перед отъездом в другой город, то
                            забронировать отель стоит территориально недалеко от вокзала или
                            аэропорта.
                            </div>
                        </li>
                        <li class="flex mb-2">
                            <div class="mr-2">
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle cx="8" cy="8" r="8" fill="white"></circle>
                                <path
                                d="M8.66309 3.04688L8.57422 10.1904H7.43262L7.33691 3.04688H8.66309ZM7.2959 12.3643C7.2959 12.1592 7.35742 11.986 7.48047 11.8447C7.60807 11.7035 7.79492 11.6328 8.04102 11.6328C8.28255 11.6328 8.46712 11.7035 8.59473 11.8447C8.72689 11.986 8.79297 12.1592 8.79297 12.3643C8.79297 12.5602 8.72689 12.7288 8.59473 12.8701C8.46712 13.0114 8.28255 13.082 8.04102 13.082C7.79492 13.082 7.60807 13.0114 7.48047 12.8701C7.35742 12.7288 7.2959 12.5602 7.2959 12.3643Z"
                                fill="#515561"
                                ></path>
                            </svg>
                            </div>
                            <div>
                            Удобства, которые предлагают мини гостиницы на час, могут
                            существенно отличаться. Если вы рассматриваете вариант, чтобы не
                            просто поспать и отдохнуть, а принять душ, погладить или
                            почистить одежду, покушать, обратите внимание, оказывают ли эти
                            услуги.
                            </div>
                        </li>
                        <li class="flex mb-2">
                            <div class="mr-2">
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle cx="8" cy="8" r="8" fill="white"></circle>
                                <path
                                d="M8.66309 3.04688L8.57422 10.1904H7.43262L7.33691 3.04688H8.66309ZM7.2959 12.3643C7.2959 12.1592 7.35742 11.986 7.48047 11.8447C7.60807 11.7035 7.79492 11.6328 8.04102 11.6328C8.28255 11.6328 8.46712 11.7035 8.59473 11.8447C8.72689 11.986 8.79297 12.1592 8.79297 12.3643C8.79297 12.5602 8.72689 12.7288 8.59473 12.8701C8.46712 13.0114 8.28255 13.082 8.04102 13.082C7.79492 13.082 7.60807 13.0114 7.48047 12.8701C7.35742 12.7288 7.2959 12.5602 7.2959 12.3643Z"
                                fill="#515561"
                                ></path>
                            </svg>
                            </div>
                            <div>
                            Если вы ищите почасовые номера в гостинице с целью отдохнуть,
                            отдавайте предпочтение тихому району, поскольку в шумном центре
                            города отдых вряд ли удастся.
                            </div>
                        </li>
                        </ul>
                    </div>
                    </div>
                    <div class="xl:w-1/3 pl-2">
                    <div class="text-xs xs:text-sm">
                        <p class="mb-4">
                        Также есть и другие параметры, на которые обращают внимание в
                        процессе выбора, поэтому стоит определиться с целями, для чего нужны
                        апартаменты и подбирать подходящий вариант. Актуально, если вы ищите
                        гостиницу на час на двоих, это отличная возможность провести
                        романтическую встречу. Именно в этой целью апартаменты пользуются
                        большим спросом. На нашем сайте можно подобрать наиболее подходящий
                        вариант — представлены все фото. Обращайте внимание, чем оснащено
                        помещение — зачастую, это кровать, телевизор, холодильник,
                        кондиционер, фен. Представлены варианты с арт дизайном, джакузи,
                        туалетными принадлежностями, также могут сервировать стол по
                        предварительному заказу. То есть, удастся подобрать максимально
                        подходящее место для отдыха под ваши пожелания.
                        </p>
                    </div>
                    </div>
                </div>'
        ]);

        Settings::where('option', 'seo_/rooms')->update([
            'value' =>
                '<div class="py-4 xl:flex">
                <div class="xl:w-1/3 pr-2">
                  <h3 class="font-bold mb-4">Нюансы отелей с номерами на час</h3>
                  <div class="text-xs xs:text-sm">
                    <p class="mb-4">
                      Если вас интересует номер на час, обратите внимание, что далеко не
                      во всех отелях эта услуга предоставляется. В этом направлении
                      работают определённые гостиницы, где предложена, в основном, только
                      почасовая аренда, это удобно и выгодно, если нет надобности снимать
                      жильё на сутки и более. Такие номера с почасовой оплатой отличаются
                      категориями и оснащением отеля.
                    </p>
                  </div>
                </div>
                <div class="xl:w-1/3 px-2">
                  <h3 class="font-bold mb-4">Основные категории номеров</h3>
                  <div class="text-xs xs:text-sm">
                    <p class="mb-4">
                      Почасовые номера, представленные компанией GoRooms – это
                      разнообразные предложения, среди которых каждый подберёт подходящий
                      вариант для себя. Обратите внимание, что на нашем сайте можно
                      подобрать гостиницу, территориально расположенную в любой части
                      Москвы, исходя из того, где удобно вам.
                    </p>
                    <p class="mb-4">
                      По типу размещения, представлены отели, апартаменты и гостевые дома.
                      В любой из этих категорий можно подобрать предложение в приемлемой
                      для вас ценовой категории — вариативность цен впечатляет.
                    </p>
                    <p class="mb-4">
                      Все апартаменты я по-разному оснащены, арендуя номер на несколько
                      часов, может быть обеспечено наличие телевизора, кондиционера,
                      ванной, душевой кабины или джакузи, фена и туалетных
                      принадлежностей. По необходимости, предлагается услуга сервировки
                      стола.
                    </p>
                    <p class="mb-4">
                      Если вас интересует почасовая аренда номера для проведения времени
                      вдвоём, то представлены варианты с большим количеством зеркал,
                      круглой кроватью. Снять подобное предложение — это организовать
                      романтический вечер, приятное времяпровождение, смену обстановки.
                    </p>
                  </div>
                </div>
                <div class="xl:w-1/3 pl-2">
                  <h3 class="font-bold mb-4">
                    Преимущество номеров на час от компании GoRooms
                  </h3>
                  <div class="text-xs xs:text-sm">
                    <p class="mb-4">
                      Наша компания — это удобная современная биржа, где размещены
                      различные предложения, чтобы арендовать почасовой номер в отёле.
                      Обратите внимание, что мы представляем объявления заведений разного
                      уровня и категории, предлагая широкую ценовую политику, чтобы каждый
                      клиент подобрал тот вариант, который внешне и по стоимости ему
                      подойдёт.
                    </p>
                    <p class="mb-4">
                      Благодаря наличию удобного фильтра, удастся произвести расширенный
                      поиск, где снять номер на пару часов. Вы сможете отметить, какой
                      район вас интересует, на какой период размещения и на какую цену вы
                      рассчитываете, какие особенности отеля — отдалённость от ближайшей
                      станции метро, наличии паркинга, время регистрации и другое.
                      Рассматривая разные предложения в отёле на час, можно указать ваши
                      пожелания в перечне фильтра и выбирать из представленных вариантов.
                    </p>
                    <p class="mb-4">
                      Если вы ищите данную услугу аренды на несколько часов в обычных
                      гостиницах, отелях, вы вряд ли найдёте что-то подходящее, поэтому
                      обратите внимание на большой каталог нашей биржи. Чтобы поставить
                      бронь на выбранную почасовую аренду номера, позвоните по указанным
                      телефонам или зарегистрируйте личный кабинет.
                    </p>
                    <p class="mb-4">
                      Мы гарантируем высокий комфорт пребывания, отличные условия и
                      сервис, полную конфиденциальность.
                    </p>
                  </div>
                </div>
              </div>'
        ]);
    }
}