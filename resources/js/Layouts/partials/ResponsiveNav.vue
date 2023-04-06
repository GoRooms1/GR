<template>
  <div class="pt-1 lg:hidden">
    <button @click="show()">
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
  <div
    id="menu"
    class="fixed top-0 left-0 z-40 bg-[#D2DAF0B3] w-full h-[100vh] overflow-hidden backdrop-blur-[2.5px] flex-col justify-center items-center lg:hidden px-7"
    v-bind:class="this.isOpen() ? 'flex' : 'hidden'"
  >
    <button v-on:click="hide()" class="absolute top-[12px] right-[16px]">
      <img src="/img/close.svg" />
    </button>
    <div class="flex flex-col px-6 py-8 bg-white rounded-3xl w-full mb-[17%]">
      <h3 class="mb-6 font-semibold">Меню</h3>
      <responsive-nav-link
        title="Карта"
        classes="bg-[url(/img/link1_1.svg)] hover:bg-[url(/img/link1_2.svg)]"
      />
      <responsive-nav-link
        disabled
        title="Горящие предложения"
        classes="bg-[url(/img/link2_1.svg)] hover:bg-[url(/img/link2_2.svg)]"
      />
      <responsive-nav-link
        disabled
        title="Бонусная программа"
        classes="bg-[url(/img/link3_1.svg)] hover:bg-[url(/img/link3_2.svg)]"
      />
      <responsive-nav-link
        disabled
        title="Добавить объект"
        classes="bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)]"
      />
      <responsive-nav-link
        title="Контакты"
        :href="route('contact')"
        classes="bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)]"
      />
      <responsive-nav-link
        disabled
        title="Избранное"
        classes="bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)]"
      />
      <responsive-nav-link
        title="Личный кабинет"
        :href="'/login'"
        classes="bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)]"
      />
      <h3 class="mb-6 mt-10 font-semibold">Мы в социальных сетях</h3>
      <div class="grid grid-cols-2 grid-rows-2 gap-2">
        <a
          v-if="$page.props?.contacts?.fb"
          :href="$page.props.contacts.fb"
          target="_blank"
          class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc11.svg)] hover:bg-[url(/img/soc12.svg)] pl-[42px] w-full text-left"
        >
          Facebook
        </a>
        <a
          v-if="$page.props?.contacts?.vk"
          :href="$page.props.contacts.vk"
          target="_blank"
          class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc31.svg)] hover:bg-[url(/img/soc32.svg)] pl-[42px] w-full text-left"
        >
          Вконтакте
        </a>
        <a
          v-if="$page.props?.contacts?.instagram"
          :href="$page.props.contacts.instagram"
          target="_blank"
          class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc21.svg)] hover:bg-[url(/img/soc22.svg)] pl-[42px] w-full text-left"
        >
          Instagram
        </a>
        <a
          v-if="$page.props?.contacts?.youtube"
          :href="$page.props.contacts.youtube"
          target="_blank"
          class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc41.svg)] hover:bg-[url(/img/soc42.svg)] pl-[42px] w-full text-left"
        >
          YouTube
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import ResponsiveNavLink from "@/components/ui/ResponsiveNavLink.vue";
import { usePage } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
    ResponsiveNavLink,
  },
  created() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
    if (!usePage().props.value.modals)
      usePage().props.value.modals = {};
    usePage().props.value.modals.menu = false;
  },
  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },
  data() {
    return {
      screenWidth: window.innerWidth,
    };
  },
  methods: {
    show() {      
      usePage().props.value.modals.menu = true;
    },
    hide() {
      usePage().props.value.modals.menu = false;
    },
    isOpen() {
      return usePage().props.value.modals?.menu ?? false;
    },
    handleResize() {
      if (this.isOpen == true) {
        this.screenWidth = window.innerWidth;
        if (this.screenWidth > 1024) this.hide();
      }
    },
  },
};
</script>
