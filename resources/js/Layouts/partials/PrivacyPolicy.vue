<template>
  <div v-bind="$attrs">
    <Link href="/privacy-policy" class="underline"> Хранение и обработка персональных данных </Link>
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
