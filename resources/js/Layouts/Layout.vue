<template>
  <Header />
  <main class="pb-[104px]">    
    <slot />
  </main>
  <Footer />
</template>

<script>
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
export default {
  components: {
    Header,
    Footer,    
  },
};
</script>
