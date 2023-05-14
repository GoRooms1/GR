<template>
  <div
    v-click-outside="hide"
    class="relative mt-2"
    :class="collapsed ? 'z-[1]' : 'z-[5]'"
  >
    <button
      @click="toggle()"
      class="w-full px-[12px] h-8 bg-white rounded-[8px] flex items-center justify-between"
      :class="
        options.length == 0 && !searchable
          ? 'btn-disabled pointer-events-none'
          : ''
      "
    >
      <span class="text-[0.875rem] leading-[1rem]">{{
        getOptionName(selectedOption) ?? placeholder
      }}</span>
      <img v-if="selectedOption == null || notNull == true" src="/img/select_arrow.svg" alt="arrow" class="block"  :class="collapsed ? '' : 'rotate-180'"/>     
    </button>
    <div
      v-if="!collapsed"
      class="absolute top-[2rem] lg:left-0 left-[-0.875rem] z-10"
    >
      <div class="flex items-center justify-between bg-white w-full">
        <div
          class="w-[45%] lg:w-[25%] bg-[#EAEFFD] h-[1rem] rounded-r-[8px]"
        ></div>
        <div
          class="w-[45%] lg:w-[60%] bg-[#EAEFFD] h-[1rem] rounded-l-[8px]"
        ></div>
      </div>
      <div
        class="flex flex-col gap-[8px] rounded-[8px] bg-white py-[12px] shadow-xl"
      >
        <div class="filter-scrollbar3 overflow-y-auto max-h-[300px] px-[1rem]">
          <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
            <button
              v-for="option in options"
              @click="choose"
              :data-key="option.key"
              :data-name="option.name"
              class="text-[0.875rem] leading-[1rem] w-full px-[8px] h-[2rem] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
            >
              {{ option.name }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import selectOptions from "@/Services/selectOptions.js";
export default selectOptions();
</script>
