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
import Map from "./partials/Map.vue";
import BookingForm from "@/Pages/Room/partials/BookingForm.vue";
import { filterStore } from "@/Store/filterStore.js";
import { usePage } from "@inertiajs/vue3";

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
    page_description: Object,
    rooms: [Object],
    hotels: [Object],
  },
  mounted() {
    this.$eventBus.on("booking-open", (e) => this.openBookingModal(e));
    this.$eventBus.on("booking-close", (e) => this.closeBookingModal());
    this.$eventBus.on("filters-inited", (e) => this.getDataOnMap());
    this.$eventBus.on("filters-changed", (e) => this.getDataOnMap());    
  },
  unmounted() {
    this.$eventBus.off("filters-inited");
    this.$eventBus.off("filters-changed");
    this.$eventBus.off("booking-open");
    this.$eventBus.off("booking-close"); 
  },
  data() {
    return {
      filterStore,      
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
      this.$nextTick(() => {
        this.$inertia.get("/search_map", this.filterStore.getFiltersValues(), {
          replace: true,
          preserveState: true,
          preserveScroll: true,
          only: ["rooms", "hotels", "map_center"],
          onStart: () => {
            usePage().props.isLoadind = true;
          },
          onFinish: () => {
            usePage().props.isLoadind = false;
            this.$eventBus.emit("data-received");
          },
        });
      });
    },
  },
};
</script>
