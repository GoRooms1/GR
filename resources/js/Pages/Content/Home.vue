<template>
  <AppHead :title="model.page.title" />
  <Layout>
    <div class="container mx-auto">
      <div class="py-4 lg:my-16 px-2 lg:px-6">
        Home!
      </div>
    </div>     
  </Layout>
</template>

<script lang="ts">
import AppHead from "../../components/AppHead.vue";
import type { PropType } from "vue";
import { PageInterface } from "../../models/pages/page.interface";
import Layout from '../../Layouts/Layout.vue';

export default {
  components: {
    AppHead,
    Layout
  },
  props: {
    model: {
      type: Object as PropType<PageInterface>,
      required: true,
    },
  },
};
</script>

