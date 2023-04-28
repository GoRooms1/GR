<template>
   <AppHead 
    :title="page_description.title"
    :meta_keywords="page_description?.meta_keywords"
    :meta_description="page_description?.meta_description"
  />
  <search-filter-modal />
  <div class="md:mt-[49px] mt-[40px] relative" style="min-height: 160px;">
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
  <rooms-list :rooms="rooms" />
  <info-block />
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue";
import RoomsList from "./partials/RoomsList.vue";
import InfoBlock from "./partials/InfoBlock.vue";
import { filterStore } from "@/Store/filterStore.js";
import { usePage } from "@inertiajs/inertia-vue3";
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
  data() {
    return {
      filterStore,
    }
  },  
  mounted() {
    eventBus.on('filters-inited', e => this.getDataOnList(this.$page.url ?? route("rooms.index")));
    eventBus.on('filters-changed', e => this.getDataOnList(route("search.list")));
  },
  methods: {    
    getDataOnList(url) {     
      this.$nextTick(() => {        
        this.$inertia.get(url, this.filterStore.getFiltersValues(), {
          replace: true,
          preserveState: true,
          preserveScroll: true,
          only: ['hotels', 'rooms', 'is_rooms_filter'],
          onSuccess: () => {
            window.history.pushState({}, this.$page.title, window.location.pathname);              
          },
          onStart: () => {
            usePage().props.value.isLoadind = true;            
          },
          onFinish: () => {
            usePage().props.value.isLoadind = false;
          },
        });
      });      
    },
  }
};
</script>
