<template>
  <AppHead :title="page_description?.title" :url="$page.props.app_url + page_description?.url"
    :meta_keywords="page_description?.meta_keywords" :meta_description="page_description?.meta_description" 
    :canonical="$page.props?.app_url + $page.props?.path"
  />
  
  <div :class="is_map ? 'relative z-20 w-full' : 'md:mt-[49px] mt-[40px] relative'"
    :style="is_map ? '' : 'min-height: 160px'">
    <img v-if="!is_map" class="md:block hidden absolute bottom-[-50px] left-0 -z-[1]" src="/img/lens.svg" alt="lens" />
    <img v-if="!is_map"
      class="absolute md:bottom-[-150px] bottom-[-20px] md:right-0 right-[50px] -z-[1] md:w-initial sm:w-[30%] w-[50%]"
      src="/img/lens1.svg" alt="lens" />
    <search-panel />
  </div>

  <list-header v-if="!is_map" :h1="h1" />
  <object-list v-if="!is_map" :type="list_type" :objects="list_type == 'rooms' ? rooms : hotels" />
  <article v-if="!is_map" class="container mx-auto px-4 min-[1920px]:px-[10vw] min-[1920px]:px-[10vw]"
    v-html="page_description?.description ?? default_description"></article>

  <Map v-if="is_map" :rooms="rooms" :hotels="hotels" />  
</template>

<script lang="ts">
import { defineAsyncComponent } from 'vue'
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import {_getFiltersData, _getData, getFoundMessage} from "@/Services/filterUtils.js";

export default {  
  components: {
    AppHead,
    Layout,    
    SearchPanel,    
    ObjectList: defineAsyncComponent(() =>
      import('./partials/ObjectList.vue')
    ),
    ListHeader: defineAsyncComponent(() =>
      import('@/components/ui/ListHeader.vue')
    ),
    Map: defineAsyncComponent(() =>
      import('./partials/Map.vue')
    ),    
  },
  props: {
    page_description: Object,
    hotels: [Object],
    rooms: [Object],
    filters: Object,
    list_type: String,
    is_map: Boolean,
    default_description: String,
  },  
  mounted() {    
    this.$eventBus.on("filters-changed", (e) => this.getData());    
  },
  unmounted() {    
    this.$eventBus.off("filters-changed");    
  },  
  computed: {   
    h1() {      
      if (this.$page.props?.page_description?.h1)
        return this.$page.props.page_description.h1;
      
      if (this.list_type == 'hotels')
        return getFoundMessage(this.hotels?.meta?.total ?? 0, this.$page.props?.filters?.hotels?.type == 3 ? 'appartments' : 'hotels');

      if (this.list_type == 'rooms')
        return getFoundMessage(this.rooms?.meta?.total ?? 0, 'rooms');

      return "";
    },
  },
  methods: {
    getData() {      
      let data = _getFiltersData.call(this);
      data.as = this.is_map === true ? 'map' : null;       
      _getData.call(this, '/search', data, () => {this.$eventBus.emit("data-received")});
    },    
  },
};
</script>
