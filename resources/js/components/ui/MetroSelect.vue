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
        <svg
          width="20"
          height="20"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M17.2344 14.231H16.3398L12.6235 5H12.6205L10.1174 10.2206L7.62046 5H7.6174L3.89497 14.231H3.00037V15H8.12598V14.231H7.10882L8.29448 11.3021L10.1174 15L11.9464 11.3021L13.126 14.231H12.1088V15H17.2344V14.231Z"
            fill="#6170FF"
          ></path>
        </svg>
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
      class="absolute max-[768px]:top-[32px] max-[768px]:right-[-16px] z-100 md:w-[376px] w-[calc(200%+48px)]"
    >
      <div class="flex items-center justify-between bg-white w-full">
        <div
          class="md:w-[22%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"
        ></div>
        <div
          class="md:w-[73%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"
        ></div>
      </div>
      <div
        class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[200px] md:max-h-[calc(45vh-144px)] overflow-y-auto rounded-[8px] shadow-xl"
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
            <MetroIcon :color="option.color"/>
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
import MetroIcon from "@/components/ui/MetroIcon.vue";

let options = selectOptions();
options.components = {...options.components, ...{MetroIcon}};
export default options;
</script>
