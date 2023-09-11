<template>   
  <div v-if="image" class="overflow-hidden rounded-2xl" :class="classes" v-intersection-observer="onIntersectionObserver">   
    <a :href="banner?.url" target="_blank">
      <img :src="image?.conversions?.show ?? image.url" :key="key" class="w-full rounded-2xl zoom-infinity"/>
    </a>   
  </div>  
</template>

<script>
import { vIntersectionObserver } from '@vueuse/components'
import axios from 'axios';

export default {
  components: {
    axios,
  },
  directives: {
    intersectionObserver: vIntersectionObserver,
  },  
  props: {   
    classes: String,
  },
  data() {
    return {
      banner: {},
      position: 0,
      image: null,
      delay: 2000,
      visible: false,
      key: 1,     
    }
  },
  mounted() {   
    this.loadBanner();
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
    loadBanner() {
      let data = { 
        num: 1,
        city: this.$page.props?.ad_params?.city,
        page_type: this.$page.props?.ad_params?.page_type,        
      };

      axios
        .get('/api/ad_banners', {
          params: data,
          headers: {
            'Content-Type': 'application/json'
          }
        })        
        .then(response => {        
          let data = response?.data?.payload?.ad_banners;
          if (data) { 
            this.banner = data[0];
            this.image = this.banner?.images[0];

            return this.banner;
          }          
        })
        .then(e => {
          this.play();
        });
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
  .zoom-infinity {
    animation: zoom-in-zoom-out 2s ease-in-out;
  }

  .w-\[49\%\] {
    width: 49%;
  }

  @keyframes zoom-in-zoom-out {
    0% {
      transform: scale(1, 1);
    }
    50% {
      transform: scale(1.05, 1.05);
    }
    100% {
      transform: scale(1, 1);
    }
  }

</style>
