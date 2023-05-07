<template>
  <header class="header fixed top-0 left-0 z-20">
    <div class="container mx-auto p-0 lg:px-4">
      <div
        class="flex justify-between items-center px-4 py-3 bg-white rounded-b-2xl text-sm"
      >
        <div>
          <Logo />
        </div>
        <div v-if="$page.props?.count?.hotels" class="text-sm ml-4 pt-1">
          {{ $page.props.count.hotels }} почасовых отелей
        </div>
        <navigation classes="flex ml-auto hidden lg:flex" />
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
      </div>
    </div>
  </header>
</template>

<script>
import Navigation from "./Navigation.vue";
import Logo from "./Logo.vue";

export default {
  components: {
    Navigation,
    Logo,
  },
};
</script>
