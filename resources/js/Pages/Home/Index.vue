<template>
  <AppHead :title="model.page.title" />
  <div class="md:mt-[49px] mt-[40px] relative">
    <div
      class="overflow-hidden fixed top-0 left-0 right-0 bottom-0 -z-[1] block md:hidden"
    >
      <img
        class="absolute top-[21px] right-[-10px] -z-[1] md:w-initial w-[220px]"
        src="img/lens1.svg"
        alt="lens"
      />
      <div
        class="absolute top-0 left-0 h-full w-full -z-[1] bg-[#0018ff] opacity-60"
      ></div>
    </div>
    
    <div class="relative block md:hidden"> 
      <search-panel />
    </div>
    
  </div>
  <div v-if="isMobile == true" class="container mx-auto">
    <div class="py-4 lg:my-16 px-2 lg:px-6">
      <div class="block md:hidden">
        <intro-filters />
      </div>
    </div>
  </div>  
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import { usePage } from "@inertiajs/vue3";
import type { PropType } from "vue";
import { PageInterface } from "../../models/pages/page.interface";
import Layout from "@/Layouts/Layout.vue";
import IntroLayout from "@/Layouts/IntroLayout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import IntroFilters from "./partials/IntroFilters.vue";
import Loader from "@/components/ui/Loader.vue";

export default {
  layout: IntroLayout,
  components: {
    AppHead,
    Layout,
    IntroLayout,
    SearchPanel,
    IntroFilters,   
  },
  props: {
    model: {
      type: Object as PropType<PageInterface>,
      required: true,
    },
  },
  created() {
    window.addEventListener("resize", this.handleDesktop);
    this.handleDesktop();
  },
  destroyed() {
    window.removeEventListener("resize", this.handleDesktop);
  },
  data() {
    return {
      isMobile: false,
    }
  },  
  methods: {
    handleDesktop() {      
      if (window.innerWidth > 767 && route().current() == 'home') {        
        this.isMobile = false;
        this.$inertia.get(route("search.map"), {
          replace: true,
          preserveState: true,
          preserveScroll: true,              
        });
      } else {        
        this.isMobile = true;
      }      
    },
  }
};
</script>
