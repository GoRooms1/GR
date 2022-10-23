<template>
  <AppHead :title="model.page.title" />
  <main class="fixed inset-0 grid place-items-center">
    <h2>test contact page</h2>
    <div v-html="model.page.content"></div>
  </main>
</template>

<script lang="ts">
import AppHead from '../../components/AppHead.vue';
import type { PropType } from "vue";
import {PageInterface} from "../../models/pages/page.interface";

export default {
  components: {
    AppHead
  },
  props: {
    model: {
      type: Object as PropType<PageInterface>,
      required: true
    }
  }
}
</script>

