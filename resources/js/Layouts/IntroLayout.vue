<template>
  <Header />
  <main class="pb-[104px]">
    <div class="overflow-hidden fixed top-0 left-0 right-0 bottom-0 -z-[1] block md:hidden">
			<img class="absolute top-[21px] right-[-10px] -z-[1] md:w-initial w-[220px]" src="img/lens1.svg" alt="lens">
			<div class="absolute top-0 left-0 h-full w-full -z-[1] bg-[#0018ff] opacity-60"></div>
		</div>    
    <slot />
  </main>
  <div class="hidden lg:block"> 
    <Footer>    
      <Social-links/>
      <copyright class="block pt-1 mx-auto lg:ml-12 lg:mr-auto"/>
      <privacy-policy class="mr-12 pt-1 hidden lg:flex"/>
      <Navigation simple classes="hidden lg:flex"/>
    </Footer>
  </div>  
</template>

<script>
import Header from "./partials/Header.vue";
import Footer from "./partials/Footer.vue";
import Navigation from "./partials/Navigation.vue"
import SocialLinks from "./partials/SocialLinks.vue"
import SearchControlPanel from "@/components/widgets/SearchControlPanel.vue"
import Copyright from './partials/Copyright.vue'
import PrivacyPolicy from './partials/PrivacyPolicy.vue'

export default {
  components: {
    Header,
    Footer,
    Navigation,
    SocialLinks,
    SearchControlPanel,
    Copyright,
    PrivacyPolicy,
  },
};
</script>
