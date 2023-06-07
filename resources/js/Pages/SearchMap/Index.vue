<template>
  <AppHead
    :title="page_description?.title"
    :meta_keywords="page_description?.meta_keywords"
    :meta_description="page_description?.meta_description"
  />
  <h1 class="hidden">{{ page_description?.h1}}</h1>
  <search-filter-modal />
  <div class="relative z-20 w-full">
    <search-panel />
  </div>
  <Map :rooms="rooms" :hotels="hotels" />
  <booking-form :room="bookingRoom" />
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue";
import BookingForm from "@/Pages/Room/partials/BookingForm.vue";
import {_getFiltersData, _getData} from "@/Services/filterUtils.js";
import Map from "./partials/Map.vue";

export default {
  layout: SearchLayout,
  components: {
    AppHead,
    Layout,
    SearchLayout,
    SearchPanel,
    SearchFilterModal,
    BookingForm,
    Map,    
  },
  props: {
    page_description: Object,
    rooms: [Object],
    hotels: [Object],
  },
  mounted() {
    this.getDataOnMap();
    this.$eventBus.on("booking-open", (e) => this.openBookingModal(e));
    this.$eventBus.on("booking-close", (e) => this.closeBookingModal());   
    this.$eventBus.on("filters-changed", (e) => this.getDataOnMap());    
  },
  unmounted() {    
    this.$eventBus.off("filters-changed");
    this.$eventBus.off("booking-open");
    this.$eventBus.off("booking-close"); 
  },
  data() {
    return {       
      bookingRoom: null,
    };
  },
  methods: {
    openBookingModal(e) {
      this.bookingRoom = e;      
      this.$page.props.modals.booking = true;
    },
    closeBookingModal() {     
      this.bookingRoom = null;
      setTimeout(() => {
        this.$page.props.modals.booking = false;
      }, 50);      
    },
    getDataOnMap() { 
      let data = _getFiltersData.call(this);
      _getData.call(this, '/search_map', data, () => {this.$eventBus.emit("data-received")});      
    },
  },
};
</script>
