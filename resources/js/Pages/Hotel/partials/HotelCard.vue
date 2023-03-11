<template>
    <div class="px-4 w-full xl:w-1/3">
        <div class="my-4">
            <swiper                
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
                    <Image class="w-full h-full object-cover" :src="image.path"/>
                </swiper-slide>                
                <div class="swiper-image-prev max-[768px]:hidden absolute top-0 left-0 z-10 bg-transparent w-[50%] h-full"></div>
                <div class="swiper-image-next max-[768px]:hidden absolute top-0 right-0 z-10 bg-transparent w-[50%] h-full"></div>
                <div class="swiper-pagination abosolute left-[50%] transform translate-[50%] bottom-[16px]"></div>
            </swiper>
            <div class="bg-white rounded-2xl p-5 shadow-xl	relative z-10">
                <div class="flex mb-4">
                    <button data="rating-open" class="btn-disabled flex text-sm py-1 px-2 rounded-md bg-sky-100	mr-2">                        
                        <div class="mr-2">
                            <img src="/img/star.svg">
                        </div>
                        <div>
                            <b>0</b> (0)
                        </div>
                    </button>
                    <div data="rating-modal" class="absolute bg-white rounded-2xl p-5 xl:p-6 z-20 xl:h-96 left-0 top-0 w-full h-full hidden">
                        <div class="flex justify-center mb-6">
                            <button data="rating-close" class="btn-disabled flex text-sm py-1 px-2 rounded-md mr-2">
                                <div class="mr-2">
                                    <img src="/img/star2.svg">
                                </div>
                                <div>
                                    <b>0</b>
                                    (0)
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
                    <cashback-tag :with-chashback="hotel.is_cashback ?? false"/>
                </div>
                <div class="text-center text-sm mb-1">
                    {{ hotel?.type?.single_name ?? 'Отель' }}
                </div>
                <div class="mb-6">
                    <a href="#" target="_blank" class="block font-bold text-xl leading-6 text-center underline text-[#6170FF]">
                        {{ hotel.name }}
                    </a>
                </div>
                <div>
                    <hotel-address :address="hotel.address"/>                    
                    <div v-if="hotel.metros[0]" class="flex mb-2">
                        <div class="flex mr-2">
                            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.2343 12.231H16.3397L12.6234 3H12.6203L10.1173 8.22059L7.62034 3H7.61728L3.89485 12.231H3.00024V13H8.12586V12.231H7.1087L8.29436 9.30208L10.1173 13L11.9463 9.30208L13.1259 12.231H12.1087V13H17.2343V12.231Z" :fill="'#' + hotel.metros[0].color"></path>
                            </svg>
                        </div>
                        <div class="flex leading-tight text-sm">
                            <a href="#" class="underline text-[#6170FF]">{{ hotel.metros[0].name }}</a>
                            <span class="px-2">
                                <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5783 1.02181C10.3334 1.08616 10.0714 1.24558 9.90132 1.43384C9.62119 1.74392 9.57115 1.87651 9.57024 2.31129C9.56918 2.77854 9.68186 3.04638 9.9957 3.32265C10.7154 3.95611 11.874 3.61503 12.1427 2.69057C12.3245 2.06537 12.011 1.38211 11.4232 1.12253C11.1834 1.01663 10.7809 0.968659 10.5783 1.02181ZM10.0772 4.24312C9.87339 4.29086 7.89735 5.46705 7.69427 5.66142C7.57278 5.77768 7.53783 5.89683 7.26899 7.11105C6.93089 8.63768 6.92483 8.761 7.1763 8.99142C7.38782 9.18528 7.60842 9.22683 7.8331 9.11516C7.92716 9.06842 8.04173 8.97858 8.08768 8.91552C8.13882 8.84539 8.26035 8.38232 8.40065 7.72309C8.52677 7.13031 8.64913 6.60078 8.67257 6.5463C8.71426 6.44934 9.12197 6.13679 9.1588 6.17357C9.16903 6.18384 9.12583 6.45929 9.06272 6.7857C8.76071 8.34764 8.70994 8.7372 8.77016 9.03017C8.83483 9.34497 8.98173 9.65326 9.1666 9.86244C9.23677 9.94183 9.63472 10.2667 10.0509 10.5843C11.1236 11.403 11.1883 11.4615 11.2388 11.658C11.2628 11.7514 11.3463 12.3953 11.4243 13.089C11.5966 14.6211 11.5871 14.5729 11.7564 14.7658C12.1285 15.1896 12.9113 15.0076 13.0464 14.4659C13.062 14.4033 13.0336 14.0009 12.9834 13.5715C12.9332 13.1422 12.8513 12.4297 12.8014 11.9883C12.7515 11.5469 12.6984 11.1238 12.6834 11.0481C12.62 10.7286 12.4555 10.5515 11.6395 9.92449C11.1963 9.58396 10.8219 9.26407 10.8074 9.21362C10.7929 9.16317 10.835 8.83296 10.9009 8.47982C10.9668 8.12668 11.0388 7.73455 11.061 7.60843C11.0832 7.48231 11.1859 6.9148 11.2891 6.34725C11.4178 5.63996 11.4676 5.25769 11.4474 5.13189C11.3787 4.70326 11.0248 4.33264 10.5967 4.24082C10.337 4.18515 10.3242 4.18519 10.0772 4.24312ZM11.4791 6.44971C11.4218 6.7591 11.3643 7.06564 11.3511 7.13091C11.3298 7.23658 11.3915 7.30464 11.9123 7.75005C12.2341 8.02532 12.6045 8.34567 12.7353 8.46203C13.0264 8.72092 13.2355 8.77485 13.4811 8.65437C13.7408 8.52697 13.8705 8.30137 13.8444 8.02207C13.825 7.81445 13.8007 7.77358 13.5766 7.57344C13.137 7.18071 11.6517 5.91188 11.6169 5.89935C11.5983 5.89266 11.5363 6.14032 11.4791 6.44971ZM8.74985 9.74104C8.66358 9.99402 7.83594 14.0745 7.83323 14.2601C7.8269 14.6927 8.12432 14.9885 8.56612 14.9888C8.82763 14.9891 9.07162 14.8575 9.19398 14.6504C9.23191 14.5862 9.43127 13.7287 9.63701 12.745C9.84275 11.7612 10.0192 10.9254 10.0292 10.8876C10.0407 10.844 9.91499 10.7209 9.68531 10.5509C9.27149 10.2447 9.01149 10.0081 8.87088 9.80984C8.79777 9.70674 8.76741 9.68949 8.74985 9.74104Z" fill="#515561"></path>
                                </svg>
                            </span>
                            {{ hotel.metros[0].distance }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative bg-white rounded-bl-2xl rounded-br-2xl px-4 pb-4 pt-6 mx-4">
                <div class="flex justify-between text-center">                    
                    <cost-item 
                        v-for="cost in (hotel.min_costs ?? [])" 
                        :value="cost.value"
                        :name="cost.name"
                        :info="cost.info"
                        :description="cost.description"
                    />                     
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Swiper, SwiperSlide } from 'swiper/vue'
    import SwiperCore, { Pagination, Navigation } from "swiper"
    import CashbackTag from '@/components/ui/CashbackTag.vue'
    import Image from '@/components/ui/Image.vue'
    import CostItem from '@/components/ui/CostItem.vue'
    import HotelAddress from '@/components/ui/HotelAddress.vue'
    
    // install Swiper modules
    SwiperCore.use([Pagination, Navigation]);
    export default {
        components: {
            Swiper,
            SwiperSlide,
            CashbackTag,
            Image,
            CostItem,
            HotelAddress,
        },
        props: {
            hotel: Object,
        },
        data() {
            return {
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,                                                       
                    renderBullet: function (index, className) {                        
                        return '<span class="' + className +  ' !opacity-100 w-[6px] rounded-[50%] h-[6px] mx-[2px] border-none p-0 ">' + '</span>';
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
