<template>
  <Head :title="title ? `${title}` : 'Gorooms'">
    <meta name="keywords" :content="meta_keywords ?? ''">    
    <meta name="description" :content="meta_description ?? ''">    
    <meta v-if="hotel" name="author" :content="hotel?.name ?? ''">
    <meta v-if="hotel" property="og:locale" content="ru_RU"/>
    <meta v-if="hotel" property="og:type" content="article"/>
    <meta v-if="hotel" property="og:title" :content="title"/>
    <meta v-if="hotel" property="og:description" :content="meta_description ?? ''"/>
    <meta v-if="hotel" property="og:url" :content="url"/>
    <meta v-if="hotel" property="og:image" :content="$page.props.app_url + '/img/logo.svg'"/>
    <meta v-if="hotel" property="og:site_name" :content="$page.props.app_url + '/'"/> 
    <link v-if="meta_keywords" rel="canonical" :href="meta_keywords"/>   
    <slot />
  </Head>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";

export default {
  name: "AppHead",
  components: {
    Head,
  },
  props: {
    title: String,    
    url: String,
    meta_description: String,
    meta_keywords: String,
    hotel: {
      type: Object,
      default: null,
    },
  },
};
</script>

<style scoped></style>
