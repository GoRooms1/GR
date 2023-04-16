<template>
  <AppHead :title="model.page.title" />
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
import type { PropType } from "vue";
import { PageInterface } from "../../models/pages/page.interface";
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
    model: {
      type: Object as PropType<PageInterface>,
      required: true,
    },
    rooms: [Object],
  },
  data() {
    return {
      filterStore,
    }
  },  
  mounted() {
    eventBus.on('filters-inited', e => this.getDataOnList(route("rooms.index")));
    eventBus.on('filters-changed', e => this.getDataOnList(route("search.list")));
  },
  methods: {    
    getDataOnList(route) {     
      this.$nextTick(() => {        
        this.$inertia.get(route, this.filterStore.getFiltersValues(), {
          replace: true,
          preserveState: true,
          preserveScroll: true,
          only: ['hotels', 'rooms', 'is_rooms_filter'],
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
