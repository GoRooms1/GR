<template> 
 <!-- Modals -->
 <booking-form ref="booking" v-show="$page?.props?.modals?.booking === true" :room="bookingRoom" />
 <search-filter-modal ref="filters" v-if="$page.props?.has_filters && $page.props?.modals?.filters === true"/>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import BookingForm from '@/components/widgets/BookingForm.vue'
export default {
  components: {    
    BookingForm,    
    SearchFilterModal: defineAsyncComponent(() =>
      import('@/components/widgets/SearchFilterModal.vue')
    ),
  },
  mounted() {
    this.$eventBus.on("booking-open", (e) => this.openBookingModal(e));
    this.$eventBus.on("booking-close", (e) => this.closeBookingModal());

    this.$eventBus.on("filters-open", (e) => this.openFilters());
    this.$eventBus.on("filters-close", (e) => this.closeFilters());
  },
  unmounted() {
    this.$eventBus.off("booking-open");
    this.$eventBus.off("booking-close");  

    this.$eventBus.off("filters-open");
    this.$eventBus.off("filters-close");
  },
  data() {
    return {
      bookingRoom: null,      
    }
  },
  methods: {
    setFixed() {
      document.body.classList.add("fixed");
    },
    removeFixed() {
      if (this.$page.props?.filters?.as != 'map')
        document.body.classList.remove("fixed");   
    },
    openBookingModal(e) {
      this.setFixed();
      this.bookingRoom = e;      
      this.$page.props.modals.booking = true;      
    },
    closeBookingModal() {
      this.removeFixed();    
      this.bookingRoom = null;
      setTimeout(() => {
        this.$page.props.modals.booking = false;
      }, 50);      
    },

    openFilters() {
      this.setFixed();     
      this.$page.props.modals.filters = true;        
    },
    closeFilters() {
      this.removeFixed(); 
      if (this.$refs?.filters?.close)              
        this.$refs.filters.close();
      else
        this.$page.props.modals.filters = false;    
    },
  } 
};
</script>
