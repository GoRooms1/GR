<template>
  <div
    v-if="
      $page.props.modals.search == false &&
      $page.props?.is_map === true
    "
    @click="showSearchPanel()"
    class="w-[56px] absolute md:top-[114px] top-[64px] max-[832px]:left-4 left-[calc(50%-416px)] hidden lg:block"
  >
    <div
      class="shadow-xl w-full bg-white rounded-t-[16px] rounded-b-none p-0 px-[8px] py-[12px] flex items-center"
    >
      <button class="p-[8px]">
       <img src="/img/search.svg" alt="search" width="24" height="24"/>
      </button>
    </div>
    <div class="">
      <div
        class="p-[8px] flex items-center gap-[8px] bg-[#EAEFFD] rounded-b-[16px]"
      >
        <button class="p-[8px]">
          <img src="/img/chevronsmalldown.svg" alt="chevronsmalldown" width="20" height="12"/>
        </button>
      </div>
    </div>
  </div>

  <div
    v-if="$page.props.modals.search !== false"
    class="z-[11] max-w-[832px] w-full mx-auto transition"
    :class="
      $page.props?.is_map === true
        ? 'absolute md:top-[114px] top-[64px] max-[832px]:left-0 left-[calc(50%-416px)]'
        : 'md:relative px-[16px] md:pt-[64px] pt-[32px] md:pb-[52px] pb-[24px] ' +
          panelPosition
    "
  >
    <div class="relative">
      <Search />
      <div class="md:flex justify-between hidden">
        <div
          class="p-[8px] flex items-center gap-[8px]"
          :class="
            $page.props?.is_map === true
              ? 'bg-[#EAEFFD] rounded-b-[16px]'
              : ''
          "
        >
          <filter-attr-toggle
            title="Low Cost"
            type="small"
            initial-value="true"
            :model-value="$page.props?.filters?.rooms?.low_cost ?? null"
            @update:modelValue="
              (event) => filterValueHandler('rooms', false, 'low_cost', event)
            "
          />
          <filter-attr-toggle
            title="От 1 часа"
            type="small"
            :initial-value="68"
            :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 68)"
            @update:modelValue="
              (event) => filterValueHandler('rooms', true, 'attr_68', event)
            "
          />
          <Link 
            href="/hot"
            class="px-[12px] h-[32px] flex items-center gap-[8px] justify-center md:hover:outline outline-solid outline-[#6170FF] transition duration-150 rounded-[8px] "
            :class="($page.props?.filters?.rooms?.is_hot ?? false) ? 'bg-[#6170FF] text-white' : 'bg-white'"
          >            
            <span class="text-[14px] leading-[16px] whitespace-nowrap">Горящие</span>
          </Link>          
          <filter-attr-toggle title="Кешбэк" type="small" disabled />
          <filter-attr-toggle
            title="Арт дизайн"
            type="small"
            :initial-value="52"
            :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 52)"
            @update:modelValue="
              (event) => filterValueHandler('rooms', true, 'attr_52', event)
            "
          />
          <filter-attr-toggle
            title="Джакузи"
            type="small"
            :initial-value="65"
            :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 65)"
            @update:modelValue="
              (event) => filterValueHandler('rooms', true, 'attr_65', event)
            "
          />
        </div>
        <div
          class="p-[8px]"
          :class="
            $page.props?.is_map === true
              ? 'md:block hidden bg-[#EAEFFD] rounded-b-[16px]'
              : ''
          "
        >
          <button
            @click="openFilters()"
            class="flex items-center gap-[16px] p-[8px]"
          >
            <span class="text-[14px] leading-[16px] whitespace-nowrap"
              >Больше фильтров</span
            >
            <svg
              width="12"
              height="20"
              viewBox="0 0 12 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M1.83301 13.0002L5.99967 17.1669L10.1663 13.0002"
                stroke="#6171FF"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              ></path>
              <path
                d="M10.167 7.16692L6.00033 3.00025L1.83366 7.16692"
                stroke="#6171FF"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              ></path>
            </svg>
          </button>
        </div>
      </div>
      <div
        class="md:p-[8px] p-0 pt-[8px] flex items-center gap-[8px] flex-wrap"
      >
        <city-filter-tag
          v-if="$page.props?.filters?.hotels?.city"
          :title="$page.props?.filters?.hotels?.city"
          :cities="$page.props?.city_tag_list ?? []"       
        />
        <filter-tag
          v-for="tag in ($page.props?.filter_tags ?? [])" v-bind:key="tag.key + '_' + tag.value"
          :title="tag.title"
          :filter-model="tag.modelType"
          :filter-key="tag.key"
          :is-attribute="tag.isAttribute"
          :filter-value="tag.value"
          :removable="true"
          @tag-closed="(event) => closeTag(event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import FilterAttrToggle from "@/components/ui/FilterAttrToggle.vue";
import FilterTag from "@/components/ui/FilterTag.vue";
import CityFilterTag from "@/components/ui/CityFilterTag.vue";
import Search from "./Search.vue";
import {_updateFilterValue} from "@/Services/filterUtils.js";
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    FilterAttrToggle,
    FilterTag,
    CityFilterTag,
    Search,
    Link,
  },
  mounted() {
    if (typeof window !== "undefined") {
      window.addEventListener("resize", this.handleResize);
      window.addEventListener("scroll", this.handleScroll, {passive: true});
    }

    this.handleResize();
    this.$page.props.modals.search = true;
  },
  unmounted() {
    if (typeof window !== "undefined") {
      window.removeEventListener("resize", this.handleResize);
      window.removeEventListener("scroll", this.handleScroll);
    }
  },
  data() {
    return {      
      panelPosition: "",
      scrollY: 0,
    };
  },
  methods: {
    openFilters() {
      this.$eventBus.emit("filters-open");
    },    
    showSearchPanel() {
      this.$page.props.modals.search = true;
    }, 
    filterValueHandler(model, isAttr = false, key, value) {
      _updateFilterValue.call(this, model, isAttr, key, value);
      this.$eventBus.emit("filters-changed");
    },   
    closeTag(obj) {
      this.filterValueHandler(obj.modelType, obj.isAttribute, obj.key, null);
    },
    handleResize() {
      if (typeof window !== "undefined") {
        if (window.innerWidth > 1024) this.$page.props.modals.search = true;
      }
    },
    handleScroll() {
      if (typeof window !== "undefined") {
        if (window.innerWidth < 768) {
          this.scrollY = window.scrollY ?? this.scrollY;

          if (this.scrollY >= 30) this.panelPosition = "fixed";
          else this.panelPosition = "";
        } else {
          this.panelPosition = "";
        }
      }
    },
  },
};
</script>
