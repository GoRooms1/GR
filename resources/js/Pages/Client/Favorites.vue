<template>
  <AppHead title="Gorooms.ru" />
  <Menu/>
  <div class="w-full mx-auto pb-[104px]">
    <div class="filter h-40 pt-4 -mb-20 xl:pt-8">
        <div class="container mx-auto px-4 min-[1920px]:px-[10vw]">
            <div class="flex justify-between items-center">
                <img src="/img/heartWhite.svg">
                <span class="ml-5 text-white font-semibold text-[22px] lg:text-[28px]">Ваши избранные номера</span>
                <button @click="deleteAll()" class="px-3 py-2 rounded-lg border-[1px] border-solid border-white text-white font-semibold text-[14px] ml-auto">Очистить</button>
            </div>
        </div>           
    </div>
    <div class="container mx-auto px-4 relative z-10 min-[1920px]:px-[10vw]">
      <room-card v-for="room in $page.props.favorites" :room="room" :key="room.id" classes="my-4" />
    </div>
  </div>
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import Menu from "./partials/Menu.vue";
import RoomCard from "@/components/ui/RoomCard.vue"

export default {
  components: {
    AppHead,
    Layout,
    Menu,
    RoomCard,    
  },
  methods: {
    deleteAll() {
      this.$inertia.post('/client/favorites/deleteAll', {}, {
          preserveState: true,
          preserveScroll: true,
          only: ["favorites"],                  
      });
    }
  }
};
</script>
