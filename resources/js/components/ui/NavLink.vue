<template>
  <Link   
    :href="href"
    class="nav-link flex items-center mr-4 pl-[24px] h-[24px] bg-left bg-no-repeat bg-contain"
    :class="classes + (disabled ? ' btn-disabled pointer-events-none' : '')"
  >
    <span v-if="title" class="pl-2">
      {{ title }}
    </span>
    <slot />
  </Link>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: {
    Link,
  },
  props: {
    href: {
      type: String,
      default: "#",
    },
    title: String,
    classes: String,
    disabled: Boolean,
  },
};
</script>
