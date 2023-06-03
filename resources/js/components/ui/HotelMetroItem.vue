<template>
  <div v-if="metro" class="flex leading-tight text-sm mb-2">
    <div class="flex mr-2">      
      <MetroIcon :color="metro?.color"/>
    </div>
    <Link
      :href="metro?.slug"
      class="underline text-[#6170FF]"
    >{{ metro?.name }}
    </Link>
  </div>
  <div v-if="metro" class="flex leading-tight text-sm">
    <span class="px-2">
      <img src="/img/walk.svg" alt="walk" width="20" height="16"/>
    </span>
    {{ metro?.distance }} мин
  </div>
</template>

<script lang="ts">
import { Link } from "@inertiajs/vue3";
import MetroIcon from "@/components/ui/MetroIcon.vue";
export default {
  components: {
    Link,
    MetroIcon,
  },
  props: {
    metro: Object,    
  },  
};
</script>
