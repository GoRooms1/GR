<template>
  <div class="fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] lg:h-[100vh] backdrop-blur-[2.5px] flex flex-col lg:justify-center items-center pt-[70px] pb-[104px]">
    <div class="max-w-[836px] w-full flex flex-col">
        <button @click="$eventBus.emit('favorites-close')" class="absolute top-[12px] right-[16px] lg:static lg:w-[32px] lg:h-[32px] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
            <img src="/img/close.svg" alt="close">
        </button>
        <div class="py-4 px-6 flex bg-[#6170FF] items-center lg:px-4 lg:rounded-3xl">
            <img src="/img/heartWhite.svg">
            <span class="ml-5 text-white font-semibold text-[22px] lg:text-[28px]">Ваши избранные номера</span>
            <button @click="deleteAll()" class="px-3 py-2 rounded-lg border-[1px] border-solid border-white text-white font-semibold text-[14px] ml-auto">Очистить</button>
        </div>
        <div class="mt-2 mx-[1.625rem] max-h-[75vh] lg:max-h-[68vh] overflow-y-auto scrollbar pr-3 lg:mx-0 flex flex-col">
          <room-card v-for="room in $page.props.favorites" :room="room" :key="room.id" short-view="true" classes="my-4" />
        </div>
    </div>
</div>
</template>

<script>
import RoomCard from "@/components/ui/RoomCard.vue"
export default {
  components: {
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
