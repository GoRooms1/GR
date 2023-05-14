<template>
  <AppHead
    :title="page_description?.title"
    :meta_keywords="page_description?.meta_keywords"
    :meta_description="page_description?.meta_description"
  />
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
  <h1 class="hidden">{{ page_description?.h1 }}</h1>
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
import Layout from "@/Layouts/Layout.vue";
import IntroLayout from "@/Layouts/IntroLayout.vue";
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import IntroFilters from "./partials/IntroFilters.vue";

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
    page_description: Object,
  },
  mounted() {
    if (typeof window !== "undefined")
      window.addEventListener("resize", this.handleDesktop);
    this.handleDesktop();    
  },
  unmounted() {
    if (typeof window !== "undefined")
      window.removeEventListener("resize", this.handleDesktop);
  },
  data() {
    return {
      isMobile: false,
    };
  },
  methods: {
    handleDesktop() {
      if (typeof window !== "undefined") {
        if (
          window.innerWidth > 767 &&
          (this.$page.url.split("?")[0] == "/" ||
            this.$page.url.split("?")[0] == "")
        ) {
          this.isMobile = false;
          this.$inertia.get("/search_map", {
            replace: true,
            preserveState: true,
            preserveScroll: true,
          });
        } else {
          this.isMobile = true;
        }
      }
    },
  },
};
</script>
