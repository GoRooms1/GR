<template>
  <Header />
  <main class="pb-[104px]">    
    <slot />
  </main>
  <Footer>
    <search-control-panel/>
    <social-links/>
    <div data="footer-copyr" class="hidden lg:block pt-1 mx-auto lg:ml-12 lg:mr-auto">
      © {{new Date().getFullYear()}} {{$page.props.contacts.org_name}}
    </div>
    <div class="mr-12 pt-1  hidden lg:flex">
      <a href="#" class="underline">
        Хранение и обработка персональных данных
      </a>
    </div>				
    <navigation simple classes="hidden lg:flex"/>
  </Footer>
</template>

<script>
import Header from "./partials/Header.vue";
import Footer from "./partials/Footer.vue";
import Navigation from "./partials/Navigation.vue"
import SocialLinks from "./partials/SocialLinks.vue"
import SearchControlPanel from "@/components/widgets/SearchControlPanel.vue"
export default {
  components: {
    Header,
    Footer,
    Navigation,
    SocialLinks,
    SearchControlPanel,
  },
};
</script>
