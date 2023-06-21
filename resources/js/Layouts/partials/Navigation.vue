<template>
  <div class="flex" :class="classes">
    <nav-link
      href="/?as=map"
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
    <form class="flex" action="/lk/start" method="get">
      <button class="flex  items-center mr-4 pl-[24px] h-[24px] bg-left bg-no-repeat bg-contain bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)]">      
        <span class="pl-2">
            {{simple ? '' : 'Добавить объект'}}
          </span>
      </button> 
    </form>
       
    <nav-link
      href="/contacts"
      classes="bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)]"
    />
    <nav-link
      disabled
      classes="bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)]"
    />
    <form class="flex" action="/login" method="get">
      <button class="flex items-center w-[24px] h-[24px] bg-left bg-no-repeat bg-contain bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)]">
      </button> 
    </form>    
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
