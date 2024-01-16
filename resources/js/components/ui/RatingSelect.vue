<template>
  <div class="relative z-[5]">
    <button      
      class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between"
    >
      <div class="flex items-center gap-[8px]">
        <img src="/img/star.svg" alt="star"/>
        <span class="text-[14px] leading-[16px]">Любой</span>
      </div>
      <img src="/img/select_arrow.svg" alt="arrow" width="12" height="12"/>    
    </button>
    <div
      class="absolute top-[32px] sm:left-0 right-[-16px] z-10 sm:w-full w-[calc(200%+48px)] hidden"
    >
      <div class="flex items-center justify-between bg-white w-full">
        <div
          class="sm:w-[45%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"
        ></div>
        <div
          class="sm:w-[45%] w-[26%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"
        ></div>
      </div>
      <div
        class="flex flex-col gap-[8px] rounded-[8px] bg-white py-[12px] px-[16px] shadow-xl"
      >
        <button
          select-parent="rating"
          class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
        >
          Любой
        </button>
        <button
          select-parent="rating"
          class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
        >
          6+
        </button>
        <button
          select-parent="rating"
          class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
        >
          7+
        </button>
        <button
          select-parent="rating"
          class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
        >
          8+
        </button>
        <button
          select-parent="rating"
          class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
        >
          9+
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {},
};
</script>
