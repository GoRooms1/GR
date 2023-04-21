<template>
  <AppHead :title="model.page.title" />
  <search-filter-modal />
  <div class="relative z-20 w-full">    
    <search-panel />    
  </div>
  <Map :rooms="rooms" :hotels="hotels"/>
  <booking-form v-if="isBookingOpen === true" :room="bookingRoom"/> 
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import type { PropType } from "vue";
import { PageInterface } from "../../models/pages/page.interface";
import Layout from "@/Layouts/Layout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue";
import Map from './partials/Map.vue';
import BookingForm from "@/Pages/Room/partials/BookingForm.vue";
import { filterStore } from "@/Store/filterStore.js";
import { usePage } from "@inertiajs/inertia-vue3";

export default {
  layout: SearchLayout,
  components: {
    AppHead,
    Layout,
    SearchLayout,
    SearchPanel,
    SearchFilterModal,
    Map,
    BookingForm,
  },
  props: {
    model: {
      type: Object as PropType<PageInterface>,
      required: true,
    },
    rooms: [Object],
    hotels: [Object],   
  },
  mounted() {
    eventBus.on('booking-open', e => this.openBookingModal(e));
    eventBus.on('booking-close', e => this.closeBookingModal());
    eventBus.on('filters-inited', e => this.getDataOnMap());
    eventBus.on('filters-changed', e => this.getDataOnMap());
  },
  data() {
    return {
      filterStore,     
      isBookingOpen: false,
      bookingRoom: null,
    };
  },
  methods: {
    openBookingModal(e) {
      this.bookingRoom = e;
      this.isBookingOpen = true;
    },
    closeBookingModal() {      
      this.isBookingOpen = false;
      this.bookingRoom = null;
    },
    getDataOnMap() {      
      this.$nextTick(() => {        
        this.$inertia.get(route("search.map"), this.filterStore.getFiltersValues(), {
          replace: true,
          preserveState: true,
          preserveScroll: true,
          only: ['rooms', 'hotels'],
          onStart: () => {
            usePage().props.value.isLoadind = true;            
          },
          onFinish: () => {
            usePage().props.value.isLoadind = false;            
            eventBus.emit('data-received');      
          },
        });        
      });     
    },
  },  
};
</script>
