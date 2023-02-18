<template>
    <form @submit.prevent="">
        <div class="mx-[1.625rem] relative z-10 flex flex-col items-center">
            <div class="w-full p-6 bg-[#EAEFFD] rounded-3xl grid grid-cols-2 grid-rows-7 max-[330px]:grid-cols-1 max-[330px]:grid-rows-14 gap-4">            
                <city-select name="city" searchable placeholder="Город" v-model="city" :options-array="filterStore.locationParams.cities"/>                 
                <metro-select name="metro" searchable placeholder="Станция метро" v-model="metro" :options-array="filterStore.locationParams.metros"/>

                <filter-attr-toggle
                    title="Low Cost"
                    img="img/low-cost.svg" toggle-img="img/low-cost2.svg"
                    type="horizontal"
                    attr-model="rooms"
                    filter-key="low_cost"            
                />
                <filter-attr-toggle
                    title="От 1 часа"
                    img="img/hour.svg" toggle-img="img/hour2.svg"
                    type="horizontal"
                    attr-model="rooms"
                    is-attribute
                    attr-id="68"                    
                />                
                <filter-attr-toggle
                    title="Горящие предложения"
                    img="img/flash.svg" toggle-img="img/flash2.svg"
                    type="horizontal"
                    attr-model="rooms"
                    filter-key="is_hot"
                />
                <filter-attr-toggle
                    title="Кешбэк"
                    img="img/cashback.svg" toggle-img="img/cashback2.svg"
                    type="horizontal"
                    disabled
                />
                <filter-attr-toggle
                    title="Арт дизайн"
                    img="img/art.svg" toggle-img="img/art2.svg"
                    type="horizontal"
                    attr-model="rooms"
                    is-attribute
                    attr-id="52"
                />
                <filter-attr-toggle
                    title="Джакузи"
                    img="img/jacuzzi.svg" toggle-img="img/jacuzzi2.svg"
                    type="horizontal"
                    attr-model="rooms"
                    is-attribute
                    attr-id="65"
                />
            </div>
            <div class="md:w-full w-[calc(100%-48px)] h-full px-[16px] md:py-0 pb-[16px] pt-[10px] bg-white rounded-b-[24px] flex md:flex-row flex-col items-center justify-between gap-[16px] md:max-w-none max-w-[400px]">
                <div class="flex items-center justify-center md:gap-[54px] gap-[10px] md:w-initial w-full ">
                    <span class="text-[0.875rem] leading-[16px]">Найдено {{ foundMessage }}</span>
                </div>
                <div class="flex items-center gap-[16px] md:justify-end justify-between md:w-initial w-full flex-wrap ">
                    <Button disabled>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 3V19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M9 5V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M3 3L9 5L15 3L21 5V21L15 19L9 21L3 19V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span class="text-white">На карте</span>
                    </Button>
                    <Button @click="submit()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.85718 7H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M6.85718 12.143H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M6.85718 17.2857H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M3 7V7.01284" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M3 12.143V12.1558" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M3 17.2857V17.2985" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span class="text-white">Списком</span>
                    </Button>                    
                </div>
            </div>
        </div> 
    </form>    
</template>

<script>
    import axios from 'axios' 
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import { filterStore } from '@/Store/filterStore.js'
    import { geolocationStore } from '@/Store/geolocationStore.js'
    import { numWord } from '@/Services/numWord.js'
    import Select from '@/components/ui/Select.vue'
    import Button from '@/components/ui/Button.vue'
    import CitySelect from '@/components/ui/CitySelect.vue'
    import MetroSelect from '@/components/ui/MetroSelect.vue'
    import FilterAttrToggle from '@/components/ui/FilterAttrToggle.vue'
    export default {
        components: {
            Select,
            Button,
            CitySelect,
            MetroSelect,
            FilterAttrToggle,            
        },
        mounted() {
            this.filterStore.init(true); 
            this.locate();            
        },        
        data() {
            return {
                filterStore,
                geolocationStore,              
                form: useForm({}),
                city: null,
                metro: null,                
            }
        },
        computed: {
            geolocationCity() {
                return this.geolocationStore.city;
            },
            foundMessage() {
                return this.filterStore.found + ' ' + numWord(this.filterStore.found, ['предложение', 'предлжения', 'предложений']);
            }
        },
        methods: {                     
            submit() {
                this.form = useForm(                   
                    this.filterStore.getFiltersValues()
                );                          
                this.form.post(route('filter.list'));                
            },
            locate() {
                this.geolocationStore.locate();
            }
        },
        watch: {
            city: {
                handler(newVal, oldVal) {                
                    if (oldVal != newVal) {
                        this.filterStore.removeFilter('hotels', false, 'metro');
                        this.filterStore.updateLocationParams();
                    }                    
                },
                immediate: true
            },
            geolocationCity: {
                handler(newVal, oldVal) {
                    if (newVal && !oldVal) {                                            
                        this.filterStore.updateFilter('hotels', false, 'city', newVal, newVal);                      
                    }
                },
                immediate: true
            }
        }
    }
</script>
