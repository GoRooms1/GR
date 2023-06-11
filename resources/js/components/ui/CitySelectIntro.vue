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
      <img src="/img/select_arrow.svg" alt="arrow" class="block"  :class="collapsed ? '' : 'rotate-180'" width="12" height="12"/>
    </button>
    <div
      v-if="!collapsed"
      class="absolute top-[32px] z-10 w-[calc(200%+4rem)] max-[330px]:w-[calc(100%+3rem)] left-[-1.5rem]"
    >
      <div class="flex items-center justify-between bg-white w-full">
        <div
          class="w-[24%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"
        ></div>
        <div
          class="w-[72%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"
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
