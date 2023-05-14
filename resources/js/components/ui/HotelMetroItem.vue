<template>
  <div v-if="metro" class="flex leading-tight text-sm mb-2">
    <div class="flex mr-2">      
      <MetroIcon :color="metro?.color"/>
    </div>
    <Link
      :href="getAddressHref(address?.city, metro?.name)"
      class="underline text-[#6170FF]"
      >{{ metro?.name }}</Link
    >
  </div>
  <div v-if="metro" class="flex leading-tight text-sm">
    <span class="px-2">
      <img src="/img/walk.svg" alt="walk"/>
    </span>
    {{ metro?.distance }} мин
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import MetroIcon from "@/components/ui/MetroIcon.vue";
export default {
  components: {
    Link,
    MetroIcon,
  },
  props: {
    metro: Object,
    address: Object,
  },
  methods: {
    getAddressHref(city, metro) {
      return (
        "/address" +
        "/" +
        this.getAddressSlug(city) +
        "/metro-" +
        this.metro.slug
      );
    },
    getAddressSlug(name) {
      let slugs = this.address?.slugs ?? [];
      return slugs.find(el => el.address == name)?.slug;
    },
  },
};
</script>
