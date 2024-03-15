<template>
  <AppHead title="Gorooms.ru" />  
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";

export default {
  components: {
    AppHead,
    Layout,    
  },
  mounted() {    
    this.$page.props.flash.message = null;
    this.$page.props.modals.auth_extranet = true;    
  }
};
</script>
