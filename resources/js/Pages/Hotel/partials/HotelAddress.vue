<template>
  <div class="flex gap-[8px]">
    <div class="w-[20px] flex-shrink-0">
      <img src="/img/location.svg" alt="location"/>
    </div>
    <p class="text-[14px] leading-[16px]">
      <Link
        v-if="address?.city"
        :href="getAddressHref(address.city)"
        class="underline text-[#6170FF]"
        >{{ address.city + ", " }}</Link
      >
      <Link
        v-if="address?.city_area"
        :href="getAddressHref(address.city, address.city_area)"
        class="underline text-[#6170FF]"
        >{{ address.city_area + ", " }}</Link
      >
      <Link
        v-if="address?.city_district"
        :href="
          getAddressHref(address.city, address.city_area, address.city_district)
        "
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
  methods: {
    getAddressHref(city = null, area = null, district = null) {
      let url = "/address";
      if (city) {
        url += "/" + this.getAddressSlug(city);

        if (area) {
          url += "/area-" + this.getAddressSlug(area);

          if (district) url += "/district-" + this.getAddressSlug(district);
        }

        if (!area && district) {
          url += "/district-" + this.getAddressSlug(district);
        }
      }

      return url;
    },
    getAddressSlug(name) {
      let slugs = this.address?.slugs ?? [];
      return slugs.find(el => el.address == name)?.slug;
    },
  },
};
</script>
