<template>
  <Head :title="title ? `${title}` : 'Gorooms'">
    <slot />
  </Head>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";

export default {
  name: "AppHead",
  components: {
    Head,
  },
  props: {
    title: String,
  },
};
</script>

<style scoped></style>
