<template>
  <div v-if="$page.props.isLoading !== true" class="container mx-auto px-4 relative min-[1920px]:px-[10vw] z-10">
    <room-card v-if="type == 'rooms'" v-for="room in objectList" :room="room" classes="my-4" />    
    <div v-if="type == 'hotels'" class="flex flex-wrap -mx-4 mb-4">
      <hotel-card v-for="hotel in objectList" :hotel="hotel" classes="my-4" />
    </div>   
  </div>
  <div v-if="objectList.length > 0 && $page.props.isLoading !== true"
    class="container mx-auto px-4 min-[1920px]:px-[10vw] mt-8 mb-12">
    <div v-if="isLoading" class="text-center">
      <Loader />
    </div>
    <div v-if="!isLoading" class="text-center">
      <div class="text-xs xs:text-sm">
        Показано {{ objectList.length }} из
        {{ objects?.meta?.total ?? objectList.length }}
      </div>
      <div v-if="objects?.meta?.next_page_url">
        <Button @click="loadMore()" classes="mx-auto mt-3">
          Показать ещё {{ type == 'rooms' ? 'номера' : 'отели' }}
        </Button>
      </div>
    </div>
  </div>
  <div v-if="objectList.length == 0 || $page.props.isLoading === true" class="w-full py-8"></div>
  <div v-if="$page.props.isLoading === true" class="text-center py-8">
    <Loader />
  </div>
</template>

<script>
import Loader from "@/components/ui/Loader.vue";
import Button from "@/components/ui/Button.vue";
import { _getFiltersData } from "@/Services/filterUtils.js"
import { defineAsyncComponent } from 'vue'

export default {
  components: {
    RoomCard: defineAsyncComponent(() =>
      import('@/components/ui/RoomCard.vue')
    ),
    HotelCard: defineAsyncComponent(() =>
      import('@/components/ui/HotelCard.vue')
    ),
    Loader,
    Button,       
  },
  props: {
    objects: {
      type: [Array, Object],
      required: false,
    },    
    type: {
      type: String,
      default: 'hotels',
    }  
  },  
  data() {
    return {      
      objectList: this.objects?.data ?? [],
      isLoading: false,
    };
  }, 
  methods: {   
    loadMore() {
      let initialUrl =
        typeof window !== "undefined" ? window.location.href : "";

      let currentPage = this.objects?.meta?.current_page ?? 1;
      let nextPage = currentPage + 1;      

      if (this.objects?.meta?.next_page_url) {
        this.$inertia.get(
          this.$page.props.path + "?page=" + nextPage,
          _getFiltersData.call(this),
          {
            preserveState: true,
            preserveScroll: true,
            only: [this.type],
            onSuccess: () => {
              if (this.objects.meta.current_page != 1)
                this.objectList = [
                  ...this.objectList,
                  ...this.objects.data,
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
    objects: function (newVal, oldVal) {
      if (this.objects?.meta?.current_page == 1) {
        this.objectList = this.objects?.data ?? [];
      }
    },
  },  
};
</script>
