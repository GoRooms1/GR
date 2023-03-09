<template>
    <AppHead :title="model.page.title" />
    <search-filter-modal/>
    <div class="md:mt-[49px] mt-[40px] relative">
        <img class="md:block hidden absolute bottom-[-50px] left-0 -z-[1]" src="img/lens.svg" alt="lens">
        <img class="absolute md:bottom-[-150px] bottom-[-20px] md:right-0 right-[50px] -z-[1] md:w-initial sm:w-[30%] w-[50%]" src="img/lens1.svg" alt="lens">
        <search-panel/>        
    </div> 
    <filter-header :found="hotels?.meta?.total ?? 0"/>
    <hotels-list :hotels="hotels"/>    
    <info-block/>
</template>

<script lang="ts">
    import AppHead from "@/components/ui/AppHead.vue"
    import type { PropType } from "vue"
    import { PageInterface } from "../../models/pages/page.interface"
    import Layout from '@/Layouts/Layout.vue'
    import SearchLayout from '@/Layouts/SearchLayout.vue'
    import SearchPanel from "@/components/widgets/SearchPanel.vue"
    import SearchFilterModal from "@/components/widgets/SearchFilterModal.vue"
    import FilterHeader from "./partials/FilterHeader.vue"
    import HotelsList from "./partials/HotelsList.vue"
    import InfoBlock from "./partials/InfoBlock.vue"
    export default {
        layout: SearchLayout,
        components: {
            AppHead,
            Layout,
            SearchLayout,
            SearchPanel,
            FilterHeader,
            HotelsList,
            InfoBlock,
            SearchFilterModal,         
        },
        props: {
            model: {
                type: Object as PropType<PageInterface>,
                required: true,
            },
            hotels: [Object],
        },
    }
</script>
