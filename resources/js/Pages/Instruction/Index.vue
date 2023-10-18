<template>
  <AppHead 
    :title="page?.meta?.title ?? page?.title"
    :url="$page.props.app_url + page?.meta?.url"
    :meta_keywords="page?.meta?.meta_keywords"
    :meta_description="page?.meta?.meta_description"
    :canonical="$page.props?.app_url + page?.meta?.url"
  /> 
  <div class="container mx-auto px-4 lg:px-6 min-[1920px]:px-[10vw] z-10 my-16">
    <h1 class="font-semibold text-3xl px-2">
      {{ page?.meta?.h1 ?? page?.title }}
    </h1>
    <section class="w-full pt-4 part px-2">
      <ul class="">            
        <li v-for="i in instructions">
          <a class="flex mb-2 hover:text-[#6170FF]" :href="'#partText' + i.id" @click="scrollToSection('partText' + i.id, $event)">
            <img width="16" height="16" src="/img/bookmark.svg" alt="">
            <span class="ml-4 font-semibold text-md">{{ i.header }}</span>
          </a>
        </li>            
      </ul>
    </section>
    <div class="w-full pt-8">      
      <section v-for="i in instructions" class="part part_text mb-4" :id="'partText' + i.id">
        <div class="">
          <h2 class="font-semibold text-xl px-2 text-[#6170FF]">{{ i?.header }}</h2>
          <div class="mt-2 flex flex-wrap items-center" v-html="i?.content"></div>
        </div>
      </section>      
    </div>
  </div>  
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";

export default {  
  components: {
    AppHead,
    Layout,   
  },
  props: {
    page: Object,
    instructions: [Object],   
  },  
  data() {
    return {
      inMove: false,
      activeSection: null,
    }
  },
  mounted() {
    let iframes = document.getElementsByTagName("iframe");

    for (let iframe of iframes) {
      iframe.parentElement.classList.add('w-full');      
      iframe.classList.add('mx-auto', '!w-full',  'md:!w-[70%]');
    }
  },
  methods: {
    scrollToSection (id, event) {
      if (event) {
        event.preventDefault();
      }

      if (this.inMove === true)
        return;
      
      this.activeSection = id;
      this.inMove = true;
      document.getElementsByTagName('section')[id].scrollIntoView({
          behavior: 'smooth',
          block: 'center'
      });

      setTimeout(() => {
          this.inMove = false;
      }, 400);
    },
  }  
};
</script>
