<template>
  <div class="flex lg:hidden w-full p-2">
    <button class="p-2.5 rounded-l-lg bg-[#EAEFFD]">
      <img src="/img/map.svg" alt="map" />
    </button>
    <button @click="getData()" class="p-2.5 rounded-r-lg mr-[10%] bg-[#6170FF]">
      <img src="/img/listpointers2.svg" alt="listpointers" />
    </button>
    <button @click="toggleSearchPanel"
      class="p-2.5 rounded-lg mx-[1.7%] ml-auto"
      :class="$page.props.modals.search === false ? 'bg-[#EAEFFD]' : 'bg-[#6170FF]'"  
    >
      <img :src="$page.props.modals.search === false ? '/img/search.svg' : '/img/search2.svg'" alt="search" />
    </button>
    <button
      @click="toggleFilters()"
      class="p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]"
    >
      <img src="/img/filters.svg" alt="filters" />
    </button>
    <filter-attr-toggle        
        type="square"
        img="/img/bolt.svg"
        toggle-img="/img/bolt2.svg"
        initial-value="true"
        :model-value="filterStore.getFilterValue('rooms', 'is_hot')"
        @update:modelValue="
          (event) => filterValueHandler('rooms', false, 'is_hot', event)
        "
      />
    <button
      class="btn-disabled pointer-events-none p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]"
    >
      <img src="/img/footer-cashback.svg" alt="footer-cashback" />
    </button>
    <button
      class="btn-disabled pointer-events-none p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]"
    >
      <img src="/img/heart.svg" alt="heart" />
    </button>
  </div>
</template>

<script>
import { usePage } from "@inertiajs/inertia-vue3";
import { filterStore } from "@/Store/filterStore.js";
import FilterAttrToggle from "@/components/ui/FilterAttrToggle.vue";

export default {
  components: {
    FilterAttrToggle,
  },
  data() {
    return {
      filterStore,
    };
  },
  methods: {
    getData() {
      this.$inertia.get(route("filter"), this.filterStore.getFiltersValues(), {
        preserveState: true,
        preserveScroll: true,
        onStart: () => {
          usePage().props.value.isLoadind = true;
        },
        onFinish: () => {
          usePage().props.value.isLoadind = false;
        },
      });
    },
    filterValueHandler(model, isAttr = false, key, value) {
      if (value == null) {
        this.filterStore.removeFilter(model, key);
      } else {
        this.filterStore.updateFilter(model, isAttr, key, value);
      }
    },
    toggleFilters() {
      usePage().props.value.modals.filters =
        !usePage().props.value.modals.filters;
    },
    toggleSearchPanel() {
      usePage().props.value.modals.search = !usePage().props.value.modals.search;
    }
  },
};
</script>
