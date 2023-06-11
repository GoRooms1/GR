<template>
  <AppHead
    :title="page_description.title"
    :meta_keywords="page_description?.meta_keywords"
    :meta_description="page_description?.meta_description"
  />
  <search-filter-modal />
  <div class="md:mt-[49px] mt-[40px] relative" style="min-height: 160px">
    <img
      class="md:block hidden absolute bottom-[-50px] left-0 -z-[1]"
      src="/img/lens.svg"
      alt="lens"
    />
    <img
      class="absolute md:bottom-[-150px] bottom-[-20px] md:right-0 right-[50px] -z-[1] md:w-initial sm:w-[30%] w-[50%]"
      src="/img/lens1.svg"
      alt="lens"
    />
    <search-panel />
  </div>
  <rooms-list :rooms="rooms"/>
  <info-block :description="page_description?.description ?? ''"/>
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue";
import RoomsList from "./partials/RoomsList.vue";
import InfoBlock from "./partials/InfoBlock.vue";
import {_getFiltersData, _getData} from "@/Services/filterUtils.js";
export default {
  layout: SearchLayout,
  components: {
    AppHead,
    Layout,
    SearchLayout,
    SearchPanel,
    RoomsList,
    InfoBlock,
    SearchFilterModal,
  },
  props: {
    page_description: Object,
    rooms: [Object],
  },
  mounted() {    
    this.$eventBus.on("filters-changed", (e) => this.getDataOnList("/search"));   
  },
  unmounted() {   
    this.$eventBus.off("filters-changed");
  },
  methods: {
    getDataOnList(url) {
      let data = _getFiltersData.call(this);
      _getData.call(this, url, data);      
    },
  },
};
</script>
