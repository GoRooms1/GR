<template>
  <div class="px-4 w-full xl:w-1/3">
    <div class="my-4">      
      <div
        v-if="(hotel?.moderate === true || hasImagesToModerate) && $page.props?.is_moderator === true"
        class="overflow-hidden object-cover rounded-tl-2xl rounded-tr-2xl relative mx-4 h-60"
      >      
        <img class="w-full h-full object-cover" src="/img/hotel-moderate.jpg" alt="moderate"/>               
      </div>
      <swiper 
        v-if="!((hotel?.moderate === true || hasImagesToModerate) && $page.props?.is_moderator === true)"
        :slides-per-view="1"
        :loop="true"        
        :pagination="pagination"
        :navigation="navigation"
        :breakpoints="breakpoints"
        class="swiper-image overflow-hidden object-cover rounded-tl-2xl rounded-tr-2xl relative mx-4 h-60"
      >
        <swiper-slide v-for="(image, index) in (hotel?.images ?? []).filter(el => el.moderate === false)">
          <Image class="w-full h-full object-cover" :src="image?.conversions?.card ?? image.url" :lazy="index > 0"/>          
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
        <div v-if="hotel.max_discount > 0" class="absolute left-0 top-0 bg-red-700 text-white flex flex-col justify-center text-center w-12 rounded-tl-2xl rounded-br-2xl z-10">                
          <span class="text-xl font-bold py-2">{{hotel.max_discount}}%</span>
        </div>
      </swiper>
      <div v-if="!ratingOpened" class="bg-white rounded-2xl p-5 shadow-xl relative z-10">
        <div class="flex mb-4">
          <button @click="if (hotel.reviews_count > 0) ratingOpened = true;"
            class="flex text-sm py-1 px-2 rounded-md bg-sky-100 mr-2"
          >
            <img class="mr-2 block" src="/img/star.svg" alt="star" width="20" height="20"/>
            <b>{{hotel.avg_rating}}</b>
            ({{ hotel.reviews_count }})
          </button>          
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
            <hotel-metro-item v-if="metro" :metro="metro" />
          </div>
        </div>
      </div>

      <div v-if="ratingOpened"
        class="bg-white rounded-2xl p-5 shadow-xl relative z-10"       
      >
        <div class="flex mb-4">
          <button @click="ratingOpened = false" class="flex text-sm py-1 px-2 rounded-md mr-2">
            <div class="mr-2">
              <img src="/img/star2.svg">
            </div>
            <div>
              <b>{{hotel.avg_rating}}</b>
              ({{ hotel.reviews_count }})
            </div>
          </button>          
          <button @click="$eventBus.emit('reviews-open', {hotel_id: hotel.id})" class="ml-auto flex py-1.5 px-3 rounded-lg text-white bg-[#6170FF] text-sm">
            Прочитать отзывы
          </button>        
        </div>
        <h4 class="text-xl font-semibold mb-6">Рейтинг</h4>
        <div class="grid grid-cols-2 grid-rows-3 gap-[24px]">
          <div v-for="rating in hotel.ratings" class="flex h-[26px] justify-between relative">
            <div class="text-xs">{{ rating.category_name }}</div>
            <div class="text-xs">{{ rating.value }}</div>
            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"></div>
            <div class="absolute bottom-0 left-0 h-[4px] bg-[#6170FF] rounded-[2px]" :style="'width: '+(rating.value*10)+'%;'"></div>
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
            :cost_period="cost.cost_period"
          />
        </div>
        <div v-if="$page.props?.is_moderator === true" class="w-full">
          <a :href="'/moderator/hotel/' + hotel?.id"
            target="_blank"
            class="w-full h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 bg-blue-500 hover:bg-blue-800"
          >
            {{ (hotel?.moderate === true || hasImagesToModerate) ? 'Перейти в ЛК' : 'Редактировать'}}
          </a>
        </div>        
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import CashbackTag from "@/components/ui/CashbackTag.vue";
import Image from "@/components/ui/Image.vue";
import CostItem from "@/components/ui/CostItem.vue";
import HotelMetroItem from "@/components/ui/HotelMetroItem.vue";
import HotelAddress from "@/components/ui/HotelAddress.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { Pagination, Navigation } from "swiper";

// install Swiper modules
SwiperCore.use([Pagination, Navigation]);
export default {  
  components: {    
    Link,
    CashbackTag,
    Image,
    CostItem,
    HotelMetroItem,
    HotelAddress,
    Swiper,
    SwiperSlide,      
  },
  props: {
    hotel: Object,
  },
  data() {
    return {     
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
      favProcessing: false,
      ratingOpened: false,
    };
  },
  computed: {
    metro() {
      let metros = this.hotel?.metros ?? [];
      if (metros.length === 0) return null;

      let filterMetro = this.$page?.props?.filters?.hotels?.metro;

      return (
        this.hotel.metros.find(el => el.name == filterMetro) ?? this.hotel.metros[0]
      );
    },
    hasImagesToModerate() {
      return (this.hotel?.images ?? []).filter(el => el.moderate === true).length > 0;
    }
  },
  methods: {
    visitPage(href) {
      if (typeof window !== "undefined") window.location=href;
    },
  }
};
</script>
