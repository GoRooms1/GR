<template>
  <AppHead :title="model.page.title" />
  <search-filter-modal />
  <div class="relative z-20 w-full">    
    <search-panel />    
  </div>
  <Map :rooms="rooms" :hotels="hotels" :is-rooms-filter="is_rooms_filter"/>
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
    is_rooms_filter: Boolean,
  },
  created() {
    eventBus.on('booking-open', e => this.openBookingModal(e));
    eventBus.on('booking-close', e => this.closeBookingModal());
  },
  data() {
    return {      
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
  },  
};
</script>
