<template>
  <AppHead title="Gorooms.ru" />
  <Menu/>
  <div class="container mx-auto px-4 lg:px-6 min-[1920px]:px-[10vw] z-10 my-16">
    <button 
      @click="$inertia.post('/logout')"
      class="mt-4 h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-blue-500 hover:bg-blue-800"
    >
      Выйти
    </button>
  </div>   
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import Menu from "./partials/Menu.vue";

export default {
  components: {
    AppHead,
    Layout,
    Menu,    
  },
  mounted() {
   console.log('Client settings');
  }
};
</script>
