<template>
  <Responsive-nav/>
  <Header />
  <main :class="has_filters ? 'pb-[104px]' : 'pb-2'">
    <slot />
  </main>  
  <Footer>
    <search-control-panel v-if="has_filters"/>
    <social-links />
    <copyright class="hidden lg:block pt-1 mx-auto text-center" />
    <privacy-policy class="mr-2 pt-1 hidden lg:flex text-center" />
    <instructions class="mr-2 pt-1 hidden lg:flex h-full" />
    <navigation simple classes="hidden lg:flex" />
  </Footer>
  <Modals/>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import Header from "./partials/Header.vue";
import Footer from "./partials/Footer.vue";
import Navigation from "./partials/Navigation.vue";
import SocialLinks from "./partials/SocialLinks.vue";
import Copyright from "./partials/Copyright.vue";
import PrivacyPolicy from "./partials/PrivacyPolicy.vue";
import Instructions from "./partials/Instructions.vue";
import ResponsiveNav from "./partials/ResponsiveNav.vue";
import Modals from "./partials/Modals.vue";
export default {
  components: {
    Header,
    Footer,
    Navigation,
    SocialLinks,    
    Copyright,
    PrivacyPolicy,
    Instructions,
    ResponsiveNav,
    Modals,    
    SearchControlPanel: defineAsyncComponent(() =>
      import('@/components/widgets/SearchControlPanel.vue')
    ),    
  },
  props: {
    has_filters: Boolean,
  }   
};
</script>
