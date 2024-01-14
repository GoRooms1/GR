<template>
  <AppHead 
    :title="page?.meta?.title ?? page?.title"
    :url="$page.props.app_url + page?.meta?.url"
    :meta_keywords="page?.meta?.meta_keywords"
    :meta_description="page?.meta?.meta_description"
    :canonical="$page.props?.app_url + '/' + page?.slug"
  /> 
  <div class="filter h-32 xl:h-40 pt-4 -mb-16 xl:pt-8 my-16">
    <div class="mb-4 container mx-auto px-4 lg:px-6 min-[1920px]:px-[10vw]">
      <h1 class="font-semibold text-3xl text-white px-2">
        {{ page?.meta?.h1 ?? page?.title }}
      </h1>
    </div>   
  </div>
  <div class="container mx-auto px-4 lg:px-6 min-[1920px]:px-[10vw] z-10">    
    <div class="flex flex-wrap w-full items-stretch">
      <ArticleCard v-for="article in articles.data" :key="article.id" :article="article"/>
    </div>
    <div class="mx-auto mt-8 w-full text-center"> 
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
