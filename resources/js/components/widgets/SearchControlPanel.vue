<template>
  <div class="flex lg:hidden w-full p-2">
    <button @click="getDataOnMap()" class="p-2.5 rounded-l-lg"
      :class="route().current() == 'search.map' ? 'bg-[#6170FF]' : 'bg-[#EAEFFD]'"
    >
      <img :src="route().current() == 'search.map' ? '/img/map2.svg' : '/img/map.svg'" alt="map" />
    </button>
    <button @click="getDataOnList()" class="p-2.5 rounded-r-lg mr-[10%]"
    :class="route().current() != 'search.map' ? 'bg-[#6170FF]' : 'bg-[#EAEFFD]'">
      <img :src="route().current() != 'search.map' ? '/img/listpointers2.svg' : '/img/listpointers.svg'" alt="listpointers" />
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
    getDataOnList() {
      this.$inertia.get(route("search.list"), this.filterStore.getFiltersValues(), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
        only: ['hotels', 'rooms', 'is_rooms_filter'],
        //onSuccess: () => {},
        onStart: () => {
          usePage().props.value.isLoadind = true;
        },
        onFinish: () => {
          usePage().props.value.isLoadind = false;
        },
      });      
    },
    getDataOnMap() {
      this.$inertia.get(route("search.map"), this.filterStore.getFiltersValues(), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
        only: ['hotels', 'rooms', 'is_rooms_filter'],
        //onSuccess: () => {},
        onStart: () => {
          usePage().props.value.isLoadind = true;
        },
        onFinish: () => {
          usePage().props.value.isLoadind = false;
          eventBus.emit('data-received');
        },
      });      
    },    
    filterValueHandler(model, isAttr = false, key, value) {
      if (value == null) {
        this.filterStore.removeFilter(model, key);
      } else {
        this.filterStore.updateFilter(model, isAttr, key, value);
      }

      eventBus.emit('filters-changed');
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
