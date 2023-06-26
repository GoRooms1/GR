<template>
  <Link    
    :href="href"
    class="nav-link hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[left_10px_center] text-left mb-2"
    :class="classes + (disabled ? ' btn-disabled pointer-events-none' : '')"
  >
    {{ title }}
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
