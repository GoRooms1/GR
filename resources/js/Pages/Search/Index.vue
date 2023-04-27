<template>
  <AppHead 
    :title="page_description?.title"
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
  {{ page_description?.title }}
  <br>
  {{ page_description?.meta_description }}

  <rooms-list v-if="is_rooms_filter === true" :rooms="rooms" />
  <room-info-block v-if="is_rooms_filter === true" />

  <hotels-list v-if="is_rooms_filter === false" :hotels="hotels" />
  <hotel-info-block v-if="is_rooms_filter === false"/>
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue";
import RoomsList from "@/Pages/Room/partials/RoomsList.vue";
import RoomInfoBlock from "@/Pages/Room/partials/InfoBlock.vue";
import HotelsList from "@/Pages/Hotel/partials/HotelsList.vue";
import HotelInfoBlock from "@/Pages/Hotel/partials/InfoBlock.vue";
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
    RoomInfoBlock,
    HotelsList,
    HotelInfoBlock,
    SearchFilterModal,
  },
  props: {
    page_description: Object,
    hotels: [Object],
    rooms: [Object],
    is_rooms_filter: {
      type: Boolean,
      default: false,
    }
  },
  data() {
    return {
      filterStore,
    }
  },
  mounted() {
    eventBus.on('filters-inited', e => this.getDataOnList());
    eventBus.on('filters-changed', e => this.getDataOnList());
  },
  methods: {
    getDataOnList() {     
      this.$nextTick(() => {        
        this.$inertia.get(route("search.list"), this.filterStore.getFiltersValues(), {
          replace: true,
          preserveState: true,
          preserveScroll: true,
          only: ['hotels', 'rooms', 'is_rooms_filter', 'page_description'],
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
