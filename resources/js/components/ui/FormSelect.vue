<template>
  <div
    v-click-outside="hide"
    class="relative"
    :class="collapsed ? 'z-[1]' : 'z-[5]'"
  >
    <button
      type="button"
      @click="toggle()"
      class="w-full px-[12px] h-[32px] flex items-center justify-between bg-[#EAEFFD] rounded-[8px]"
      :class="
        options.length == 0 && !searchable
          ? 'btn-disabled pointer-events-none'
          : ''
      "
    >
      <span class="text-md leading-[16px]">{{
        getOptionName(selectedOption) ?? placeholder
      }}</span>
      <img v-if="selectedOption == null || notNull == true" src="/img/select_arrow.svg" alt="arrow" class="block"  :class="collapsed ? '' : 'rotate-180'" width="12" height="12"/>      
    </button>
    <div v-if="selectedOption && notNull == false" class="relative">
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
      class="absolute top-[32px] z-10 w-full"
    >
      <div class="flex items-center justify-between bg-[#EAEFFD] w-full">
        <div class="bg-white h-[16px] rounded-r-[8px]" style="width: 45%;"></div>
        <div class="bg-white h-[16px] rounded-l-[8px]" style="width: 45%;"></div>
      </div>
      <div
        class="filter-scrollbar2 flex flex-col gap-[8px] rounded-[8px] bg-[#EAEFFD] py-[12px] px-[16px] overflow-y-auto max-h-[296px] md:max-h-[calc(45vh-48px)]"
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
          type="button"
          v-for="option in options"
          @click="choose"
          :data-key="option.key"
          :data-name="option.name"
          class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
        >
          {{ option.name }}
        </button>
        <div v-if="options.length == 0 && searchable">
          <span class="p-[16px]">Совпадений не найдено</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import selectOptions from "@/Services/selectOptions.js";
export default selectOptions();
</script>
