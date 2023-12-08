<template>
  <div class="xl:flex xl:items-center" :class="classes">
    <swiper
      slides-per-view="1"
      :pagination="pagination"
      :navigation="navigation"
      :breakpoints="breakpoints"
      class="swiper-image2 overflow-hidden relative mx-4 xl:mx-0 xl:w-full h-60 xl:h-80 xl:rounded-bl-2xl rounded-tl-2xl rounded-tr-2xl xl:rounded-tr-none xl:max-w-[550px] swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden"
    >
      <swiper-slide v-for="(image, index) in (room?.images ?? []).filter(el => el.moderate === false)">
        <Image class="w-full h-full object-cover" :src="image?.conversions?.card ?? image.url" :lazy="index > 0"/>
      </swiper-slide>
      <div
        class="swiper-image-prev max-[768px]:hidden absolute top-0 left-0 z-10 bg-transparent w-[50%] h-full"
      ></div>
      <div
        class="swiper-image-next max-[768px]:hidden absolute top-0 right-0 z-10 bg-transparent w-[50%] h-full"
      ></div>
      <div
        class="swiper-pagination abosolute left-[50%] transform translate-[50%] bottom-[16px] swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"
      ></div>
      <div v-if="room.max_discount > 0" class="absolute left-0 top-0 bg-red-700 text-white flex justify-center items-center text-center w-20 lg:w-24 rounded-tl-2xl rounded-br-2xl z-10">                
        <img src="/img/flash2.svg" class="h-[24px] lg:h-[28px]" alt="Hot">
        <span class="text-xl lg:text-2xl font-bold py-2">{{room.max_discount}}%</span>
      </div>
    </swiper>
    <div
      class="bg-white rounded-2xl p-5 xl:p-6 shadow-xl relative z-10 xl:w-full xl:h-96 overflow-hidden"
    >
      <div class="flex mb-4">
        <button         
          class="btn-disabled flex text-sm py-1 px-2 rounded-md bg-sky-100 mr-2"
        >
          <img class="mr-2 block" src="/img/star.svg" alt="star" width="20" height="20"/>
          <span>
            <b>0</b>
            (0)
          </span>
        </button>        
        <button          
          class="btn-disabled flex py-1 px-2 rounded-md bg-sky-100"
        >
          <img src="/img/heartCard.svg" alt="heart" width="20" height="20"/>
        </button>
        <cashback-tag />
      </div>
      <div class="block mb-6">
        <div class="font-bold text-xl leading-6">
          {{ room.number ? room.number + " / " : "" }}
          {{ room?.name?.length > 1 ? room.name : "" }}
          {{
            room.category?.name?.length > 1
              ? "(" + room.category.name + ")"
              : ""
          }}
        </div>
        <div class="text-sm leading-4">
          {{ room.hotel.type.single_name }}
          <a
            :href="'/hotels/' + room.hotel.slug"
            target="_blank"
            class="underline text-[#6170FF] font-bold"
            >{{ room.hotel.name }}</a
          >
        </div>
      </div>
      <div class="flex flex-wrap items-center text-xs mb-4">
        <div v-for="(attr, index) in room.attrs" class="flex items-center">
          <div>{{ attr.name }}</div>
          &nbsp;
          <svg
            v-if="index + 1 != room.attrs.length"
            class="mx-2"
            width="4"
            height="4"
            viewBox="0 0 4 4"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <circle cx="2" cy="2" r="2" fill="#515561"></circle>
          </svg>
        </div>
      </div>
      <div>
        <hotel-address :address="room.hotel.address" class="flex mb-2" />
        <div class="grid grid-cols-[fit-content(100%)_1fr]">
          <hotel-metro-item
            v-for="metro in room.hotel.metros"            
            :metro="metro"
          />
        </div>
      </div>
    </div>
    <div
      class="relative bg-white rounded-bl-2xl rounded-br-2xl xl:rounded-bl-none xl:rounded-tr-2xl px-4 pb-4 pt-4 mx-4 xl:mx-0 xl:w-1/3 xl:h-80 flex flex-col justify-between"
    >
      <div
        class="flex justify-between text-center xl:flex-col lg:text-left lg:m-auto lg:w-full lg:ml-2 xl:ml-4"
      >
        <cost-item
          v-for="cost in room.costs"
          :value="cost.value"
          :name="cost.name"
          :info="cost.info"
          :description="cost.description"
          :cost_period="cost.cost_period"
          :is_room="true"
        />
      </div>
      <div class="">
        <Button @click="openBookingModal()" classes="w-full">
          Забронировать
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import CashbackTag from "@/components/ui/CashbackTag.vue";
import Image from "@/components/ui/Image.vue";
import Button from "@/components/ui/Button.vue";
import HotelAddress from "@/components/ui/HotelAddress.vue";
import HotelMetroItem from "@/components/ui/HotelMetroItem.vue";
import CostItem from "@/components/ui/CostItem.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { Pagination, Navigation } from "swiper";

// install Swiper modules
SwiperCore.use([Pagination, Navigation]);
export default {
  components: {    
    CashbackTag,
    Image,
    Button,
    HotelAddress,
    HotelMetroItem,
    CostItem,
    Swiper,
    SwiperSlide,
  },
  props: {
    room: Object,
    classes: String,
  },
  mounted() {},
  data() {
    return {
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
        renderBullet: function (index, className) {
          return (
            '<button class="' +
            className +
            ' swiper-pagination-bullet !opacity-100 w-[32px] rounded-[1px] h-[2px] mx-[2px] border-none p-0">' +
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
  methods: {
    openBookingModal() {
      this.$eventBus.emit("booking-open", this.room);
    },
  },
  watch: {},
};
</script>
