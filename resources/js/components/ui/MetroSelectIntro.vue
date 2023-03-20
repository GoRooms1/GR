<template>
  <div
    v-click-outside="hide"
    :class="(collapsed ? 'z-[1]' : 'z-[4]') + ' ' + position"
  >
    <button
      @click="toggle()"
      type="button"
      class="w-full px-[12px] h-[32px] flex items-center bg-white justify-between rounded-[8px]"
    >
      <div class="flex items-center gap-[8px]">
        <span class="flex items-center text-sm leading-[16px]">{{
          selectedOption ? selectedOption : placeholder
        }}</span>
      </div>
      <svg
        v-if="!selectedOption"
        width="12"
        height="12"
        viewBox="0 0 12 12"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        class="block"
        :class="collapsed ? '' : 'rotate-180'"
      >
        <path
          d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333"
          stroke="#6170FF"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
      </svg>
    </button>
    <div v-if="selectedOption" class="relative">
      <button
        type="button"
        @click="clear()"
        class="px-[12px] h-[32px] select-clear"
      >
        <svg
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
    </div>
    <div
      v-if="!collapsed"
      class="absolute top-[32px] z-10 w-[calc(200%+4rem)] max-[330px]:w-[calc(100%+3rem)] right-[-1.5rem]"
    >
      <div class="flex items-center justify-between bg-white w-full">
        <div
          class="w-[72%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"
        ></div>
        <div
          class="w-[24%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"
        ></div>
      </div>
      <div
        class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[60vh] overflow-y-auto rounded-[24px] pb-[20px] shadow-xl min-h-[388px] max-h-[388px]"
      >
        <div v-if="searchable" class="bg-white rounded-t-[8px]">
          <input
            type="text"
            :placeholder="placeholder"
            v-model="searchValue"
            class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-sm leading-[16px]"
          />
        </div>
        <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
          <button
            v-for="option in options"
            @click="choose"
            :data-key="option.name"
            class="text-sm leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
          >
            <svg
              width="20"
              height="16"
              viewBox="0 0 20 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M17.2341 12.231H16.3395L12.6232 3H12.6201L10.117 8.22059L7.6201 3H7.61703L3.89461 12.231H3V13H8.12561V12.231H7.10846L8.29412 9.30208L10.117 13L11.9461 9.30208L13.1256 12.231H12.1085V13H17.2341V12.231Z"
                :fill="'#' + option.color"
              ></path>
            </svg>
            <span class="p-[16px]">{{ option.name }}</span>
          </button>
        </div>
        <div v-if="options.length == 0">
          <span class="p-[16px]">Совпаденйи не найдено</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import selectOptions from "@/Services/selectOptions.js";
export default selectOptions();
</script>
