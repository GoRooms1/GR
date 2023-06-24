<template>
  <div class="flex lg:hidden w-full p-2">
    <button
      @click="getDataOnMap()"
      class="p-2.5 rounded-l-lg"
      :class="
        $page.props?.is_map === true
          ? 'bg-[#6170FF]'
          : 'bg-[#EAEFFD]'
      "
    >
      <img
        :src="
          $page.props?.is_map === true
            ? '/img/map2.svg'
            : '/img/map.svg'
        "
        alt="map"
        width="24"
        height="24"
      />
    </button>
    <button
      @click="getDataOnList()"
      class="p-2.5 rounded-r-lg mr-[10%]"
      :class="
        $page.props?.is_map !== true
          ? 'bg-[#6170FF]'
          : 'bg-[#EAEFFD]'
      "
    >
      <img
        :src="
          $page.props?.is_map !== true
            ? '/img/listpointers2.svg'
            : '/img/listpointers.svg'
        "
        alt="listpointers"
        width="24" height="24"
      />
    </button>
    <button
      @click="toggleSearchPanel"
      class="p-2.5 rounded-lg mx-[1.7%] ml-auto"
      :class="
        $page.props.modals.search === false ? 'bg-[#EAEFFD]' : 'bg-[#6170FF]'
      "
    >
      <img
        :src="
          $page.props.modals.search === false
            ? '/img/search.svg'
            : '/img/search2.svg'
        "
        alt="search"
        width="24" height="24"
      />
    </button>
    <button
      @click="openFilters()"
      class="p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]"
    >
      <img src="/img/filters.svg" alt="filters" width="24" height="24"/>
    </button>
    <filter-attr-toggle
      type="square"
      img="/img/bolt.svg"
      toggle-img="/img/bolt2.svg"
      initial-value="true"
      :model-value="null"     
      disabled
    />
    <button
      class="btn-disabled pointer-events-none p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]"
    >
      <img src="/img/footer-cashback.svg" alt="footer-cashback" width="24" height="24"/>
    </button>
    <button
      class="btn-disabled pointer-events-none p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]"
    >
      <img src="/img/heart.svg" alt="heart" width="24" height="24"/>
    </button>
  </div>
</template>

<script>
import FilterAttrToggle from "@/components/ui/FilterAttrToggle.vue";
import {_getFiltersData, _getData} from "@/Services/filterUtils.js";

export default {
  components: {
    FilterAttrToggle,
  },  
  methods: {
    getDataOnList() {
      let data = _getFiltersData.call(this);
      data.as = null;
      _getData.call(this, '/search', data);
      this.$page.props.modals.search = true;  
    },
    getDataOnMap() {
      let data = _getFiltersData.call(this);
      data.as = 'map';
      _getData.call(this, '/search', data, () => {this.$eventBus.emit("data-received")});       
    },    
    openFilters() {
      this.$eventBus.emit("filters-open");
    },
    toggleSearchPanel() {
      this.$page.props.modals.search = !this.$page.props.modals.search;
    },
  },
};
</script>
