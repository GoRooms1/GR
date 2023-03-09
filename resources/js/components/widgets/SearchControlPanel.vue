<template>
    <div class="flex lg:hidden w-full p-2">
        <button class="p-2.5 rounded-l-lg bg-[#EAEFFD]">
            <img src="img/map.svg" alt="map">
        </button>
        <button @click="getData()" class="p-2.5 rounded-r-lg mr-[10%] bg-[#6170FF]">
            <img src="img/listpointers2.svg" alt="listpointers">
        </button>
        <button class="p-2.5 rounded-lg mx-[1.7%] ml-auto bg-[#6170FF]">
            <img src="img/search2.svg" alt="search">
        </button>	
        <button @click="toggleFilters()" class="p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
            <img src="img/filters.svg" alt="filters">
        </button>				
        <button class="btn-disabled pointer-events-none p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
            <img src="img/bolt.svg" alt="bolt">
        </button>
        <button class="btn-disabled pointer-events-none p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
            <img src="img/footer-cashback.svg" alt="footer-cashback">
        </button>
        <button class="btn-disabled pointer-events-none p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
            <img src="img/heart.svg" alt="heart">
        </button>        
    </div>
</template>

<script>
    import { usePage } from '@inertiajs/inertia-vue3'
    import { filterStore } from '@/Store/filterStore.js'
    export default {
        data() {
            return {
                filterStore,
            }
        },
        methods: {
            getData() {                                
                this.$inertia.get(route('filter'), this.filterStore.getFiltersValues(), {
                    preserveState: true,
                    preserveScroll: true,
                    onStart: () => {usePage().props.value.isLoadind = true},
                    onFinish: () => {usePage().props.value.isLoadind = false},                                       
                });              
            },
            toggleFilters() {
                usePage().props.value.modals.filters = !usePage().props.value.modals.filters;
            },
        }       
    }
</script>
