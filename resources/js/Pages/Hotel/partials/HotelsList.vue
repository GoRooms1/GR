<template>
  <list-header :found="hotels?.meta?.total ?? 0" />
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
import { filterStore } from "@/Store/filterStore.js";
import { tempFilterStore } from "@/Store/tempFilterStore.js";
import { usePage } from "@inertiajs/vue3";
import _ from "lodash";
import HotelCard from "./HotelCard.vue";
import Loader from "@/components/ui/Loader.vue";
import Button from "@/components/ui/Button.vue";
import ListHeader from "./ListHeader.vue";

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
      filterStore,
      tempFilterStore,
      allHotels: this.hotels?.data ?? [],
      isLoading: false,
    };
  },
  computed: {
    globalLoading() {
      return usePage().props.isLoadind ?? false;
    },
  },
  methods: {
    loadMore() {
      let initialUrl =
        typeof window !== "undefined" ? window.location.href : "/";
      if (this?.hotels?.meta?.next_page_url) {
        this.$inertia.get(
          this.hotels.meta.next_page_url,
          this.filterStore.getFiltersValues(),
          {
            preserveState: true,
            preserveScroll: true,
            only: ["hotels"],
            onSuccess: () => {
              if (this.hotels.meta.current_page != 1)
                this.allHotels = [
                  ...this.allHotels,
                  ..._.shuffle(this.hotels.data),
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
        this.allHotels = _.shuffle(this.hotels.data ?? []);
      }
    },
  },
};
</script>
