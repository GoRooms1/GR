<template>
  <div v-click-outside="hide" class="relative" :class="collapsed ? 'z-[1]' : 'z-[20]'">
    <button @click="toggle()"
      class="flex items-center gap-[8px] rounded-[10px] bg-[#3B24C6] h-[32px] px-[12px] w-[fit-content]">
      <span class="text-white text-[12px] leading-[14px] whitespace-nowrap">{{
        title
      }}</span>
      <img src="/img/select_arrow_white.svg" alt="arrow" class="block" :class="collapsed ? '' : 'rotate-180'" width="12"
        height="12" />
    </button>
    <div v-show="!collapsed" class="absolute top-[32px] left-[-16px] z-20 w-[calc(200%+48px)]">
      <div class="select-tail"></div>
      <div
        class="filter-scrollbar2 flex flex-col gap-[8px] rounded-[8px] bg-white py-[12px] px-[16px] shadow-xl overflow-y-auto max-h-[296px] md:max-h-[calc(45vh-48px)]">
        <div class="bg-white rounded-t-[8px]">
          <input type="text" placeholder="Город" v-model="searchValue"
            class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-sm leading-[16px]" />
        </div>
        <Link v-for="city in filteredCities" :href="city?.slug + ($page?.props?.filters?.as == 'map' ? '?as=map' : '')"
          class="text-[14px] leading-[16px] w-full p-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150"
          :class="city?.is_center === true ? 'font-bold' : ''"
        >
        {{ city.name }}
        </Link>
        <div v-if="filteredCities.length == 0">
          <span class="text-[14px]">Совпадений не найдено</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vClickOutside from "click-outside-vue3";
import { Link } from "@inertiajs/vue3";

export default {
  directives: {
    clickOutside: vClickOutside.directive,
  },
  components: {
    Link,
  },
  props: {
    title: String,
    cities: Array,
  },
  data() {
    return {
      collapsed: true,
      searchValue: "",
    };
  },
  computed: {
    filteredCities: function () {
      if (this.searchValue) {
        let searchValue = this.searchValue.toLowerCase().trim();
        return this.cities.filter(function (el) {
          return el.name.toString().toLowerCase().startsWith(searchValue);
        }, searchValue);
      } else {
        return this.cities ?? [];
      }
    },
  },
  methods: {
    toggle() {
      this.collapsed = !this.collapsed;
    },
    hide() {
      this.collapsed = true;
    },
  }

}
</script>
