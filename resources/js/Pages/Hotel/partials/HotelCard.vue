<template>
  <div class="px-4 w-full xl:w-1/3">
    <div class="my-4">      
      <div
        v-if="hotel?.moderate === true"
        class="overflow-hidden object-cover rounded-tl-2xl rounded-tr-2xl relative mx-4 h-60"
      >
        <img class="w-full h-full object-cover" src="/img/hotel-moderate.jpg" />
      </div>
      <swiper 
        v-if="hotel?.moderate !== true"
        :slides-per-view="1"
        :loop="true"
        :lazy="true"
        :preloadImages="false"
        :pagination="pagination"
        :navigation="navigation"
        :breakpoints="breakpoints"
        class="swiper-image overflow-hidden object-cover rounded-tl-2xl rounded-tr-2xl relative mx-4 h-60"
      >
        <swiper-slide v-for="image in hotel.images">
          <Image class="w-full h-full object-cover" :src="image.path" />
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
      <div class="bg-white rounded-2xl p-5 shadow-xl relative z-10">
        <div class="flex mb-4">
          <button
            data="rating-open"
            class="btn-disabled flex text-sm py-1 px-2 rounded-md bg-sky-100 mr-2"
          >
            <div class="mr-2">
              <img src="/img/star.svg" />
            </div>
            <div><b>0</b> (0)</div>
          </button>
          <div
            data="rating-modal"
            class="absolute bg-white rounded-2xl p-5 xl:p-6 z-20 xl:h-96 left-0 top-0 w-full h-full hidden"
          >
            <div class="flex justify-center mb-6">
              <button
                data="rating-close"
                class="btn-disabled flex text-sm py-1 px-2 rounded-md mr-2"
              >
                <div class="mr-2">
                  <img src="/img/star2.svg" />
                </div>
                <div>
                  <b>0</b>
                  (0)
                </div>
              </button>
              <button
                class="ml-auto flex py-1.5 px-3 rounded-lg text-white bg-[#6170FF] text-sm"
              >
                Прочитать отзывы
              </button>
            </div>
            <h4 class="text-xl font-semibold mb-6">Рейтинг</h4>
            <div class="grid grid-cols-2 grid-rows-3 gap-[24px]">
              <div class="flex h-[26px] justify-between relative">
                <div class="text-xs">Расположение</div>
                <div class="text-xs">10</div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"
                ></div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"
                ></div>
              </div>
              <div class="flex h-[26px] justify-between relative">
                <div class="text-xs">Персонал</div>
                <div class="text-xs">10</div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"
                ></div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"
                ></div>
              </div>
              <div class="flex h-[26px] justify-between relative">
                <div class="text-xs">Чистота</div>
                <div class="text-xs">10</div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"
                ></div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"
                ></div>
              </div>
              <div class="flex h-[26px] justify-between relative">
                <div class="text-xs">Wi-Fi</div>
                <div class="text-xs">10</div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"
                ></div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"
                ></div>
              </div>
              <div class="flex h-[26px] justify-between relative">
                <div class="text-xs">Комфорт</div>
                <div class="text-xs">9</div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"
                ></div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-[90%] bg-[#6170FF] rounded-[2px]"
                ></div>
              </div>
              <div class="flex h-[26px] justify-between relative">
                <div class="text-xs">Цена</div>
                <div class="text-xs">9</div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"
                ></div>
                <div
                  class="absolute bottom-0 left-0 h-[4px] w-[90%] bg-[#6170FF] rounded-[2px]"
                ></div>
              </div>
            </div>
          </div>
          <cashback-tag :with-chashback="hotel.is_cashback ?? false" />
        </div>
        <div class="text-center text-sm mb-1">
          {{ hotel?.type?.single_name ?? "Отель" }}
        </div>
        <div class="mb-6">
          <a
            :href="'/hotels/' + hotel.slug"
            target="_blank"
            class="block font-bold text-xl leading-6 text-center underline text-[#6170FF]"
          >
            {{ hotel.name }}
          </a>
        </div>
        <div>
          <hotel-address :address="hotel.address" class="flex mb-2" />
          <div class="grid grid-cols-[fit-content(100%)_1fr]">
            <hotel-metro-item :metro="metro" :address="hotel.address" />
          </div>
        </div>
      </div>
      <div
        class="relative bg-white rounded-bl-2xl rounded-br-2xl px-4 pb-4 pt-6 mx-4 flex flex-col"
      >
        <div class="flex justify-between text-center w-full">
          <cost-item
            v-for="cost in hotel.min_costs ?? []"
            :value="cost.value"
            :name="cost.name"
            :info="cost.info"
            :description="cost.description"
          />
        </div>
        <div v-if="$page.props?.is_moderator === true" class="w-full">
          <a :href="'/moderator/hotel/' + hotel?.id"
            target="_blank"
            class="w-full h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 bg-blue-500 hover:bg-blue-800"
          >
            {{hotel?.moderate === true ? 'Перейти в ЛК' : 'Редактировать'}}
        </a>
        </div>        
      </div>
    </div>
  </div>
</template>

<script>
import { filterStore } from "@/Store/filterStore.js";
import _ from "lodash";
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { Pagination, Navigation } from "swiper";
import { Link } from "@inertiajs/vue3";
import CashbackTag from "@/components/ui/CashbackTag.vue";
import Image from "@/components/ui/Image.vue";
import CostItem from "@/components/ui/CostItem.vue";
import HotelAddress from "@/components/ui/HotelAddress.vue";
import HotelMetroItem from "@/components/ui/HotelMetroItem.vue";

// install Swiper modules
SwiperCore.use([Pagination, Navigation]);
export default {
  components: {
    Swiper,
    SwiperSlide,
    Link,
    CashbackTag,
    Image,
    CostItem,
    HotelAddress,
    HotelMetroItem,    
  },
  props: {
    hotel: Object,
  },
  data() {
    return {
      filterStore,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
        renderBullet: function (index, className) {
          return (
            '<button class="' +
            className +
            ' !opacity-100 w-[6px] rounded-[50%] h-[6px] mx-[2px] border-none p-0 ">' +
            "</button>"
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
    metro() {
      let filterMetro = this.filterStore.getFilterValue("hotels", "metro");

      return (
        _.find(this.hotel.metros, { name: filterMetro }) ?? this.hotel.metros[0]
      );
    },
  },
  methods: {
    visitPage(href) {
      if (typeof window !== "undefined") window.location=href;
    },
  }
};
</script>
