<template> 
 <!-- Modals -->
 <booking-form ref="booking" v-show="$page?.props?.modals?.booking === true" :room="bookingRoom" />
 <search-filter-modal ref="filters" v-if="$page.props?.has_filters && $page.props?.modals?.filters === true"/>
 <auth-modal ref="auth" v-show="$page.props?.modals?.auth === true"/>
 <favorites ref="favorites" v-if="$page.props?.modals?.favorites === true"/>
 <reviews-modal ref="reviews" v-if="$page.props?.modals?.reviews === true" :reviews="reviews" :loading="reviewsLoading"/>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import BookingForm from '@/components/widgets/BookingForm.vue'
import AuthModal from '@/components/widgets/AuthModal.vue'
import Favorites from '@/components/widgets/Favorites.vue'
import ReviewsModal from '@/components/widgets/ReviewsModal.vue'
import axios from 'axios';
export default {
  components: {
    axios,    
    BookingForm,
    AuthModal,
    Favorites,
    ReviewsModal,       
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

    this.$eventBus.on("favorites-open", (e) => this.openFavorites());
    this.$eventBus.on("favorites-close", (e) => this.closeFavorites());

    this.$eventBus.on("reviews-open", (e) => this.openReviews(e));
    this.$eventBus.on("reviews-close", (e) => this.closeReviews());
  },
  unmounted() {
    this.$eventBus.off("booking-open");
    this.$eventBus.off("booking-close");

    this.$eventBus.off("filters-open");
    this.$eventBus.off("filters-close");

    this.$eventBus.off("auth-open");
    this.$eventBus.off("auth-close");

    this.$eventBus.off("favorites-open");
    this.$eventBus.off("favorites-close");

    this.$eventBus.off("reviews-open");
    this.$eventBus.off("reviews-close");
  },
  data() {
    return {
      bookingRoom: null,
      reviews: [],
      reviewsLoading: false,      
    }
  },
  methods: {
    removeBodyScroll() {
      document.body.classList.add("overflow-hidden");
    },
    returnBodyScroll() {
      document.body.classList.remove("overflow-hidden");
    },
    openBookingModal(e) {
      this.removeBodyScroll();
      this.bookingRoom = e;      
      this.$page.props.modals.booking = true;      
    },
    closeBookingModal() {
      this.returnBodyScroll();    
      this.bookingRoom = null;
      setTimeout(() => {
        this.$page.props.modals.booking = false;
      }, 50);      
    },

    openFilters() {
      this.removeBodyScroll();     
      this.$page.props.modals.filters = true;
    },
    closeFilters() {
      this.returnBodyScroll(); 
      if (this.$refs?.filters?.close)
        this.$refs.filters.close();
      else
        this.$page.props.modals.filters = false;    
    },

    openAuth() {
      this.$page.props.flash.message = null;      
      
      this.$inertia.get(this.$page.props.path, {}, {
          preserveState: true,
          preserveScroll: true,
          only: ["auth"],          
          onFinish: () => {
            if (this.$page.props?.auth === false) {
              this.removeBodyScroll();     
              this.$page.props.modals.auth = true;
            }
            else {
              this.$inertia.get("/login");
            }
          },
        });             
    },
    closeAuth() {
      this.returnBodyScroll(); 
      this.$page.props.modals.auth = false;
      this.$page.props.flash.message = null;

      if (this.$refs?.auth?.resetForms)
        this.$refs.auth.resetForms();

      if (this.$page.component.startsWith('Auth'))
        this.$inertia.get("/");
    },

    openFavorites() {
      this.removeBodyScroll();
      this.$page.props.modals.favorites = true;                 
    },
    closeFavorites() {
      this.returnBodyScroll(); 
      this.$page.props.modals.favorites = false;
    },

    openReviews(e) {
      this.$page.props.modals.reviews = true;
      this.removeBodyScroll();
      this.reviewsLoading = true;

      axios
        .get('/api/reviews', {
          params: e,
          headers: {
            'Content-Type': 'application/json'
          }
        })        
        .then(response => {        
          let data = response?.data?.payload?.reviews;
          if (data) this.reviews = data;
          this.reviewsLoading = false;         
        });
    },
    closeReviews() {
      this.returnBodyScroll(); 
      this.$page.props.modals.reviews = false;
      this.reviews = [];
    },
  } 
};
</script>
