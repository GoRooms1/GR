<template>    
    <div class="mx-[1.625rem] relative z-10 flex flex-col items-center">
        <div class="w-full p-6 bg-[#EAEFFD] rounded-3xl grid grid-cols-2 grid-rows-7 max-[330px]:grid-cols-1 max-[330px]:grid-rows-14 gap-4">
            <city-select searchable placeholder="Город" v-model="city" :options-array="filter.cities ?? []"/>                 
            <metro-select searchable placeholder="Станция метро" v-model="metro" :options-array="filter.metros ?? []"/>

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
                <Button @click="getData()">
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
</template>

<script>     
    import { usePage } from '@inertiajs/inertia-vue3'
    import { filterStore } from '@/Store/filterStore.js'    
    import { numWord } from '@/Services/numWord.js'
    import _ from 'lodash'    
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
        props: {
            filter: {
                type: Object,
                default: {},
            }
        },
        created() {
            this.filterStore.init(usePage().url.value);                                   
        },        
        data() {
            return {
                filterStore,
                propsToUpdate: [],
                nonAtrributes: ['city', 'metro'],                               
                city: 'init',
                metro: 'init',                                          
            }
        },
        computed: {            
            foundMessage() {
                return usePage().props.value.total + ' ' + numWord(usePage().props.value.total, ['предложение', 'предлжения', 'предложений']);
            },
            attributes() {
                return _.cloneDeep(_.filter(this.filterStore.filters, el => !this.nonAtrributes.includes(el.key)));
            },       
        },
        methods: {                     
            getData() {
                this.$inertia.get(route('filter'), this.filterStore.getFiltersValues(), {
                    preserveState: true,
                    preserveScroll: true,                   
                });                             
            },            
            updateFilters(only) {
                let data = this.filterStore.getFiltersValues();                
                this.$inertia.get(route('home'), data, {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: only ?? [],                                      
                });
            },            
        },
        watch: {
            city: {
                handler(newVal, oldVal) {       
                    if (oldVal != newVal && oldVal != 'init' && newVal != 'init') {                                         
                        this.filterStore.removeFilter('hotels', false, 'metro');
                        this.updateFilters(['total', 'metros']);                                               
                    }                    
                },                               
            },
            metro: function (newVal, oldVal) {                
                if (oldVal != newVal && newVal != null) {                                     
                    this.updateFilters(['total']);                  
                }
                
                if (oldVal != null && newVal == null) {
                    this.updateFilters(['total', 'metros']);
                }
            },                     
            attributes: {
                handler(newVal, oldVal) {         
                    if (!_.isEqual(newVal, oldVal)) {                       
                        this.updateFilters(['total']);                                             
                    }                    
                },
                deep: true
            },
        }
    }
</script>
