<template>
  <AppHead
    :title="page_description.title"
    :hotel="hotel"
    :url="$page.props.app_url + page_description?.url"
    :meta_keywords="page_description?.meta_keywords"
    :meta_description="page_description?.meta_description"
  >
  <component is="script" type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "{{ hotel?.name }}",
      "image": {{ (hotel?.images ?? []).flatMap( img => $page.props.app_url + img.path) }},
      "description": "{{ (hotel?.description ?? '').replace(/(<([^>]+)>)/gi, "")}}",
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "worstRating":"0",
          "ratingValue": "0",
          "bestRating": "0"
        },
        "author": {
          "@type": "Person",
          "name": ""
        },
        "aggregateRating": {
          "@type": "AggregateRating",
          "bestRating":"0",
          "worstRating":"0",
          "ratingValue": "0",
          "reviewCount": "1"            
        },
        "hasOfferCatalog": {
          "@type": "OfferCatalog",
          "name": "Услуги отеля",
          "itemListElement": {{ (hotel?.attrs ?? []).flatMap( attr =>  JSON.stringify({
                type: "Offer", 
                itemOffered: {
                  type: "Service",
                  name: attr.name
                }
              }).replace("type", "@type")
            )
          }}
        }
      }    
    }
  </component>
  </AppHead>
  <search-filter-modal :url="'/hotels/' + hotel.slug" />
  <div
    v-if="$page.props.modals.search !== false"
    class="search-panel-modal w-full mx-auto transition fixed lg:hidden px-[16px]"
  >
    <div class="relative">
      <Search for-modal :url="'/hotels/' + hotel.slug" />
    </div>
  </div>

  <div class="container mx-auto md:px-4 px-0 md:mt-[113px] mt-0">
    <div>
      <div class="flex md:flex-col flex-col-reverse">
        <div
          class="w-full flex sm:items-center items-start sm:gap-[10px] gap-[32px] justify-between flex-col sm:flex-row md:px-0 px-4 md:mb-0"
        >
          <div>
            <span class="text-[16px] leading-[19px]">{{
              hotel?.type?.single_name ?? "Отель"
            }}</span>
            <h1 class="text-[28px] leading-[33px] font-semibold">
              {{ hotel?.name }}
            </h1>
          </div>
          <div
            class="w-full mb-[32px] md:mb-0 sm:w-auto flex items-center gap-[24px] sm:justify-start justify-between"
          >
            <div class="flex items-center gap-[8px]">
              <span class="text-[14px] leading-[16px] font-semibold"
                >Рейтинг</span
              >
              <img src="/img/star2.svg" alt="star"/>
              <p class="text-[14px] leading-[16px]">
                <span class="font-semibold">0</span>
                (0)
              </p>
            </div>
            <cashback-tag :with-chashback="hotel?.is_cashback ?? false" />
          </div>
        </div>

        <div
          class="flex items-start justify-between md:flex-row flex-col-reverse gap-[32px] md:mt-[56px] mt-0 md:mb-[64px] mb-[48px] w-full"
        >
          <div            
            v-html="hotel?.description ?? ''"
            class="sm:block hidden md:w-[30%] w-full md:px-0 px-4"
          ></div>
          <tabs @changed="redrawMap">
            <tab title="Фотогалерея">
              <swiper
                :slides-per-view="1"
                :pagination="pagination"
                :navigation="navigation"
                :breakpoints="breakpoints"
                class="swiper-image relative h-[416px] md:rounded-[24px] rounded-none overflow-hidden swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden"
              >
                <swiper-slide v-for="image in (hotel?.images ?? []).filter(el => el.moderate === false)">
                  <Image class="w-full h-full object-cover" :src="image.path + '?w=800&fit=crop&fm=webp'" />
                </swiper-slide>
                <div
                  class="swiper-image-prev max-[768px]:hidden absolute top-0 left-0 z-10 bg-transparent w-[50%] h-full"
                ></div>
                <div
                  class="swiper-image-next max-[768px]:hidden absolute top-0 right-0 z-10 bg-transparent w-[50%] h-full"
                ></div>
                <div
                  class="swiper-pagination abosolute left-[50%] transform translate-[50%] bottom-[16px]"
                ></div>
              </swiper>
            </tab>
            <tab
              title="На карте"
              class="min-h-[416px] rounded-[24px] overflow-hidden"
            >
              <div id="map" class="w-full" style="height: 416px"></div>
            </tab>
            <tab title="Отзывы" disabled="true">
              <div
                class="min-h-[416px] rounded-[24px] overflow-hidden bg-[#6170FF] sm:pt-[41px] pb-[41px] pt-[90px] sm:px-[20px] px-[10px]"
              >
                <div
                  class="swiper-feed-wrapper relative overflow-hidden w-full h-[100%]"
                >
                  <button
                    class="swiper-feed-button-prev cursor-pointer absolute top-[50%] transform translate-1/2 left-0 w-[32px] h-[32px] bg-white rounded-[8px] sm:flex hidden items-center justify-center"
                  >
                    <svg
                      width="20"
                      height="20"
                      viewBox="0 0 20 20"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.084 5.75037L7.91732 9.91703L12.084 14.0837"
                        stroke="#515561"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      ></path>
                    </svg>
                  </button>
                  <swiper
                    :slides-per-view="2"
                    :slides-per-group="2"
                    :space-between="32"
                    :loop="false"
                    :navigation="feedbackNavigation"
                    :breakpoints="feedbackBreakpoints"
                    class="swiper-feed overflow-hidden sm:mx-[52px] mx-0 h-[100%]"
                  >
                    <swiper-slide v-for="item in [1, 2, 3]">
                      <div class="bg-white p-[24px] rounded-[24px]">
                        <div
                          class="flex items-center justify-between py-[6px] mb-[24px]"
                        >
                          <div class="flex items-center gap-[8px]">
                            <svg
                              width="20"
                              height="20"
                              viewBox="0 0 20 20"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M10 14.1667L5 16.6667L6.25 11.6667L2.5 7.5L7.91667 7.08333L10 2.5L12.0833 7.08333L17.5 7.5L13.75 11.6667L15 16.6667L10 14.1667Z"
                                stroke="#6170FF"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              ></path>
                            </svg>
                            <span
                              class="text-[14px] leading-[16px] font-semibold"
                              >10</span
                            >
                          </div>
                          <span class="text-[16px] leading-[19px] font-semibold"
                            >Имя{{ item }}</span
                          >
                          <span class="text-[12px] leading-[14px]"
                            >01 января 2023</span
                          >
                        </div>
                        <p class="text-[14px] leading-[16px] mb-[24px]">
                          Отзыв{{ item }}
                        </p>
                        <div class="grid grid-cols-2 gap-x-[24px] gap-[16px]">
                          <div>
                            <div
                              class="flex items-center justify-between mb-[8px]"
                            >
                              <span class="text-[12px] leading-[14px]"
                                >Расположение</span
                              >
                              <span class="text-[12px] leading-[14px]">10</span>
                            </div>
                            <div
                              class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden"
                            >
                              <div
                                class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"
                              ></div>
                            </div>
                          </div>
                          <div>
                            <div
                              class="flex items-center justify-between mb-[8px]"
                            >
                              <span class="text-[12px] leading-[14px]"
                                >Персонал</span
                              >
                              <span class="text-[12px] leading-[14px]">10</span>
                            </div>
                            <div
                              class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden"
                            >
                              <div
                                class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"
                              ></div>
                            </div>
                          </div>
                          <div>
                            <div
                              class="flex items-center justify-between mb-[8px]"
                            >
                              <span class="text-[12px] leading-[14px]"
                                >Чистота</span
                              >
                              <span class="text-[12px] leading-[14px]">10</span>
                            </div>
                            <div
                              class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden"
                            >
                              <div
                                class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"
                              ></div>
                            </div>
                          </div>
                          <div>
                            <div
                              class="flex items-center justify-between mb-[8px]"
                            >
                              <span class="text-[12px] leading-[14px]"
                                >WI-FI</span
                              >
                              <span class="text-[12px] leading-[14px]">10</span>
                            </div>
                            <div
                              class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden"
                            >
                              <div
                                class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"
                              ></div>
                            </div>
                          </div>
                          <div>
                            <div
                              class="flex items-center justify-between mb-[8px]"
                            >
                              <span class="text-[12px] leading-[14px]"
                                >Комфорт</span
                              >
                              <span class="text-[12px] leading-[14px]">10</span>
                            </div>
                            <div
                              class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden"
                            >
                              <div
                                class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"
                              ></div>
                            </div>
                          </div>
                          <div>
                            <div
                              class="flex items-center justify-between mb-[8px]"
                            >
                              <span class="text-[12px] leading-[14px]"
                                >Цена</span
                              >
                              <span class="text-[12px] leading-[14px]">10</span>
                            </div>
                            <div
                              class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden"
                            >
                              <div
                                class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"
                              ></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </swiper-slide>
                  </swiper>
                  <button
                    class="swiper-feed-button-next cursor-pointer absolute top-[50%] transform translate-1/2 right-0 w-[32px] h-[32px] bg-white rounded-[8px] sm:flex hidden items-center justify-center"
                  >
                    <svg
                      width="20"
                      height="20"
                      viewBox="0 0 20 20"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M7.91602 14.2496L12.0827 10.083L7.91602 5.9163"
                        stroke="#515561"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      ></path>
                    </svg>
                  </button>
                </div>
              </div>
            </tab>
          </tabs>
        </div>
      </div>

      <div
        class="grid md:grid-cols-3 grid-cols-1 items-start sm:gap-[30px] gap-[32px] md:px-0 px-4"
      >
        <div class="md:pt-[24px] pt-0">
          <p class="text-[22px] leading-[26px] font-semibold mb-[16px]">
            Детально об отеле
          </p>
          <div class="flex flex-wrap gap-[16px]">
            <div
              v-for="attr in hotel?.attrs"
              class="py-[8px] px-[12px] border border-solid border-[#6170FF] rounded-[8px] text-[14px] leading-[16px]"
            >
              {{ attr.name }}
            </div>
          </div>
        </div>
        <div
          class="sm:bg-white bg-transparent sm:p-[24px] p-0 rounded-[24px] row-start-1 md:col-start-2"
        >
          <p
            class="text-[22px] leading-[26px] font-semibold lg:mb-[24px] mb-[16px]"
          >
            Расположение
          </p>
          <div class="flex flex-col gap-[8px]">
            <hotel-address :address="hotel?.address" />
            <div class="grid grid-cols-[fit-content(100%)_1fr]">
              <hotel-metro-item
                v-for="metro in hotel?.metros"
                :metro="metro"
                :address="hotel?.address"
              />
            </div>
          </div>
        </div>
        <div class="sm:bg-white bg-transparent sm:p-[24px] p-0 rounded-[24px]">
          <p
            class="text-[22px] leading-[26px] lg:mb-[24px] mb-[16px] font-semibold"
          >
            Минимальная стоимость
          </p>
          <div class="flex gap-[10px] items-center justify-between">
            <cost-item
              v-for="cost in hotel?.min_costs ?? []"
              :value="cost.value"
              :name="cost.name"
              :info="cost.info"
              :description="cost.description"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-4"></div>
  <rooms-list :rooms="rooms" by-hotel />
</template>

<script lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { Pagination, Navigation } from "swiper";
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import RoomsList from "@/Pages/Room/partials/RoomsList.vue";
import CashbackTag from "@/components/ui/CashbackTag.vue";
import Tabs from "./partials/Tabs.vue";
import Tab from "./partials/Tab.vue";
import Image from "@/components/ui/Image.vue";
import HotelAddress from "./partials/HotelAddress.vue";
import HotelMetroItem from "@/components/ui/HotelMetroItem.vue";
import CostItem from "./partials/CostItem.vue";
import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue";
import Search from "@/components/widgets/Search.vue";
import { filterStore } from "@/Store/filterStore.js";
import { usePage } from "@inertiajs/vue3";
import { loadYandexMap } from "@/Services/loadYandexMap.js";

let myMap = null;
SwiperCore.use([Pagination, Navigation]);
export default {
  layout: SearchLayout,
  components: {
    Swiper,
    SwiperSlide,
    AppHead,
    Layout,
    RoomsList,
    CashbackTag,
    Tabs,
    Tab,
    Image,
    HotelAddress,
    HotelMetroItem,
    CostItem,
    SearchFilterModal,
    Search,
  },
  props: {
    page_description: Object,
    hotel: [Object],
    rooms: [Object],
  },
  data() {
    return {
      filterStore,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
        renderBullet: function (index, className) {
          return (
            '<span class="' +
            className +
            ' !opacity-100 w-[6px] rounded-[50%] h-[6px] mx-[2px] border-none p-0 ">' +
            "</span>"
          );
        },
      },
      navigation: {
        nextEl: ".swiper-image-next",
        prevEl: ".swiper-image-prev",
      },
      breakpoints: {
        1024: {
          noSwipingClass: "swiper-slide",
        },
      },
      feedbackNavigation: {
        nextEl: ".swiper-feed-button-next",
        prevEl: ".swiper-feed-button-prev",
        enabled: true,
      },
      feedbackBreakpoints: {
        320: {
          slidesPerView: 1.2,
          slidesPerGroup: 1,
          spaceBetween: 16,
          navigation: {
            enabled: false,
          },
        },
        600: {
          slidesPerView: 2,
          slidesPerGroup: 2,
          navigation: {
            enabled: true,
          },
        },
        761: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          navigation: {
            enabled: true,
          },
        },
        1200: {
          slidesPerView: 2,
          slidesPerGroup: 2,
          navigation: {
            enabled: true,
          },
        },
      },
    };
  },
  mounted() {
    loadYandexMap(this.$page.props.yandex_api_key, 3000, this.initMap);
    this.$page.props.modals.search = false;
    this.$eventBus.on("filters-changed", (e) => this.updateRooms());
  },
  unmounted() {
    this.$eventBus.off("filters-changed");
  },
  methods: {
    initMap() {
      myMap = new ymaps.Map("map", {
        center: [this.hotel.address.geo_lat, this.hotel.address.geo_lon],
        zoom: 15,
        controls: ["zoomControl"],
      });

      let orgGeoObject = new ymaps.GeoObject(
        {
          geometry: {
            type: "Point",
            coordinates: [
              this.hotel.address.geo_lat,
              this.hotel.address.geo_lon,
            ],
          },
        },
        {
          preset: "islands#icon",
          draggable: false,
        }
      );

      myMap.geoObjects.add(orgGeoObject);
    },
    redrawMap() {
      setTimeout(() => {
        console.log("redraw");
        myMap?.container?.fitToViewport();
      }, 200);
    },
    updateRooms() {
      this.$nextTick(() => {
        this.$inertia.get(
          "/hotels/" + this.hotel.slug,
          this.filterStore.getFiltersValues(),
          {
            replace: true,
            preserveState: true,
            preserveScroll: true,
            only: ["rooms"],
            onStart: () => {
              usePage().props.isLoadind = true;
            },
            onFinish: () => {
              usePage().props.isLoadind = false;
            },
          }
        );
      });
    },    
  },
};
</script>
