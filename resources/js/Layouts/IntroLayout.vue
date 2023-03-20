<template>
  <Header />
  <main class="pb-[104px]">
    <slot />
  </main>
  <div class="hidden lg:block">
    <Footer>
      <Social-links />
      <copyright class="block pt-1 mx-auto lg:ml-12 lg:mr-auto" />
      <privacy-policy class="mr-12 pt-1 hidden lg:flex" />
      <Navigation simple classes="hidden lg:flex" />
    </Footer>
  </div>
</template>

<script>
import Header from "./partials/Header.vue";
import Footer from "./partials/Footer.vue";
import Navigation from "./partials/Navigation.vue";
import SocialLinks from "./partials/SocialLinks.vue";
import SearchControlPanel from "@/components/widgets/SearchControlPanel.vue";
import Copyright from "./partials/Copyright.vue";
import PrivacyPolicy from "./partials/PrivacyPolicy.vue";

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
