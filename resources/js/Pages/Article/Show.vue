<template>
  <AppHead 
    :title="article?.meta_title"
    :url="$page.props.app_url + $page.props.path"
    :meta_keywords="article?.meta_keywords"
    :meta_description="article?.meta_description"    
  />
  <div class="container mx-auto px-4 py-4 my-16 lg:px-6 min-[1920px]:px-[10vw] z-10">
    <div class="mb-4">
        <h1 class="font-semibold text-3xl">
            {{ article?.title }}
        </h1>
    </div>
    <div class="w-full" v-html="article?.content"></div>    
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
    article: Object,  
  },  
};
</script>
