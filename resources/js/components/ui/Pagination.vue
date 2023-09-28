<template>
  <div class="text-xs xs:text-sm mb-2" v-if="links.length > 3">
    Показано c {{ meta?.from }} по {{ meta?.to }} из {{ meta?.total }}         
  </div>
  <div class="flex flex-wrap w-full justify-center" v-if="links.length > 3">    
    <template v-for="(link, key) in links">               
      <div v-if="link.url === null" :key="link.label" 
        class="mr-2 mb-2 px-[12px] h-[32px] items-center justify-center md:hover:outline outline-solid outline-[#6170FF] transition duration-150 rounded pointer-events-none bg-slate-200"
        :class="key == 0 || key == links.length-1 ? 'flex' : 'hidden md:flex'"    
        v-html="link.label"
      />
      <Link v-else :key="link.label" 
        class="mr-2 mb-2 px-[12px] h-[32px] items-center justify-center md:hover:outline outline-solid outline-[#6170FF] transition duration-150 rounded" 
        :class="(link.active ? 'bg-[#6170FF] text-white pointer-events-none ' : 'bg-white ') + (key == 0 || key == links.length-1 ? 'flex' : 'hidden md:flex') "      
        :href="link.url" v-html="link.label" />
    </template>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
  props: {
    links: Array,
    meta: Object,
  },
  components : {
    Link
  }
};
</script>
