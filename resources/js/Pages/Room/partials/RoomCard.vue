<template>
   <div class="my-4 xl:flex xl:items-center">
        <swiper                
            slides-per-view="1"               
            :loop="true"
            :lazy="true"
            :preloadImages="false"
            :pagination="pagination"      
            :navigation="navigation"
            :breakpoints="breakpoints"
            class="swiper-image2 overflow-hidden relative mx-4 xl:mx-0 xl:w-full h-60 xl:h-80 xl:rounded-bl-2xl rounded-tl-2xl rounded-tr-2xl xl:rounded-tr-none xl:max-w-[550px] swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden"              
        >                
            <swiper-slide v-for="image in room.images">                                  
                <Image class="w-full h-full object-cover" :src="image.path"/>
            </swiper-slide>                
            <div class="swiper-image-prev max-[768px]:hidden absolute top-0 left-0 z-10 bg-transparent w-[50%] h-full"></div>
            <div class="swiper-image-next max-[768px]:hidden absolute top-0 right-0 z-10 bg-transparent w-[50%] h-full"></div>
            <div class="swiper-pagination abosolute left-[50%] transform translate-[50%] bottom-[16px] swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"></div>
        </swiper>
        <div class="bg-white rounded-2xl p-5 xl:p-6 shadow-xl relative z-10 xl:w-full xl:h-96 overflow-hidden">                                  
            <div class="flex mb-4">
                <button data="rating-open" class="btn-disabled flex text-sm py-1 px-2 rounded-md bg-sky-100	mr-2">
                    <div class="mr-2">
                        <img src="/img/star.svg">
                    </div>
                    <div>
                        <b>0</b>
                        (0)
                    </div>
                </button>
                <div data="rating-modal" class="absolute bg-white rounded-2xl p-5 xl:p-6 z-20 xl:h-96 left-0 top-0 w-full h-full hidden">
                    <div class="flex justify-center mb-6">
                        <button data="rating-close" class="btn-disabled flex text-sm py-1 px-2 rounded-md mr-2">
                            <div class="mr-2">
                                <img src="/img/star2.svg">
                            </div>
                            <div>
                                <b>9.5</b>
                                (14)
                            </div>
                        </button>
                        <button class="ml-auto flex py-1.5 px-3 rounded-lg text-white bg-[#6170FF] text-sm">
                            Прочитать отзывы
                        </button>
                    </div>
                    <h4 class="text-xl font-semibold mb-6">Рейтинг</h4>
                    <div class="grid grid-cols-2 grid-rows-3 gap-[24px]">
                        <div class="flex h-[26px] justify-between relative">
                            <div class="text-xs">Расположение</div>
                            <div class="text-xs">10</div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"></div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"></div>
                        </div>
                        <div class="flex h-[26px] justify-between relative">
                            <div class="text-xs">Персонал</div>
                            <div class="text-xs">10</div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"></div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"></div>
                        </div>
                        <div class="flex h-[26px] justify-between relative">
                            <div class="text-xs">Чистота</div>
                            <div class="text-xs">10</div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"></div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"></div>
                        </div>
                        <div class="flex h-[26px] justify-between relative">
                            <div class="text-xs">Wi-Fi</div>
                            <div class="text-xs">10</div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"></div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#6170FF] rounded-[2px]"></div>
                        </div>
                        <div class="flex h-[26px] justify-between relative">
                            <div class="text-xs">Комфорт</div>
                            <div class="text-xs">9</div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"></div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-[90%] bg-[#6170FF] rounded-[2px]"></div>
                        </div>
                        <div class="flex h-[26px] justify-between relative">
                            <div class="text-xs">Цена</div>
                            <div class="text-xs">9</div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-[#EAEFFD] rounded-[2px]"></div>
                            <div class="absolute bottom-0 left-0 h-[4px] w-[90%] bg-[#6170FF] rounded-[2px]"></div>
                        </div>
                    </div>
                </div>
                <button clck-btn="" class="btn-disabled flex py-1 px-2 rounded-md bg-sky-100 ">
                    <img src="/img/heartCard.svg">
                </button>
                <cashback-tag/>
            </div>
            <a href="#" class="block mb-6">
                <div class="font-bold text-xl leading-6 cursor-pointer">
                    {{ room.number ? room.number + ' / ' : '' }} {{ room?.name?.length > 1 ? room.name : '' }} {{ room.category?.name?.length > 1 ? ('(' + room.category.name + ')') : '' }}
                </div>                
                <div class="text-sm leading-4">
                    {{ room.hotel.type.single_name }}
                    <a class="underline text-[#6170FF] font-bold">{{ room.hotel.name }}</a>
                </div>
            </a>
            <div class="flex flex-wrap items-center text-xs mb-4">
                <div v-for="(attr, index) in room.attrs" class="flex items-center">
                    <div>{{ attr.name }}
                    </div>&nbsp;
                    <svg v-if="index + 1 != room.attrs.length" class="mx-2" width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="2" r="2" fill="#515561"></circle>
                    </svg>
                </div>               
            </div>
            <div>
                <hotel-address :address="room.hotel.address"/>               
                <hotel-metro-item v-for="metro in room.hotel.metros" :address="room.hotel.address" :metro="metro"/>              
            </div>
        </div>
        <div class="relative bg-white rounded-bl-2xl rounded-br-2xl xl:rounded-bl-none xl:rounded-tr-2xl px-4 pb-4 pt-8 mx-4 xl:mx-0 xl:w-1/3 xl:h-80 xl:pb-16 xl:flex xl:items-left xl:justify-items-start xl:justify-start">            
            <div class="flex justify-between text-center xl:flex-col xl:text-left xl:m-auto xl:w-full xl:ml-8">                
                <cost-item 
                    v-for="cost in room.costs" 
                    :value="cost.value"
                    :name="cost.name"
                    :info="cost.info"
                    :description="cost.description"
                />               
            </div>
            <div class="xl:absolute xl:bottom-4 xl:left-4 xl:right-4">
                <Button disabled classes="w-full">
                    Забронировать
                </Button>
            </div>
        </div>
    </div>
</template>

<script>
    import { Swiper, SwiperSlide } from 'swiper/vue'
    import SwiperCore, { Pagination, Navigation } from "swiper"    
    import CashbackTag from '@/components/ui/CashbackTag.vue'
    import Image from '@/components/ui/Image.vue'
    import Button from '@/components/ui/Button.vue'
    import HotelAddress from '@/components/ui/HotelAddress.vue'
    import HotelMetroItem from '@/components/ui/HotelMetroItem.vue'
    import CostItem from '@/components/ui/CostItem.vue'
    
    // install Swiper modules
    SwiperCore.use([Pagination, Navigation]);
    export default {
        components: {
            Swiper,
            SwiperSlide,
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
        data() {
            return {
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,                                                       
                    renderBullet: function (index, className) {                        
                        return '<span class="' + className +  ' swiper-pagination-bullet !opacity-100 w-[32px] rounded-[1px] h-[2px] mx-[2px] border-none p-0 ">' + '</span>';
                    },
                },
                navigation: {
                    nextEl: '.swiper-image-next',
                    prevEl: '.swiper-image-prev',
                },
                breakpoints: {
                    1024: {
                        noSwipingClass: "swiper-slide"
                    }
                },
            }
        },
        methods: {
            
        }      
    }
</script>
