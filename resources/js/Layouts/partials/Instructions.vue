<template>
  <div v-bind="$attrs">
    <Link href="/instructions" class="underline"> Инструкции </Link>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    Link
  }
};
</script>
