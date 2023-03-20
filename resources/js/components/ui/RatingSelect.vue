<template>
  <div class="relative z-[5]">
    <button
      select-data="rating"
      data="button-tab"
      class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between"
    >
      <div class="flex items-center gap-[8px]">
        <svg
          width="20"
          height="20"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M10 14.1667L5 16.6667L6.25 11.6667L2.5 7.5L7.91667 7.08333L10 2.5L12.0833 7.08333L17.5 7.5L13.75 11.6667L15 16.6667L10 14.1667Z"
            stroke="#6170FF"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          ></path>
        </svg>
        <span select-text="" class="text-[14px] leading-[16px]">Любой</span>
      </div>
      <svg
        data="filter-arrow"
        width="12"
        height="12"
        viewBox="0 0 12 12"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333"
          stroke="#6170FF"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
      </svg>
      <svg
        data="filter-close"
        class="hidden"
        width="12"
        height="12"
        viewBox="0 0 12 12"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <g clip-path="url(#clip0_790_13114)">
          <path
            d="M0.999146 0.999203L10.9999 11"
            stroke="#6170FF"
            stroke-width="2"
            stroke-linecap="round"
          ></path>
          <path
            d="M0.999146 11L10.9999 0.999203"
            stroke="#6170FF"
            stroke-width="2"
            stroke-linecap="round"
          ></path>
        </g>
        <defs>
          <clipPath id="clip0_790_13114">
            <rect width="12" height="12" fill="white"></rect>
          </clipPath>
        </defs>
      </svg>
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
