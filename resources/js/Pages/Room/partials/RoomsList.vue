<template>
  <list-header
    :h1="hotelId  > 0 ? null : h1"
    :title="hotelId > 0 ? 'Все номера в отеле' : null"
  />
  <div
    v-if="globalLoading == false"
    class="container mx-auto px-4 relative min-[1920px]:px-[10vw]"
    :class="bookingRoom != null ? 'z-20' : 'z-10'"
  >
    <room-card v-for="room in allRooms" :room="room" classes="my-4"/>
  </div>
  <div
    v-if="allRooms.length > 0 && globalLoading == false"
    class="container mx-auto px-4 min-[1920px]:px-[10vw] mt-8 mb-12"
  >
    <div v-if="isLoading" class="text-center">
      <Loader />
    </div>
    <div v-if="!isLoading" class="text-center">
      <div class="text-xs xs:text-sm">
        Показано {{ allRooms.length }} из
        {{ rooms?.meta?.total ?? allRooms.length }}
      </div>
      <div v-if="rooms?.meta?.next_page_url">
        <Button @click="loadMore()" classes="mx-auto mt-3">
          Показать ещё номера
        </Button>
      </div>
    </div>
  </div>
  <div
    v-if="allRooms.length == 0 || globalLoading == true"
    class="w-full py-8"
  ></div>
  <div v-if="globalLoading == true" class="text-center py-8">
    <Loader />
  </div>
  <booking-form :room="bookingRoom" />
</template>

<script>
import RoomCard from "./RoomCard.vue";
import Loader from "@/components/ui/Loader.vue";
import Button from "@/components/ui/Button.vue";
import BookingForm from "./BookingForm.vue";
import ListHeader from "@/components/ui/ListHeader.vue";
import {_getFiltersData, getFoundMessage} from "@/Services/filterUtils.js"

export default {
  components: {
    BookingForm,
    ListHeader,
    RoomCard,
    Loader,
    Button,    
  },
  props: {
    rooms: {
      type: [Array, Object],
      required: false,
    },
    hotelId: {
      type: Number,
      default: 0,
    },
  },
  mounted() {
    this.$eventBus.on("booking-open", (e) => this.openBookingModal(e));
    this.$eventBus.on("booking-close", (e) => this.closeBookingModal());
  },
  unmounted() {
    this.$eventBus.off("booking-open");
    this.$eventBus.off("booking-close");
  },
  data() {
    return {      
      allRooms: this.rooms?.data ?? [],
      isLoading: false,    
      bookingRoom: null,
    };
  },
  computed: {
    globalLoading() {
      return this.$page.props.isLoadind ?? false;
    },
    h1() {
      if (this.$page.props?.page_description?.id > 0) 
        return this.$page.props.page_description.h1;
      else 
        return getFoundMessage(this.rooms?.meta?.total ?? 0, 'rooms');
    },
  },
  methods: {   
    loadMore() {
      let initialUrl =
        typeof window !== "undefined" ? window.location.href : "";

      let currentPage = this.rooms?.meta?.current_page ?? 1;
      let nextPage = currentPage + 1;      

      if (this.rooms?.meta?.next_page_url) {
        this.$inertia.get(
          this.$page.url.split("?")[0] + "?page=" + nextPage,
          _getFiltersData.call(this),
          {
            preserveState: true,
            preserveScroll: true,
            only: ["rooms"],
            onSuccess: () => {
              if (this.rooms.meta.current_page != 1)
                this.allRooms = [
                  ...this.allRooms,
                  ...this.rooms.data,
                ];

              if (typeof window !== "undefined")
                window.history.pushState({}, this.$page.title, initialUrl);
            },
            onStart: () => {
              this.isLoading = true;
            },
            onFinish: () => {
              this.isLoading = false;
            },
          }
        );
      }
    },
    openBookingModal(e) {
      this.bookingRoom = e;
      this.$page.props.modals.booking = true;    
    },
    closeBookingModal() {      
      this.bookingRoom = null;
      this.$page.props.modals.booking = false;
    },
  },
  watch: {
    rooms: function (newVal, oldVal) {
      if (this.rooms?.meta?.current_page == 1) {
        this.allRooms = (this.rooms.data ?? []);
      }
    },
  },
};
</script>
