<template>
  <list-header :h1="h1" />
  <div class="container mx-auto px-4 min-[1920px]:px-[10vw] relative z-10">
    <div v-if="globalLoading == false" class="flex flex-wrap -mx-4 mb-4">
      <hotel-card v-for="hotel in allHotels" :hotel="hotel" />
    </div>
  </div>
  <div
    v-if="allHotels.length > 0 && globalLoading == false"
    class="container mx-auto px-4 min-[1920px]:px-[10vw] mt-8 mb-12"
  >
    <div v-if="isLoading" class="text-center">
      <Loader />
    </div>
    <div v-if="!isLoading" class="text-center">
      <div class="text-xs xs:text-sm">
        Показано {{ allHotels.length }} из
        {{ hotels?.meta?.total ?? allHotels.length }}
      </div>
      <div v-if="hotels?.meta?.next_page_url">
        <Button @click="loadMore()" classes="mx-auto mt-3">
          Показать ещё отели
        </Button>
      </div>
    </div>
  </div>
  <div
    v-if="allHotels.length == 0 || globalLoading == true"
    class="w-full py-8"
  ></div>
  <div v-if="globalLoading == true" class="text-center py-8">
    <Loader />
  </div>
</template>

<script>
import HotelCard from "./HotelCard.vue";
import Loader from "@/components/ui/Loader.vue";
import Button from "@/components/ui/Button.vue";
import ListHeader from "@/components/ui/ListHeader.vue";
import {_getFiltersData, getFoundMessage} from "@/Services/filterUtils.js"

export default {
  components: {
    HotelCard,
    Loader,
    Button,
    ListHeader,
  },
  props: {
    hotels: {
      type: [Array, Object],
      required: false,
    },    
  },
  data() {
    return {      
      allHotels: this.hotels?.data ?? [],
      isLoading: false,
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
        return getFoundMessage(this.hotels?.meta?.total ?? 0, this.$page.props?.filters?.hotels?.type == 3 ? 'appartments' : 'hotels');
    },
  },
  methods: {
    loadMore() {
      let initialUrl =
        typeof window !== "undefined" ? window.location.href : "/";
      
      let currentPage = this.hotels?.meta?.current_page ?? 1;
      let nextPage = currentPage + 1;     

      if (this.hotels?.meta?.next_page_url) {
        this.$inertia.get(
          this.$page.url.split("?")[0] + "?page=" + nextPage,
          _getFiltersData.call(this),        
          {
            preserveState: true,
            preserveScroll: true,
            only: ["hotels"],
            onSuccess: () => {
              if (this.hotels.meta.current_page != 1)
                this.allHotels = [
                  ...this.allHotels,
                  ...this.hotels.data,
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
  },
  watch: {
    hotels: function (newVal, oldVal) {
      if (this.hotels?.meta?.current_page == 1) {
        this.allHotels = (this.hotels.data ?? []);
      }
    },
  },
};
</script>
