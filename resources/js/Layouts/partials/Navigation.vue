<template>
  <div class="flex" :class="classes">
    <nav-link
      href="/search_map"
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
    <button class="flex">
      <a href="/lk/start" class="flex items-center mr-4 pl-[24px] h-[24px] bg-left bg-no-repeat bg-contain bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)]">
        <span class="pl-2">
          {{simple ? '' : 'Добавить объект'}}
        </span>
      </a>
    </button>    
    <nav-link
      href="/contacts"
      classes="bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)]"
    />
    <nav-link
      disabled
      classes="bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)]"
    />
    <button class="flex">
      <a href="/login" class="flex items-center w-[24px] h-[24px] bg-left bg-no-repeat bg-contain bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)]"></a>
    </button>
  </div>
  <div class="pt-1 lg:hidden">
    <button @click="$page.props.modals.menu = true">
      <svg
        width="24"
        height="16"
        viewBox="0 0 24 16"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M1.3335 14.6665H22.6668"
          stroke="#6170FF"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
        <path
          d="M1.3335 8H22.6668"
          stroke="#6170FF"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
        <path
          d="M1.3335 1.33325H22.6668"
          stroke="#6170FF"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
      </svg>
    </button>
  </div>  
</template>

<script>
import NavLink from "@/components/ui/NavLink.vue";
export default {
  components: {
    NavLink,    
  },
  props: {
    simple: Boolean,
    classes: String,
  },
};
</script>
