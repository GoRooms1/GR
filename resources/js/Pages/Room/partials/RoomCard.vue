<template>
    <div class="px-4 w-full xl:w-1/3">
       {{ room }}
    </div>
</template>

<script>
    import { Swiper, SwiperSlide } from 'swiper/vue'
    import SwiperCore, { Pagination, Navigation } from "swiper"
    import CashbackTag from '@/components/ui/CashbackTag.vue'
    import Image from '@/components/ui/Image.vue'
    
    // install Swiper modules
    SwiperCore.use([Pagination, Navigation]);
    export default {
        components: {
            Swiper,
            SwiperSlide,
            CashbackTag,
            Image,
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
                        return '<span class="' + className +  ' !opacity-100 w-[6px] rounded-[50%] h-[6px] mx-[2px] border-none p-0 ">' + '</span>';
                    },
                },
                navigation: {
                    nextEl: '.swiper-image-next',
                    prevEl: '.swiper-image-prev',
                },
            }
        },
        methods: {
            
        }      
    }
</script>
