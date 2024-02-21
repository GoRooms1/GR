<template>
  <div class="mt-2 mb-4 flex flex-col">    
    <div v-if="review?.images?.[0]?.conversions?.card" class="overflow-hidden relative mx-6 h-60 rounded-tl-2xl rounded-tr-2xl">
        <img class="w-full h-full object-cover" :src="review.images[0].conversions.card" alt="img">
    </div>    
    <div class="flex bg-white rounded-2xl shadow-xl relative z-10 overflow-hidden">
      <div class="flex w-full">
        <div class="flex flex-col flex-1 h-full bg-white p-6 rounded-[24px]">
          <div class="flex items-center justify-between py-[6px] mb-[12px]">
            <div class="flex items-center gap-[8px]">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 14.1667L5 16.6667L6.25 11.6667L2.5 7.5L7.91667 7.08333L10 2.5L12.0833 7.08333L17.5 7.5L13.75 11.6667L15 16.6667L10 14.1667Z" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
              <span class="text-[14px] leading-[16px] font-semibold">{{ review.avg_rating }}</span>
            </div>
            <span class="text-[16px] leading-[19px] font-semibold">{{ review.name }}</span>
            <span class="text-[12px] leading-[14px]">{{ (new Date(review.created_at)).toLocaleDateString('ru', {day: 'numeric', month: 'long', year: 'numeric',}) }}</span>
          </div>
          <p class="text-[14px] leading-[16px] mb-[12px]">
              {{ review.text }}
          </p>
          <div class="grid grid-cols-2 gap-x-[24px] gap-[16px] mt-auto">
            <div v-for="rating in review.ratings">
              <div class="flex items-center justify-between mb-[8px]">
                <span class="text-[12px] leading-[14px]">{{ rating.category_name }}</span>
                <span class="text-[12px] leading-[14px]">{{ rating.value }}</span>
              </div>
              <div class="w-full h-[4px] bg-[#EAEFFD] rounded-[2px] overflow-hidden">
                <div class="h-full bg-[#6170FF] rounded-[2px]"  :style="'width: '+(rating.value*10)+'%;'"></div>
              </div>
            </div>                  
          </div>
        </div>
      </div>        
    </div>
  </div>
</template>

<script>
export default {
  props: {
    review: Object,
  }
};
</script>
