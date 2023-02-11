<template>
  <AppHead  ref="test1" :title="model.page.title" />  
  <div class="container mx-auto">
    <div class="py-4 lg:my-16 px-2 lg:px-6">
      Home!
    </div>
  </div> 
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import type { PropType } from "vue";
import { PageInterface } from "../../models/pages/page.interface";
import Layout from '@/Layouts/Layout.vue';
import SearchLayout from '@/Layouts/SearchLayout.vue';

export default {
  layout: SearchLayout,
  components: {
    AppHead,
    Layout,
    SearchLayout,
  },
  props: {
    model: {
      type: Object as PropType<PageInterface>,
      required: true,
    },
  },
};
</script>

