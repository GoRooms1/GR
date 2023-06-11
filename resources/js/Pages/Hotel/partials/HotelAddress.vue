<template>
  <div class="flex gap-[8px]">
    <div class="w-[20px] flex-shrink-0">
      <img src="/img/location.svg" alt="location"/>
    </div>
    <p class="text-[14px] leading-[16px]">
      <Link
        v-if="address?.city"
        :href="address?.slugs?.city"
        class="underline text-[#6170FF]"
        >{{ address.city + ", " }}</Link
      >
      <Link
        v-if="address?.city_area"
        :href="address?.slugs?.city_area"
        class="underline text-[#6170FF]"
        >{{ address.city_area + ", " }}</Link
      >
      <Link
        v-if="address?.city_district"
        :href="address?.slugs?.city_district"
        class="underline text-[#6170FF]"
        >{{ address.city_district + " район," }}
      </Link>
      {{}}
      <br class="block md:hidden" />
      <span v-if="address.street_with_type != null">
        {{ address.street_with_type + "," }}
      </span>
      <span v-if="address.house != null">
        {{
          " д." +
          address.house +
          (address.block != null ? " стр " + address.block : "")
        }}
      </span>
    </p>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: {
    Link,
  },
  props: {
    address: Object,
  },
};
</script>
