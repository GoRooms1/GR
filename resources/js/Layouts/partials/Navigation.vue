<template>
  <div class="flex" :class="classes">
    <nav-link
      href="/?as=map"
      :title="simple ? '' : 'Карта'"
      classes="bg-[url(/img/link1_1.svg)] hover:bg-[url(/img/link1_2.svg)]"
    />
    <nav-link
      v-if="simple"
      href="/hot"
      classes="bg-[url(/img/link2_1.svg)] hover:bg-[url(/img/link2_2.svg)]"
    />
    <nav-link
      disabled
      :title="simple ? '' : 'Бонусная программа'"
      classes="bg-[url(/img/link3_1.svg)] hover:bg-[url(/img/link3_2.svg)]"
    />
    <a href="/lk/start" class="nav-link flex items-center mr-4 pl-[24px] h-[24px] bg-left bg-no-repeat bg-contain bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)]">      
      <span v-if="!simple"  class="pl-2">
          {{simple ? '' : 'Добавить объект'}}
      </span>
    </a>
    <Link v-if="!simple" href="/blog" class="nav-link flex items-center mr-4 h-[24px]">      
      Статьи
    </Link>
    <nav-link
      :title="simple ? '' : 'О нас'"
      href="/about"
      classes="bg-[url(/img/about_1.svg)] hover:bg-[url(/img/about_2.svg)]"
    />     
    <nav-link
      href="/contacts"
      classes="bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)]"
    />    
    <nav-link
      disabled
      classes="bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)]"
    />
    <a href="/login" class="nav-link flex items-center w-[24px] h-[24px] bg-left bg-no-repeat bg-contain bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)]">
    </a>   
  </div>  
</template>

<script>
import NavLink from "@/components/ui/NavLink.vue";
import { Link } from "@inertiajs/vue3";
export default {
  components: {
    NavLink,
    Link,   
  },
  props: {
    simple: Boolean,
    classes: String,
  },
};
</script>
