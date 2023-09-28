<template>
  <AppHead 
    :title="page?.title"
    :url="$page.props.app_url + page?.meta?.url"
    :meta_keywords="page?.meta?.meta_keywords"
    :meta_description="page?.meta?.meta_description"
    :canonical="$page.props?.app_url + page?.meta?.url"
  />
  <div class="container mx-auto px-4 py-4 my-16 lg:px-6 min-[1920px]:px-[10vw] z-10">
    <div class="mb-4 px-2">
        <h1 class="font-semibold text-3xl">
            {{ page?.meta?.h1 ?? page?.title }}
        </h1>
    </div>
    <div class="flex flex-wrap w-full">
      <ArticleCard v-for="article in articles.data" :key="article.id" :article="article"/>
    </div>
    <div class="mx-auto mt-8 mb-12 w-full text-center"> 
      <Pagination :links="articles.links" :meta="articles.meta"/>
    </div>
  </div>  
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import ArticleCard from "@/components/ui/ArticleCard.vue";
import Pagination from "@/components/ui/Pagination.vue";

export default {  
  components: {
    AppHead,
    Layout,
    ArticleCard,    
    Pagination,
  },
  props: {
    page: Object,
    articles: [Object],  
  },  
};
</script>
