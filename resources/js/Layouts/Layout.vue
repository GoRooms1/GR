<template>
  <Responsive-nav/>
  <Header />
  <main class="pb-[104px]">
    <slot />
  </main>  
  <Footer>
    <search-control-panel v-if="has_filters"/>
    <social-links />
    <copyright class="hidden lg:block pt-1 mx-auto lg:ml-12 lg:mr-auto" />
    <privacy-policy class="mr-12 pt-1 hidden lg:flex" />
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
