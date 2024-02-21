<template>
  <div class="fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] lg:h-[100vh] backdrop-blur-[2.5px] flex flex-col lg:justify-center items-center pt-[70px] pb-[104px]">
    <div class="max-w-[836px] w-full flex flex-col">
        <button @click="$eventBus.emit('reviews-close')" class="absolute top-[12px] right-[16px] lg:static lg:w-[32px] lg:h-[32px] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
            <img src="/img/close.svg">
        </button>       
        <div v-if="!loading" class="mt-2 mx-[1.625rem] max-h-[80vh] overflow-y-auto scrollbar pr-3 lg:mx-0 flex flex-col">
            <ReviewCard v-for="review in reviews" :key="review.id" :review="review"/>
        </div>
        <div v-if="loading" class="mt-2 text-center">          
          <Loader />
        </div>
    </div>
  </div>
</template>

<script>
import Loader from "@/components/ui/Loader.vue";
import ReviewCard from "@/components/ui/ReviewCard.vue";
export default {
  components: {
    Loader,
    ReviewCard,
  },
  mounted() {    
  },
  props: {
    reviews: [Object],
    loading: false,
  }
};
</script>
