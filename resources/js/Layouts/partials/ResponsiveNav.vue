<template>
  <div
    id="menu"
    v-if="isOpen === true"
    class="flex fixed top-0 left-0 z-40 bg-[#D2DAF0B3] w-full h-[100vh] overflow-hidden backdrop-blur-[2.5px] flex-col justify-center items-center lg:hidden px-7"      
  >
    <button v-on:click="hide()" class="absolute top-[12px] right-[16px]">
      <img src="/img/close.svg" alt="close"/>
    </button>
    <div class="flex flex-col px-6 py-8 bg-white rounded-3xl w-full mb-[17%]">
      <h3 class="mb-6 font-semibold">Меню</h3>
      <responsive-nav-link
        href="/?as=map"
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
      <a 
        href="/lk/start"
        class="nav-link hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)] bg-[left_10px_center] text-left mb-2"
      >
        Добавить объект
      </a>
      <responsive-nav-link
        title="Контакты"
        href="/contacts"
        classes="bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)]"
        v-on:click="hide()"
      />
      <responsive-nav-link
        disabled
        title="Избранное"
        classes="bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)]"
        
      />
      <a 
        href="/login"
        class="hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)] bg-[left_10px_center] text-left mb-2"
      >
        Личный кабинет
      </a>
      <responsive-nav-link        
        title="Статьи"
        href="/blog"
        classes=""
        v-on:click="hide()"
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
import { Link } from "@inertiajs/vue3";
import ResponsiveNavLink from "@/components/ui/ResponsiveNavLink.vue";

export default {
  components: {
    Link,
    ResponsiveNavLink,    
  },
  created() {
    if (typeof window !== "undefined")
      window.addEventListener("resize", this.handleResize);
    this.handleResize();
    if (!this.$page.props.modals) this.$page.props.modals = {};
    this.$page.props.modals.menu = false;
  },
  destroyed() {
    if (typeof window !== "undefined")
      window.removeEventListener("resize", this.handleResize);
  },
  data() {
    return {
      screenWidth: 0,
    };
  },
  computed: {
    isOpen() {
      return this.$page.props.modals?.menu ?? false;
    }
  },
  methods: {    
    hide() {
      this.$page.props.modals.menu = false;

      if (this.$page.props?.filters?.as != 'map')
        document.body.classList.remove("fixed");     
    },    
    handleResize() {      
      if (typeof window !== "undefined") this.screenWidth = window.innerWidth;
      if (this.isOpen == true) {        
        if (this.screenWidth > 1024) this.hide();
      }
    },    
  },  
};
</script>
