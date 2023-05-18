<template>
  <div
    v-click-outside="hide"
    :class="(collapsed ? 'z-[1]' : 'z-[4]') + ' ' + position"
  >
    <button      
      @click="toggle()"
      type="button"
      class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between"
    >
      <span class="text-[14px] leading-[16px]">{{
        selectedOption ? selectedOption : placeholder
      }}</span>
      <img v-if="!selectedOption || $page.props?.is_moderator === false" src="/img/select_arrow.svg" alt="arrow" class="block"  :class="collapsed ? '' : 'rotate-180'"/>
    </button>
    <div v-if="selectedOption && $page.props?.is_moderator === true" class="relative">
      <button
        type="button"
        @click="clear()"
        class="px-[12px] h-[32px] select-clear"
      >
        <img src="/img/select_clear.svg" alt="clear"/>
      </button>
    </div>
    <div
      v-if="!collapsed"
      class="absolute max-[768px]:top-[32px] max-[768px]:right-[-16px] z-10 md:w-[376px] w-[calc(200%+48px)]"
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
        class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[344px] md:max-h-[calc(45vh)] overflow-y-auto rounded-[8px] shadow-xl"
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
            type="button"
            class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
          >
            {{ option.name }}
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
