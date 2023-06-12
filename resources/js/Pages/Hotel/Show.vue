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
  <search-filter-modal :url="'/hotels/' + hotel.slug" />
  <div
    v-if="$page.props.modals.search !== false"
    class="search-panel-modal w-full mx-auto transition fixed lg:hidden px-[16px]"
  >
    <div class="relative">
      <Search for-modal :url="'/hotels/' + hotel.slug" />
    </div>
  </div>

  <div class="container mx-auto md:px-4 px-0 md:mt-[113px] mt-0" @mousedown="loadMapImmediate()" @touchstart="loadMapImmediate()">
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
              <img src="/img/star2.svg" alt="star" width="20" height="20"/>
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
                <swiper-slide v-for="(image, index) in (hotel?.images ?? []).filter(el => el.moderate === false)">
                  <Image class="w-full h-full object-cover" :src="image?.conversions?.show ?? image.url" :lazy="index > 0"/>
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
  <rooms-list :rooms="rooms" :hotel-id="hotel?.id ?? 0" />
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import RoomsList from "@/Pages/Room/partials/RoomsList.vue";
import CashbackTag from "@/components/ui/CashbackTag.vue";
import Tabs from "@/components/ui/Tabs.vue";
import Tab from "@/components/ui/Tab.vue";
import Image from "@/components/ui/Image.vue";
import HotelAddress from "./partials/HotelAddress.vue";
import HotelMetroItem from "@/components/ui/HotelMetroItem.vue";
import CostItem from "./partials/CostItem.vue";
import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue";
import Search from "@/components/widgets/Search.vue";
import { loadYandexMap } from "@/Services/loadYandexMap.js";
import {_getFiltersData} from "@/Services/filterUtils.js";
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { Pagination, Navigation } from "swiper";

let myMap = null;
SwiperCore.use([Pagination, Navigation]);
export default {
  layout: SearchLayout,
  components: {    
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
    Swiper,
    SwiperSlide,
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
              this.$page.props.isLoadind = true;
            },
            onFinish: () => {
              this.$page.props.isLoadind = false;
            },
          }
        );
      });
    },    
  },
};
</script>
