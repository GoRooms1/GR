<template>
  <Link
    as="button"
    :href="href"
    class="flex items-center mr-4 pl-[24px] h-[24px] bg-left bg-no-repeat bg-contain"
    :class="classes + (disabled ? ' btn-disabled pointer-events-none' : '')"
  >
    <span v-if="title" class="pl-2">
      {{ title }}
    </span>
    <slot />
  </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    Link,
  },
  props: {
    href: String,
    title: String,
    classes: String,
    disabled: Boolean,
  },
};
</script>
