<template>  
  <div v-if="$page.props?.is_loading !== true" class="container mx-auto px-4 relative min-[1920px]:px-[10vw] z-10" >
    <div :class="type == 'hotels' ? 'flex flex-wrap -mx-4 mb-4' : ''">
      <template v-for="(object, index) in objectList">
        <room-card v-if="type == 'rooms'" :room="object" :key="object.id" classes="my-4" />
        <hotel-card v-if="type == 'hotels'" :hotel="object" :key="object.id" classes="my-4" />
        <div class="w-full justify-between flex" :class="type == 'hotels' ? 'mx-4' : ''" v-if="isBannerPosition(index) && ad_banners.length > 0">
          <AdBanner v-for="banner in ad_banners" :banner="banner" :key="banner.id" :classes="ad_banners.length > 1 ? 'w-full w-[49%]' : 'w-full'"/>
        </div>
      </template>
    </div>           
  </div>
  <div v-if="objectList.length > 0 && $page.props?.is_loading !== true"
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
  <div v-if="objectList.length == 0 || $page.props?.is_loading === true" class="w-full py-8"></div>
  <div v-if="$page.props?.is_loading === true" class="text-center py-8">
    <Loader />
  </div>  
</template>

<script>
import Loader from "@/components/ui/Loader.vue";
import Button from "@/components/ui/Button.vue";
import { _getFiltersData } from "@/Services/filterUtils.js"
import { defineAsyncComponent } from 'vue'
import AdBanner from "@/components/ui/AdBanner.vue";
import axios from 'axios';

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
    AdBanner,
    axios,      
  },
  props: {
    objects: {
      type: [Array, Object],
      default: [],
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
      isMobile: false,
      ad_banners: [],
    };
  },
  mounted() {
    if (typeof window !== "undefined") {
      window.addEventListener("resize", this.handleResize);      
    }
    this.handleResize();
    this.loadBanners();   
  },
  unmounted() {
    window.removeEventListener("resize", this.handleResize);
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
    handleResize() {
      if (typeof window !== "undefined") {
        let windowHeight = window.innerHeight;
        let windowWidth = window.innerWidth;

        if (windowWidth >= 1280)
          this.isMobile = false;
        else
          this.isMobile = true;
      }
    },
    isBannerPosition(index) {
      let length = (this.objectList ?? []).length;      
      let rows = this.type == 'rooms' ? 3 : (this.isMobile ? 3 : 6);     
      let position = (index + 1) % rows;

      if ( position === 0 || (length < rows && index === length - 1) )
        return true;

      return false;
    },
    loadBanners() {
      let data = { 
        num: this.isMobile ? 1 : 2,
        city: this.$page.props?.ad_params?.city,
        page_type: this.$page.props?.ad_params?.page_type,        
      };

      axios
        .get('/api/ad_banners', {
          params: data,
          headers: {
            'Content-Type': 'application/json'
          }
        })        
        .then(response => {        
          let data = response?.data?.payload?.ad_banners;
          if (data) this.ad_banners = data;
        });
    }    
  },
  watch: {
    objects: function (newVal, oldVal) {
      if (this.objects?.meta?.current_page == 1) {
        this.objectList = this.objects?.data ?? [];
        this.loadBanners();
      }
    },
  },  
};
</script>