<template>
  <Link class="block w-full md:w-1/2 lg:w-1/3 xl:w-1/4 my-4 px-2 group"  :href="'/blog/' + article?.slug">
        <div class="overflow-hidden object-cover rounded-tl-2xl rounded-tr-2xl h-52 w-full relative">
            <img class="w-full h-full object-cover" :src="article?.image?.conversions?.card ?? article?.image?.url" alt="img">
            <div class="absolute left-0 top-0 bg-[#6170FF] text-white flex flex-col justify-center text-center w-12 rounded-tl-2xl rounded-br-2xl">
                <span class="font-bold text-xl">{{article?.day}}</span>
                <span class="text-sm font-bold">{{article?.month}}</span>
            </div>               
        </div>                               
        <div class="bg-white rounded-bl-2xl rounded-br-2xl p-4 w-full h-52 flex flex-wrap">
            <span class="block font-bold text-xl leading-6 mb-2 w-full">{{ article?.title }}</span>
            <div class="text-sm mb-2 w-full">
              {{ article?.notice }}
            </div>
            <span class="font-bold text-sm leading-6 group-hover:underline text-[#6170FF] mt-auto">Подробнее</span>
        </div>
    </Link>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    Link,
  },
  props: {
    article: Object, 
  }
};
</script>
