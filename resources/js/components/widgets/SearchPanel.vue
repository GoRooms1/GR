<template>
  <div v-if="$page.props.modals.search !== false"
    class="z-[11] max-w-[832px] w-full mx-auto px-[16px] md:pt-[64px] pt-[32px] md:pb-[52px] pb-[24px] transition"
  >
    <div class="relative">
      <Search />      
      <div class="md:flex justify-between hidden">
        <div class="p-[8px] flex items-center gap-[8px]">
          <filter-attr-toggle
            title="Low Cost"
            type="small"
            initial-value="true"
            v-model="low_cost"
          />
          <filter-attr-toggle
            title="От 1 часа"
            type="small"
            :initial-value="68"
            :model-value="filterStore.getFilterValue('rooms', 'attr_68')"
            @update:modelValue="(event) => attributeHandler('rooms', event, 68)"
          />
          <filter-attr-toggle
            title="Горящие"
            type="small"
            initial-value="true"
            v-model="is_hot"
          />
          <filter-attr-toggle title="Кешбэк" type="small" disabled />
          <filter-attr-toggle
            title="Арт дизайн"
            type="small"
            :initial-value="52"
            :model-value="filterStore.getFilterValue('rooms', 'attr_52')"
            @update:modelValue="(event) => attributeHandler('rooms', event, 52)"
          />
          <filter-attr-toggle
            title="Джакузи"
            type="small"
            :initial-value="65"
            :model-value="filterStore.getFilterValue('rooms', 'attr_65')"
            @update:modelValue="(event) => attributeHandler('rooms', event, 65)"
          />
        </div>
        <div class="p-[8px]">
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
        <filter-tag
          v-for="tag in filterStore.filters"
          :filter-model="tag.modelType"
          :filter-key="tag.key"
          :is-attribute="tag.isAttribute"
          :filter-value="tag.value"
          :removable="tag.key == 'city' ? false : true"
          @tag-closed="(event) => closeTag(event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { filterStore } from "@/Store/filterStore.js";
import FilterAttrToggle from "@/components/ui/FilterAttrToggle.vue";
import FilterTag from "@/components/ui/FilterTag.vue";
import Search from "./Search.vue";
import _ from 'lodash';

let filterGetSetObj = function (model, key) {
  return {
    get() {
      return this.filterStore.getFilterValue(model, key);
    },
    set(val) {
      if (val) this.filterStore.updateFilter(model, false, key, val);
      if (val === null) this.filterStore.removeFilter(model, key);
    },
  };
};

export default {
  components: {
    FilterAttrToggle,
    FilterTag,
    Search,
  },
  mounted() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
    usePage().props.value.modals.search = true;
  },
  data() {
    return {
      filterStore,      
    };
  },
  computed: {
    is_hot: filterGetSetObj("rooms", "is_hot"),
    low_cost: filterGetSetObj("rooms", "low_cost"),
  },
  methods: {    
    openFilters() {
      usePage().props.value.modals.filters = true;
    },
    closeFilters() {
      usePage().props.value.modals.filters = false;
    },
    attributeHandler(modelType, filterValue, attrID) {
      if (filterValue == null)
        this.filterStore.removeFilter(modelType, "attr_" + attrID);
      else
        this.filterStore.addFilter(modelType, true, "attr_" + attrID, attrID);
    },
    closeTag(obj) {
      this.filterStore.removeFilter(obj.modelType, obj.key);
    },
    handleResize() {
      if (usePage().props.value.modals.search === false) {        
        if (window.innerWidth > 1024) usePage().props.value.modals.search = true;
      }
    },
  },
};
</script>
