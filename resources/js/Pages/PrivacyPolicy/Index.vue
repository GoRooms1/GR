<template>
  <AppHead 
    :title="page?.meta?.title ?? page?.title"
    :url="$page.props.app_url + page?.meta?.url"
    :meta_keywords="page?.meta?.meta_keywords"
    :meta_description="page?.meta?.meta_description"
    :canonical="$page.props?.app_url + '/' + page?.slug"
  /> 
  <div class="container mx-auto px-4 lg:px-6 min-[1920px]:px-[10vw] z-10 my-16">
    <h1 class="font-semibold text-3xl px-2">
      {{ page?.meta?.h1 ?? page?.title }}
    </h1>
    <div class="w-full pt-4" v-html="page?.content"></div>
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
  },  
};
</script>
