<template>
  <AppHead
    :title="page_description.title"
    :hotel="hotel"
    :url="$page.props.app_url + page_description?.url"
    :meta_keywords="page_description?.meta_keywords"
    :meta_description="page_description?.meta_description"
    :canonical="$page.props?.app_url + $page.props?.path"
  >
    <component is="script" type="application/ld+json">
      {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "{{ hotel?.name }}",
        "image": {{ (hotel?.images ?? []).flatMap( img => img.url) }},
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
  <div
    v-if="$page.props.modals.search === true"
    class="search-panel-modal w-full mx-auto transition fixed lg:hidden px-[16px]"
  >
    <div class="relative">
      <Search v-if="$page.props.modals.search === true" for-modal/>
    </div>
  </div>  

  <div class="container mx-auto md:px-4 px-0 md:mt-[113px] mt-0" @mousedown="loadMapImmediate()" @touchstart="loadMapImmediate()">       
    <div>
      <div class="flex md:flex-col flex-col-reverse">
        <div v-if="$page.props?.is_moderator === true" class="w-full md:w-[376px] md:px-0 px-[16px] py-2">
          <a :href="'/moderator/hotel/' + hotel?.id"
            target="_blank"
            class="w-full h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 bg-blue-500 hover:bg-blue-800"
          >
            {{ (hotel?.moderate === true || hasImagesToModerate) ? 'Перейти в ЛК' : 'Редактировать'}}
          </a>
        </div> 
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
              <img src="/img/star2.svg" alt="star" width="20" height="20"/>
              <p class="text-[14px] leading-[16px]">
                <span class="font-semibold">{{ hotel.avg_rating }}</span>
                ({{ hotel.reviews_count }})
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
          <div class="md:w-[70%] w-full overflow-hidden" height="480">
            <tabs @changed="redrawMap">
              <tab title="Фотогалерея">
                <swiper
                  :slides-per-view="1"
                  :pagination="pagination"
                  :navigation="navigation"
                  :breakpoints="breakpoints"
                  class="swiper-image relative h-[416px] md:rounded-[24px] rounded-none overflow-hidden swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden"
                >
                  <swiper-slide v-for="(image, index) in (hotel?.images ?? []).filter(el => el.moderate === false)">
                    <Image class="w-full h-full object-cover" height="416" :src="image?.conversions?.show ?? image.url" :lazy="index > 0"/>
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
              <tab title="Отзывы" :disabled="(hotel?.reviews ?? []).length > 0 ? 'false' : 'true'">
                <div class="overflow-hidden">
                  <div class="min-h-[416px] rounded-[24px] overflow-hidden bg-[#6170FF] sm:pt-[41px] pb-[41px] pt-[90px] sm:px-[20px] px-[10px]">
                    <div class="swiper-feed-wrapper relative overflow-hidden w-full h-[100%]">
                      <button class="swiper-feed-button-prev cursor-pointer absolute top-[50%] transform translate-1/2 left-0 w-[32px] h-[32px] bg-white rounded-[8px] sm:flex hidden  items-center justify-center">
                        <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M12.084 5.75037L7.91732 9.91703L12.084 14.0837" stroke="#515561" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </button>
                      <swiper 
                        class="swiper-feed overflow-hidden sm:mx-[52px] mx-0 h-[100%]"
                        :loop="false"
                        :space-between="32"
                        :slides-per-view="2"
                        :slides-per-group="2"
                        :navigation="{
                          nextEl: '.swiper-feed-button-next',
                          prevEl: '.swiper-feed-button-prev',
                          enabled: true,
                        }"
                        :breakpoints="{
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
                          },
                          761: {
                            slidesPerView: 1,
                            slidesPerGroup: 1
                          },
                          1200: {
                            slidesPerView: 2,
                            slidesPerGroup: 2
                          },
                        }"
                      >
                        <swiper-slide v-for="review in hotel.reviews">
                          <div class="bg-white p-[24px] rounded-[24px]">
                            <div class="flex items-center justify-between py-[6px] mb-[24px]">
                              <div class="flex items-center gap-[8px]">
                                <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M10 14.1667L5 16.6667L6.25 11.6667L2.5 7.5L7.91667 7.08333L10 2.5L12.0833 7.08333L17.5 7.5L13.75 11.6667L15 16.6667L10 14.1667Z" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-[14px] leading-[16px] font-semibold">{{ review.avg_rating }}</span>
                              </div>
                              <span class="text-[16px] leading-[19px] font-semibold">{{ review.name }}</span>
                              <span class="text-[12px] leading-[14px]">{{ (new Date(review.created_at)).toLocaleDateString('ru', {day: 'numeric', month: 'long', year: 'numeric',}) }}</span>
                            </div>
                            <p class="text-[14px] leading-[16px] mb-[24px]">{{ review.text }}</p>
                            <div class="grid grid-cols-2 gap-x-[24px] gap-[16px]">
                              <div v-for="rating in review.ratings">
                                <div class="flex items-center justify-between mb-[8px]">
                                  <span class="text-[12px] leading-[14px]">{{ rating.category_name }}</span>
                                  <span class="text-[12px] leading-[14px]">{{ rating.value }}</span>
                                </div>
                                <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                                  <div class="h-full bg-[#6170FF] rounded-[2px]" :style="'width: '+(rating.value*10)+'%;'"></div>
                                </div>
                              </div>                              
                            </div>
                          </div>
                        </swiper-slide>
                      </swiper>
                      <button class="swiper-feed-button-next cursor-pointer absolute top-[50%] transform translate-1/2 right-0 w-[32px] h-[32px] bg-white rounded-[8px] sm:flex hidden items-center justify-center">
                        <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.91602 14.2496L12.0827 10.083L7.91602 5.9163" stroke="#515561" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>                
              </tab>
            </tabs>
          </div>
          
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
              :cost_period="cost.cost_period"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-4"></div>
  <list-header title="Все номера отеля" />
  <object-list type="rooms" :objects="rooms"/>
</template>

<script lang="ts">
import { defineAsyncComponent } from 'vue'
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import ListHeader from '@/components/ui/ListHeader.vue';
import ObjectList from "@/Pages/Objects/partials/ObjectList.vue";
import CashbackTag from "@/components/ui/CashbackTag.vue";
import Tabs from "@/components/ui/Tabs.vue";
import Tab from "@/components/ui/Tab.vue";
import Image from "@/components/ui/Image.vue";
import HotelAddress from "./partials/HotelAddress.vue";
import HotelMetroItem from "@/components/ui/HotelMetroItem.vue";
import CostItem from "./partials/CostItem.vue";
import { loadYandexMap } from "@/Services/loadYandexMap.js";
import {_getFiltersData} from "@/Services/filterUtils.js";
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { Pagination, Navigation } from "swiper";

let myMap = null;
SwiperCore.use([Pagination, Navigation]);
export default {  
  components: {    
    AppHead,
    Layout,
    ObjectList,
    ListHeader,
    CashbackTag,
    Tabs,
    Tab,
    Image,
    HotelAddress,
    HotelMetroItem,
    CostItem,
    Swiper,
    SwiperSlide,
    Search: defineAsyncComponent(() =>
      import('@/components/widgets/Search.vue')
    ),
  },
  props: {
    page_description: Object,
    hotel: [Object],
    rooms: [Object],
  },
  data() {
    return {      
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
    };
  },
  computed: {
    hasImagesToModerate() {
      return (this.hotel?.images ?? []).filter(el => el.moderate === true).length > 0;
    }
  },
  mounted() {
    this.loadMapLazy();
    this.$page.props.modals.search = false;
    this.$eventBus.on("filters-changed", (e) => this.updateRooms());
  },
  unmounted() {
    this.$eventBus.off("filters-changed");
  },
  methods: {
    loadMapLazy() {
      let mapInitDelay = 3000;
      if (typeof window !== "undefined") {
        if (window.innerWidth < 768) mapInitDelay = 5100;
      }
      loadYandexMap(this.$page.props.yandex_api_key, mapInitDelay, this.initMap)
    },
    loadMapImmediate() {
      if (typeof ymaps !== "undefined") return;
      loadYandexMap(this.$page.props.yandex_api_key, 10, this.initMap);
    },
    initMap() {
      myMap = new ymaps.Map("map", {
        center: [this.hotel.address.geo_lat, this.hotel.address.geo_lon],
        zoom: 15,       
      });

      let orgGeoObject = new ymaps.Placemark(
        [this.hotel.address.geo_lat, this.hotel.address.geo_lon]
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
          _getFiltersData.call(this),
          {
            replace: true,
            preserveState: true,
            preserveScroll: true,
            only: ["rooms"],
            onStart: () => {
              this.$page.props.is_loading = true;
            },
            onFinish: () => {
              this.$page.props.is_loading = false;
            },
          }
        );
      });
    },    
  },
};
</script>
