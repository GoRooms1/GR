<template>
    <div class="container mx-auto px-4 min-[1920px]:px-[10vw] relative z-10">
        <div class="flex flex-wrap -mx-4 mb-4">
            <hotel-card
                v-for="hotel in allHotels"
                :hotel="hotel"
            /> 
        </div>           
    </div>    
    <div v-if="allHotels.length > 0" class="container mx-auto px-4 min-[1920px]:px-[10vw] mt-8 mb-12">
        <div v-if="isLoading" class="text-center">
            <Loader/>
        </div>
        <div v-if="!isLoading" class="text-center">
            <div class="text-xs xs:text-sm">
                Показано {{ allHotels.length }} из {{ hotels?.meta?.total ?? allHotels.length }}
            </div>
            <div v-if="hotels?.meta?.next_page_url">
                <Button @click="loadMore()" classes="mx-auto mt-3">
                    Показать ещё отели
                </Button>
            </div>            
        </div>
    </div>
    <div v-if="allHotels.length == 0" class="w-full py-8"></div>
    
</template>

<script>
    import { filterStore } from '@/Store/filterStore.js'    
    import { usePage } from '@inertiajs/inertia-vue3'
    import _ from 'lodash'
    import HotelCard from "./HotelCard.vue"
    import Loader from '@/components/ui/Loader.vue'
    import Button from '@/components/ui/Button.vue'
    
    export default {
        components: {
            HotelCard,
            Loader,
            Button,
        },
        props: {
            hotels: {
                type: [Array, Object],
                required: false,                
            },
        },
        mounted() {                 
        },        
        data() {
            return {
                filterStore,                
                allHotels: this.hotels.data ?? [],
                isLoading: false,                                                         
            }
        },
        computed: {
            filters() {
                return _.cloneDeep(this.filterStore.filters);
            },                   
        },
        methods: {
            getData() {                                
                this.$inertia.get(route('hotels.index'), this.filterStore.getFiltersValues(), {
                    preserveState: true,
                    preserveScroll: true,                                       
                });                
            },         
            loadMore() {                
                if (this?.hotels?.meta?.next_page_url) {
                    this.$inertia.get(this.hotels.meta.next_page_url, this.filterStore.getFiltersValues(), {
                        preserveState: true,
                        preserveScroll: true,
                        only: ['hotels'],                                     
                        onSuccess: () => {                            
                            if (this.hotels.meta.current_page != 1)                         
                                this.allHotels = [...this.allHotels, ...this.hotels.data]
                            
                            let url = usePage().url.value;
                            let params = new URLSearchParams(url.substring(url.indexOf("?") + 1));
                            params.delete('page');
                            let newUrl = route('hotels.index') + '?' + params;                            
                            window.history.pushState({}, this.$page.title, newUrl);
                        },
                        onStart: () => {this.isLoading = true},
                        onFinish: () => {this.isLoading = false;},
                    })
                }
            },
        },
        watch: {
            hotels: function (newVal, oldVal) {                
                if (this.hotels.meta.current_page == 1) {                    
                    this.allHotels = this.hotels.data ?? [];
                }                    
            },
            filters: {
                handler(newVal, oldVal) {                                
                    if (!_.isEqual(newVal, oldVal) && (usePage().props.value.modals?.filters ?? false) != true) {                                                
                        this.getData();                      
                    }                    
                },
                deep: true
            },
        }
    }
</script>
