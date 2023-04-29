<template>
  <div class="lg:flex lg:items-center">
    <div class="swiper-image2 overflow-hidden relative mx-4 lg:mx-0 lg:w-full h-60 lg:h-70 lg:rounded-bl-2xl rounded-tl-2xl rounded-tr-2xl lg:rounded-tr-none lg:max-w-[550px]">
        <div class="swiper-wrapper">
            <div v-for="image in room.images" class="swiper-slide">
              <Image class="w-full h-full object-cover" :src="image.path" alt="img" />
            </div>            
        </div>
        <div class="swiper-image-prev max-[768px]:hidden absolute top-0 left-0 z-10 bg-transparent w-[50%] h-full"></div>
        <div class="swiper-image-next max-[768px]:hidden absolute top-0 right-0 z-10 bg-transparent w-[50%] h-full"></div>
        <div class="swiper-pagination abosolute left-[50%] transform translate-[50%] bottom-[16px]"></div>
    </div>
    <div
      class="bg-white rounded-2xl p-3 lg:p-4 shadow-xl lg:w-full	relative z-10 lg:w-auto lg:h-86 overflow-hidden"
    >
      <div class="flex mb-4">
        <button
          data="rating-open"
          class="btn-disabled flex text-sm py-1 px-2 rounded-md bg-sky-100 mr-2"
        >
          <div class="mr-2">
            <img src="/img/star.svg" />
          </div>
          <div>
            <b>0</b>
            (0)
          </div>
        </button>        
        <button
          clck-btn=""
          class="btn-disabled flex py-1 px-2 rounded-md bg-sky-100"
        >
          <img src="/img/heartCard.svg" />
        </button>
        <cashback-tag />
      </div>
      <div class="block mb-4">
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
            :address="room.hotel.address"
            :metro="metro"          
          />
        </div>        
      </div>
    </div>
    <div
      class="relative bg-white rounded-bl-2xl rounded-br-2xl lg:rounded-bl-none lg:rounded-tr-2xl px-4 pb-2 xl:pb-4 pt-4 mx-4 lg:mx-0 lg:w-1/3 flex flex-col justify-between"
    >
      <div
        class="flex justify-between text-center lg:flex-col lg:text-left lg:m-auto lg:w-full lg:ml-2 xl:ml-4 text-xs md:text-sm"
      >
        <cost-item
          v-for="cost in room.costs"
          :value="cost.value"
          :name="cost.name"
          :info="cost.info"
          :description="cost.description"
        />
      </div>      
      <div class="">
        <Button classes="w-full room-booking" :data-room-id="room.id"> Забронировать </Button>
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

export default {
  components: {    
    CashbackTag,
    Image,
    Button,
    HotelAddress,
    HotelMetroItem,
    CostItem,    
  },
  props: {
    room: Object,
  }, 
};
</script>
