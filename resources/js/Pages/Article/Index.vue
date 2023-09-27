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
      <ArticleCard v-for="article in articlesList" :key="article.id" :article="article"/>
    </div>
    <div v-if="articlesList.length > 0 && $page.props?.is_loading !== true"
      class="container mx-auto px-4 min-[1920px]:px-[10vw] mt-8 mb-12">
      <div v-if="isLoading" class="text-center">
        <Loader />
      </div>
      <div v-if="!isLoading" class="text-center">
        <div class="text-xs xs:text-sm">
          Показано {{ articlesList.length }} из
          {{ articles?.meta?.total ?? articlesList.length }}
        </div>
        <div v-if="articles?.meta?.next_page_url">
          <Button @click="loadMore()" classes="mx-auto mt-3">
            Показать ещё
          </Button>
        </div>
      </div>
    </div>
  </div>  
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import ArticleCard from "@/components/ui/ArticleCard.vue";
import Loader from "@/components/ui/Loader.vue";
import Button from "@/components/ui/Button.vue";

export default {  
  components: {
    AppHead,
    Layout,
    ArticleCard,
    Loader,
    Button,
  },
  props: {
    page: Object,
    articles: [Object],  
  },
  data() {
    return {      
      articlesList: this.articles?.data ?? [],
      isLoading: false,
    };
  }, 
  methods: {
    loadMore() {
      let initialUrl =
        typeof window !== "undefined" ? window.location.href : "";

      let currentPage = this.articles?.meta?.current_page ?? 1;
      let nextPage = currentPage + 1;      

      if (this.articles?.meta?.next_page_url) {
        this.$inertia.get(
          this.$page.props.path + "?page=" + nextPage,
          {},
          {
            preserveState: true,
            preserveScroll: true,
            only: [this.type],
            onSuccess: () => {
              if (this.articles.meta.current_page != 1)
                this.articlesList = [
                  ...this.articlesList,
                  ...this.articles.data,
                ];

              if (typeof window !== "undefined")
                window.history.pushState({}, this.$page.title, initialUrl);
            },
            onStart: () => {
              this.isLoading = true;
            },
            onFinish: () => {
              this.isLoading = false;
            },
          }
        );
      }
    },
  },
  watch: {
    articles: function (newVal, oldVal) {
      if (this.articles?.meta?.current_page == 1) {
        this.articlesList = this.articles?.data ?? [];
      }
    },
  }, 
};
</script>
