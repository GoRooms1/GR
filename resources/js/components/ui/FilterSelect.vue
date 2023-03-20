<template>
  <div
    v-click-outside="hide"
    class="relative"
    :class="collapsed ? 'z-[1]' : 'z-[5]'"
  >
    <button
      @click="toggle()"
      class="w-full px-[12px] h-[32px] flex items-center justify-between bg-white rounded-[8px]"
      :class="
        options.length == 0 && !searchable
          ? 'btn-disabled pointer-events-none'
          : ''
      "
    >
      <span class="text-sm leading-[16px]">{{
        getOptionName(selectedOption) ?? placeholder
      }}</span>
      <svg
        v-if="selectedOption == null || notNull == true"
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
    <div v-if="selectedOption && notNull == false" class="relative">
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
      class="absolute top-[32px] sm:left-0 left-[-16px] z-10 sm:w-full w-[calc(200%+48px)]"
    >
      <div class="flex items-center justify-between bg-white w-full">
        <div
          class="sm:w-[45%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"
        ></div>
        <div
          class="sm:w-[45%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"
        ></div>
      </div>
      <div
        class="filter-scrollbar2 flex flex-col gap-[8px] rounded-[8px] bg-white py-[12px] px-[16px] shadow-xl overflow-y-auto max-h-[296px] md:max-h-[calc(45vh-48px)]"
      >
        <div v-if="searchable" class="bg-white rounded-t-[8px]">
          <input
            type="text"
            :placeholder="placeholder"
            v-model="searchValue"
            class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-sm leading-[16px]"
          />
        </div>
        <button
          v-for="option in options"
          @click="choose"
          :data-key="option.key"
          :data-name="option.name"
          class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
        >
          {{ option.name }}
        </button>
        <div v-if="options.length == 0 && searchable">
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
