<template>
  <AppHead :title="page?.meta?.title ?? page?.title" :url="$page.props.app_url + page?.meta?.url"
    :meta_keywords="page?.meta?.meta_keywords" :meta_description="page?.meta?.meta_description"
    :canonical="$page.props?.app_url + '/' + page?.slug" />
  <div class="about-page">
    <div class="wrapper mt-20">
      <div class="top">
        <div class="_container">
          <div class="top__inner flex flex-col items-center gap-5 lg:flex-row-reverse lg:items-start lg:justify-between">
            <div
              class="top__pic relative rounded-full border-4 border-[rgba(84,85,235,0.84)] lg:mr-20 lg:flex-shrink-0 lg:border-8">
              <div class="top__pic-wrap absolute left-0 top-0 h-full w-full overflow-hidden rounded-full">
                <picture>
                  <source srcset="img/director.webp" type="image/webp"> <img src="img/director.png"
                    class="absolute bottom-0 left-[2px] h-[97%] w-full rounded-full object-contain"
                    alt="Основатель GoRooms">
                </picture>
              </div> 
              <Link href="/contacts">
                <svg class="top__pic-icon top__pic-icon_1 absolute object-contain">
                  <use xlink:href="img/sprite-mono.svg#mail"></use>
                </svg>
              </Link>
              <a href="/login">
                <svg class="top__pic-icon top__pic-icon_2 absolute object-contain">
                  <use xlink:href="img/sprite-mono.svg#user"></use>
                </svg>
              </a>
              <Link href="/hot">
                <svg class="top__pic-icon top__pic-icon_3 absolute object-contain">
                  <use xlink:href="img/sprite-mono.svg#bolt"></use>
                </svg>
              </Link>
              <a href="#" class="pointer-events-none">
                <svg class="top__pic-icon top__pic-icon_4 absolute object-contain btn-disabled">
                  <use xlink:href="img/sprite-mono.svg#heart"></use>
                </svg>
              </a>
              <a href="#" class="pointer-events-none">
                <svg class="top__pic-icon top__pic-icon_5 absolute object-contain btn-disabled">
                  <use xlink:href="img/sprite-mono.svg#crown"></use>
                </svg>
              </a>
            </div>
            <div class="top__text text-center lg:text-left">
              <h1 class="top__title">О GoRooms.</h1>
              <p class="top__desc font-normal text-lg sm:text-md md:text-lg lg:text-2xl"> Привет, Друзья! Меня зовут Иван,
                я являюсь основателем и
                управляющим партнером компании GoRooms. Мы создали первый и самый большой сервис
                почасовых бронирований отелей и гостиниц и я хочу рассказать Вам кто мы такие, какие
                преимущества дает Вам наша платформа и почему Вы обязательно должны воспользоваться
                нашим ресурсом)<br><br> Сегодня, рынок суточных бронирований успешно работает по
                высоким современным стандартам, а вот сегмент почасовых размещений до сих пор остается
                низкокачественным в плане сервиса и технологий.</p>
            </div>
          </div>
        </div>
        <div class="decor decor__first"></div>
      </div>
      <div class="example">
        <div class="_container">
          <div class="example__inner rounded-3xl bg-[#5455eb] p-2 text-white md:rounded-[50px] md:p-10">
            <strong class="example__desc block pt-3 font-bold md:pt-10">Допустим Вы физ. Лицо, наш
              дорогой клиент, открывший для себя мир почасовых бронирований, редко или часто, не важно, но
              пользуетесь данной услугой! С какими сложностями вы сталкиваетесь при поиске и
              бронировании?</strong>
            <div class="example__grid grid grid-cols-1 gap-4 xs:grid-cols-2 md:grid-cols-3 md:gap-6">
              <div class="example__item flex items-center gap-2"> <img src="img/icon_1.png" alt="Иконка">
                <div class="example__item-text"> Поиск нового отеля, обзвон и подбор номера занимает
                  много времени?</div>
              </div>
              <div class="example__item flex items-center gap-2"> <img src="img/icon_2.png" alt="Иконка">
                <div class="example__item-text"> Нет возможности узнавать о горящих предложениях и
                  покупать номера со скидкой?</div>
              </div>
              <div class="example__item flex items-center gap-2"> <img src="img/icon_3.png" alt="Иконка">
                <div class="example__item-text"> Вы не копите кэшбеки за каждое свое проживание?</div>
              </div>
              <div class="example__item flex items-center gap-2"> <img src="img/icon_4.png" alt="Иконка">
                <div class="example__item-text"> Сайты некоторых отелей очень скудны на фотографии и
                  описания? - Нет понятных и честных отзывов?</div>
              </div>
              <div class="example__item flex items-center gap-2"> <img src="img/icon_5.png" alt="Иконка">
                <div class="example__item-text"> Вы привыкли ходить в один и тот же отель и даже не
                  знаете что рядом с вами есть масса других отличных предложений?</div>
              </div>
              <div class="example__item flex items-center gap-2"> <img src="img/icon_6.png" alt="Иконка">
                <div class="example__item-text"> Возможно Ваш любимый номер занят, а администратор отеля
                  отвечает сухо и толком не знает что вам предложить?</div>
              </div>
            </div>
            <div
              class="example__bottom-phrase mx-auto mb-4 w-fit rounded-xl bg-white px-6 py-2 font-bold text-black lg:mx-0 md:mb-8 md:rounded-3xl md:px-12 md:py-6 text-lg sm:text-md md:text-lg lg:text-2xl">
              Да! Неудобств много! Но наш сервис поможет Вам!</div>
          </div>
        </div>
      </div>
      <div class="about">
        <div class="_container">
          <div class="about__inner">
            <div class="about__top flex flex-col items-center gap-4 md:gap-20 lg:flex-row">
              <div class="about__info flex flex-col items-center gap-4 xs:gap-8 sm:gap-10">
                <div
                  class="about__info-top info-top-about flex flex-col items-center gap-3 sm:flex-row sm:items-start sm:gap-10">
                  <div
                    class="info-top-about__logo rounded-2xl border-4 border-[rgba(84,85,235,0.84)] p-3 text-lg sm:text-md md:text-lg lg:text-2xl">
                    GoRooms</div>
                  <p
                    class="info-top-about__text text-center font-bold sm:text-left text-lg sm:text-md md:text-lg lg:text-2xl">
                    Это не просто
                    самая большая база отелей по всей стране. Это первая цивилизованная площадка где
                    клиент и отельер могут найти друг друга быстро и удобно для всех.</p>
                </div>
                <div class="about__info-bottom info-bottom-about flex flex-col items-center xs:flex-row">
                  <div class="info-bottom-about__pic xs:basis-[20%]"> <img src="img/person_1.png"
                      class="h-full w-full object-contain" alt="GoRooms"></div>
                  <div
                    class="info-bottom-about__logo flex flex-col items-center gap-3 py-2 xs:flex-1 xs:flex-row xs:px-4 xs:py-0">
                    <div class="info-bottom-about__line xs:flex-1">
                      <picture>
                        <source srcset="img/line-rotate.png" media="(min-width:575.98px)" type="image/webp"> <img
                          src="img/line.png" alt="GoRooms">
                      </picture>
                    </div>
                    <div
                      class="info-bottom-about__logo-wrap rounded-2xl border-4 border-[rgba(84,85,235,0.84)] p-3 text-lg sm:text-md md:text-lg lg:text-2xl">
                      GoRooms</div>
                    <div class="info-bottom-about__line xs:flex-1">
                      <picture>
                        <source srcset="img/line-rotate.png" media="(min-width:575.98px)" type="image/webp"> <img
                          src="img/line.png" alt="GoRooms">
                      </picture>
                    </div>
                  </div>
                  <div class="info-bottom-about__pic xs:basis-[25%] lg:basis-[30%]"> <img src="img/person_2.png"
                      class="w-fullh h-full object-contain" alt="GoRooms">
                  </div>
                </div>
              </div>
              <div class="about__video"><iframe width="560" height="315" loading="lazy"
                  src="https://youtube.com/embed/MNA05qF-IQo?si=LlmZCYITpLnvh9QT" title="YouTube video player"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowfullscreen="" class="about__video-link block h-full w-full border-none"></iframe></div>
            </div>
            <div class="about__middle">
              <h3 class="about__middle-title text-lg sm:text-md md:text-lg lg:text-2xl"> Но давайте представим что вы
                Отельер, почему Вам сервис
                <span class="bg-[rgb(84,85,235,0.5)]">GoRooms</span> будет не менее полезен?
              </h3>
              <div
                class="about__middle-row flex flex-wrap gap-y-5 text-center xs:gap-y-10 md:flex-row md:flex-nowrap md:items-start">
                <div
                  class="about__middle-item flex basis-full flex-col items-center gap-2 font-normal md:basis-1/3 md:px-3 lg:flex-row lg:items-start">
                  <img src="img/icon_1_1.png" alt="Иконка">
                  <p> Крупнейшая площадка почасовых отелей это всегда гарантия большой посещаемости,
                    Ваш отель на карте и в поиске увидят во много раз больше целевых клиентов чем
                    сейчас.</p>
                </div>
                <div
                  class="about__middle-item relative flex basis-full flex-col items-center gap-2 font-normal md:basis-1/3 md:px-3 lg:flex-row lg:items-start">
                  <img src="img/icon_2_1.png" alt="Иконка">
                  <p> Подробно заполненный раздел Вашего отеля это большая красивая отдельная страница
                    сайта посвященная только полезной информации о Вас.</p>
                  <div class="about__middle-balloon rounded-2xl bg-[#5455eb] p-4 text-white"> Такая
                    страница самостоятельно будет продвигаться в сети и любых поисковиках по вашему
                    региону, вы получаете второй сайт Вашего отеля совершенно бесплатно.</div>
                </div>
                <div
                  class="about__middle-item flex basis-full flex-col items-center gap-2 font-normal md:basis-1/3 md:px-3 lg:flex-row lg:items-start">
                  <img src="img/icon_3_1.png" alt="Иконка">
                  <p> Возможность быстро распродавать номера через «Горящие предложения» используя
                    скидку. Лучше продаться с небольшим дисконтом, чем остаться пустым?</p>
                </div>
              </div>
            </div>
            <div class="about__bottom font-normal text-lg sm:text-md md:text-lg lg:text-2xl">
              <p> Таким образом мы надеемся создать благоприятную, деловую среду для всех участников нашей
                площадки где каждый найдет то что ищет и все будут в выигрыше без монопольных
                взвинчиваний цен, накрутки отзывов и прочих недобросовестных методов
                конкуренции.<br><br> Надеюсь увидеть Вас на GoRooms.</p>
            </div>
          </div>
        </div>
        <div class="decor decor__second decor__second-line1"></div>
        <div class="decor decor__second decor__second-line2"></div>
        <div class="decor decor__third decor__third-line1"></div>
        <div class="decor decor__third decor__third-line2"></div>
        <div class="decor decor__third decor__third-line3"></div>
      </div>
    </div>
  </div>
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    AppHead,
    Layout,
    Link,
  },
  props: {
    page: Object,
  },
};
</script>