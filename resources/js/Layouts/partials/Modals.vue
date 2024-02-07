<template> 
 <!-- Modals -->
 <booking-form ref="booking" v-show="$page?.props?.modals?.booking === true" :room="bookingRoom" />
 <search-filter-modal ref="filters" v-if="$page.props?.has_filters && $page.props?.modals?.filters === true"/>
 <auth-modal ref="auth" v-show="$page.props?.modals?.auth === true"/>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import BookingForm from '@/components/widgets/BookingForm.vue'
import AuthModal from '@/components/widgets/AuthModal.vue'
export default {
  components: {    
    BookingForm,
    AuthModal,        
    SearchFilterModal: defineAsyncComponent(() =>
      import('@/components/widgets/SearchFilterModal.vue')
    ),
  },
  mounted() {
    this.$eventBus.on("booking-open", (e) => this.openBookingModal(e));
    this.$eventBus.on("booking-close", (e) => this.closeBookingModal());

    this.$eventBus.on("filters-open", (e) => this.openFilters());
    this.$eventBus.on("filters-close", (e) => this.closeFilters());

    this.$eventBus.on("auth-open", (e) => this.openAuth());
    this.$eventBus.on("auth-close", (e) => this.closeAuth());
  },
  unmounted() {
    this.$eventBus.off("booking-open");
    this.$eventBus.off("booking-close");

    this.$eventBus.off("filters-open");
    this.$eventBus.off("filters-close");

    this.$eventBus.off("auth-open");
    this.$eventBus.off("auth-close");
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

    openAuth() {
      this.$page.props.flash.message = null;

      if (this.$page.props.path === '/login') {
        this.setFixed();     
        this.$page.props.modals.auth = true;

        return;
      }
      
      this.$inertia.get(this.$page.props.path, {}, {
          preserveState: true,
          preserveScroll: true,
          only: ["auth"],          
          onFinish: () => {
            if (this.$page.props?.auth === false) {
              this.setFixed();     
              this.$page.props.modals.auth = true;
            }
            else {
              this.$inertia.get("/login");
            }
          },
        });             
    },
    closeAuth() {
      this.removeFixed(); 
      this.$page.props.modals.auth = false;
      this.$page.props.flash.message = null;
    },
  } 
};
</script>
