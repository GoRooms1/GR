<template>
  <AppHead :title="model.page.title" />  
  <div class="container mx-auto">
    <div class="py-4 lg:my-16 px-2 lg:px-6">
      <search-panel/>
      <div class="block md:hidden">
        <intro-filters/>
      </div>      
    </div>
  </div>
  
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue"
import type { PropType } from "vue"
import { PageInterface } from "../../models/pages/page.interface"
import Layout from '@/Layouts/Layout.vue'
import IntroLayout from '@/Layouts/IntroLayout.vue'
import SearchPanel from "@/components/widgets/SearchPanel.vue"
import IntroFilters from "./partials/IntroFilters.vue"

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
    cities: Array,
  },
};
</script>

