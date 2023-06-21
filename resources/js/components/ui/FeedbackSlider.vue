<template>
  <div
    class="min-h-[416px] rounded-[24px] overflow-hidden bg-[#6170FF] sm:pt-[41px] pb-[41px] pt-[90px] sm:px-[20px] px-[10px]">
    <div class="swiper-feed-wrapper relative overflow-hidden w-full h-[100%]">
      <button
        class="swiper-feed-button-prev cursor-pointer absolute top-[50%] transform translate-1/2 left-0 w-[32px] h-[32px] bg-white rounded-[8px] sm:flex hidden items-center justify-center">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12.084 5.75037L7.91732 9.91703L12.084 14.0837" stroke="#515561" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
      </button>
      <swiper :slides-per-view="2" :slides-per-group="2" :space-between="32" :loop="false"
        :navigation="feedbackNavigation" :breakpoints="feedbackBreakpoints"
        class="swiper-feed overflow-hidden sm:mx-[52px] mx-0 h-[100%]">
        <swiper-slide v-for="item in [1, 2, 3]">
          <div class="bg-white p-[24px] rounded-[24px]">
            <div class="flex items-center justify-between py-[6px] mb-[24px]">
              <div class="flex items-center gap-[8px]">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10 14.1667L5 16.6667L6.25 11.6667L2.5 7.5L7.91667 7.08333L10 2.5L12.0833 7.08333L17.5 7.5L13.75 11.6667L15 16.6667L10 14.1667Z"
                    stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span class="text-[14px] leading-[16px] font-semibold">10</span>
              </div>
              <span class="text-[16px] leading-[19px] font-semibold">Имя{{ item }}</span>
              <span class="text-[12px] leading-[14px]">01 января 2023</span>
            </div>
            <p class="text-[14px] leading-[16px] mb-[24px]">
              Отзыв{{ item }}
            </p>
            <div class="grid grid-cols-2 gap-x-[24px] gap-[16px]">
              <div>
                <div class="flex items-center justify-between mb-[8px]">
                  <span class="text-[12px] leading-[14px]">Расположение</span>
                  <span class="text-[12px] leading-[14px]">10</span>
                </div>
                <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                  <div class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"></div>
                </div>
              </div>
              <div>
                <div class="flex items-center justify-between mb-[8px]">
                  <span class="text-[12px] leading-[14px]">Персонал</span>
                  <span class="text-[12px] leading-[14px]">10</span>
                </div>
                <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                  <div class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"></div>
                </div>
              </div>
              <div>
                <div class="flex items-center justify-between mb-[8px]">
                  <span class="text-[12px] leading-[14px]">Чистота</span>
                  <span class="text-[12px] leading-[14px]">10</span>
                </div>
                <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                  <div class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"></div>
                </div>
              </div>
              <div>
                <div class="flex items-center justify-between mb-[8px]">
                  <span class="text-[12px] leading-[14px]">WI-FI</span>
                  <span class="text-[12px] leading-[14px]">10</span>
                </div>
                <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                  <div class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"></div>
                </div>
              </div>
              <div>
                <div class="flex items-center justify-between mb-[8px]">
                  <span class="text-[12px] leading-[14px]">Комфорт</span>
                  <span class="text-[12px] leading-[14px]">10</span>
                </div>
                <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                  <div class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"></div>
                </div>
              </div>
              <div>
                <div class="flex items-center justify-between mb-[8px]">
                  <span class="text-[12px] leading-[14px]">Цена</span>
                  <span class="text-[12px] leading-[14px]">10</span>
                </div>
                <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                  <div class="w-[100%] h-full bg-[#6170FF] rounded-[2px]"></div>
                </div>
              </div>
            </div>
          </div>
        </swiper-slide>
      </swiper>
      <button
        class="swiper-feed-button-next cursor-pointer absolute top-[50%] transform translate-1/2 right-0 w-[32px] h-[32px] bg-white rounded-[8px] sm:flex hidden items-center justify-center">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.91602 14.2496L12.0827 10.083L7.91602 5.9163" stroke="#515561" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import SwiperCore, { Pagination, Navigation } from "swiper";

SwiperCore.use([Pagination, Navigation]);
export default {
  data() {
    return {
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
    }
  }
};
</script>
