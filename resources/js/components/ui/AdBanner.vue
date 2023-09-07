<template>   
  <div class="overflow-hidden rounded-2xl" :class="classes" v-intersection-observer="onIntersectionObserver">   
    <a :href="banner?.url">
      <Transition name="zoom">     
          <img :src="image.url" :key="key" class="w-full rounded-2xl"/>       
      </Transition>
    </a>    
  </div>  
</template>

<script>
import { vIntersectionObserver } from '@vueuse/components'

export default {
  directives: {
    intersectionObserver: vIntersectionObserver,
  },
  props: {
    banner: Object,
    classes: String,
  },
  data() {
    return {
      position: 0,
      image: this.banner?.images[0],
      delay: 2000,
      visible: false,
      key: 1,     
    }
  },
  mounted() {    
    this.play();
  },
  methods: {
    changeSlide() {      
      let length = (this.banner?.images ?? []).length;
     
      if (length <= 1) return;

      if (this.position < length - 1) 
        this.position++;
      else if (this.position == length - 1)
        this.position = 0;     
      
      this.image = this.banner?.images[this.position];
      this.changeKey();     
    },    
    play() {      
      setInterval(() => {              
        this.changeSlide();
      }, this.delay);
    },
    changeKey() {
      this.key = (Math.random() + 1).toString(36).substring(7);
    },
    onIntersectionObserver([{ isIntersecting }]) {
      if (isIntersecting && (this.banner?.images ?? []).length == 1) {
        this.changeKey();
      }     
    },   
  },
};
</script>

<style scoped>  
  .zoom-enter-active {
    transition: transform 1s ease-in-out;
  }  
  .zoom-enter-to {
    transform: scale(1.05);
  }
  .w-\[49\%\] {
    width: 49%;
  }
  .zommed {
    transform: scale(1.05);
  }
</style>
