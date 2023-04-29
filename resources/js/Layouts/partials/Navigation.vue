<template>
  <div class="flex" :class="classes">
    <nav-link
      :title="simple ? '' : 'Карта'"
      classes="bg-[url(/img/link1_1.svg)] hover:bg-[url(/img/link1_2.svg)]"
    />
    <nav-link
      v-if="simple"
      disabled
      classes="bg-[url(/img/link2_1.svg)] hover:bg-[url(/img/link2_2.svg)]"
    />
    <nav-link
      disabled
      :title="simple ? '' : 'Бонусная программа'"
      classes="bg-[url(/img/link3_1.svg)] hover:bg-[url(/img/link3_2.svg)]"
    />
    <nav-link
      disabled
      :title="simple ? '' : 'Добавить объект'"
      classes="bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)]"
    />
    <nav-link
      href="/contacts"
      classes="bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)]"
    />
    <nav-link
      disabled
      classes="bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)]"
    />
    <nav-link
      href="/login"
      classes="bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)]"
    />
  </div>
  <Responsive-nav v-if="!simple" />
</template>

<script>
import ResponsiveNav from "./ResponsiveNav.vue";
import NavLink from "@/components/ui/NavLink.vue";
export default {
  components: {
    NavLink,
    ResponsiveNav,
  },
  props: {
    simple: Boolean,
    classes: String,
  },
};
</script>
