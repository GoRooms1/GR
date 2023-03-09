<template>
    <div v-if="isOpen" class="items-center justify-center fixed top-0 left-0 z-40 bg-[#D2DAF0B3] w-full h-[100vh] overflow-hidden backdrop-blur-[2.5px] flex">
        <div class="flex flex-grow flex-col lg:gap-[8px] gap-[32px] max-w-[890px] w-full pb-[15px] md:overflow-hidden max-[768px]:pb-[40px] max-[768px]:pt-[40px] pt-[15px] overflow-x-hidden scrollbar overflow-y-auto md:px-[20px] px-0 h-[100%] relative ">
            <button @click="close()" class="absolute right-0 max-[768px]:right-[10px] top-[15px] max-[768px]:top-0 w-[32px] h-[32px] md:bg-white bg-transparent rounded-[8px] flex items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L15 15" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M1 15L15 1" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </button>
            <!-- <search-panel/> -->
            <div class="max-w-[832px] w-full mx-auto px-[16px]">
                <div class="lg:block flex flex-col relative">
                    <div data="search-input" class="w-full bg-white lg:rounded-t-[16px] rounded-t-[24px]  lg:rounded-b-none rounded-b-[24px] lg:p-[8px] p-0  px-[8px] py-[12px] flex items-center">
                        <button class="p-[8px]">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19.9999 20L15.8032 15.8033" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        <input type="text" class="bg-transparent p-[8px] grow text-[16px] leading-[19px] text-ellipsis whitespace-nowrap overflow-hidden placeholder:text-[#A7ABB7] text-[#515561] text-[1rem]" placeholder="Название отеля, адрес, метро, округ, район, город" wfd-id="id6">
                        <div class="md:flex hidden items-center gap-[8px]">
                            <button class="flex items-center gap-[8px] bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 3V19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M9 5V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 3L9 5L15 3L21 5V21L15 19L9 21L3 19V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="text-white">На карте</span>
                            </button>
                            <button @click="getData()" class="flex items-center gap-[8px] bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.85718 7H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6.85718 12.143H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6.85718 17.2857H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 7V7.01284" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 12.143V12.1558" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 17.2857V17.2985" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="text-white">Списком</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between ordering">
                        <div class="lg:p-[8px] p-[24px] bg-[#EAEFFD] rounded-b-[16px] lg:rounded-t-none lg:w-[fit-content] w-full rounded-t-[16px] items-center gap-[8px] flex-wrap justify-center flex">
                            <filter-attr-toggle
                                title="Low Cost"
                                type="small"
                                initial-value=true                                        
                                v-model="low_cost"            
                            />
                            <filter-attr-toggle
                                title="От 1 часа"
                                type="small"
                                :initial-value="68"
                                :model-value="filterStoreCopy?.getFilterValue('rooms', 'attr_68')"
                                @update:modelValue="(event) => attributeHandler('rooms', event, 68)"                                           
                            />                
                            <filter-attr-toggle
                                title="Горящие"
                                type="small"
                                initial-value=true                                        
                                v-model="is_hot"
                            />
                            <filter-attr-toggle
                                title="Кешбэк"
                                type="small"
                                disabled
                            />
                            <filter-attr-toggle
                                title="Арт дизайн"
                                type="small"
                                :initial-value="52"
                                :model-value="filterStoreCopy?.getFilterValue('rooms', 'attr_52')"
                                @update:modelValue="(event) => attributeHandler('rooms', event, 52)"                        
                            />
                            <filter-attr-toggle
                                title="Джакузи"
                                type="small"
                                :initial-value="65"
                                :model-value="filterStoreCopy?.getFilterValue('rooms', 'attr_65')"
                                @update:modelValue="(event) => attributeHandler('rooms', event, 65)"                        
                            />
                        </div>
                        <!-- <div class="lg:block hidden p-[8px] bg-[#EAEFFD] rounded-b-[16px]">
                            <button class="flex items-center gap-[16px] p-[8px]">
                                <span class="text-[14px] leading-[16px] whitespace-nowrap">Больше фильтров</span>
                                <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.83301 13.0002L5.99967 17.1669L10.1663 13.0002" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M10.167 7.16692L6.00033 3.00025L1.83366 7.16692" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div> -->
                    </div>
                    <div class="md:p-[8px] p-0 pt-[8px] flex items-center gap-[8px] flex-wrap lg:mb-0 mb-[32px]">
                        <filter-tag 
                            v-for="tag in filterStoreCopy?.filters ?? []"
                            :filter-model="tag.modelType"
                            :filter-key="tag.key"
                            :is-attribute="tag.isAttribute"
                            :filter-value="tag.value"
                            :removable="tag.key == 'city' ? false : true"
                            @tag-closed="(event) => closeTag(event)"                       
                        />					
                    </div>
                </div>
            </div>            
           
            <div class="max-w-[832px] mx-auto w-full px-[16px] max-[768px]:mb-[40px] md:h-full" >
                <div class="max-h-auto max-w-[820px] bg-transparent" >
                    <div class="bg-[#EAEFFD] rounded-t-[16px] max-w-[800px] w-full md:rounded-b-none rounded-b-[16px] scrollbar overflow-y-auto" :style="'max-height: '+windowHeight+'px;'">
                        <p class="px-[16px] py-[15px] text-[16px] leading-[19px] font-semibold">Фильтры</p>
                        <div class="grid md:grid-cols-4 grid-cols-2  gap-[16px] p-[16px] bg-[#EAEFFD] shadow-sm">
                            <div class="">
                                <p class="text-[14px] leading-[16px] mb-[8px]">Тип заведения</p>
                                <filter-select 
                                    :options-array="$page.props.hotel_types ?? []" 
                                    placeholder="Все"
                                    left
                                    v-model="hotel_type"
                                />                                
                                <div class="hidden md:flex w-full">
                                    <filter-attr-toggle
                                        title="Горящие предложения"
                                        img="img/flash.svg" toggle-img="img/flash2.svg"
                                        type="vertical"
                                        initial-value=true                                        
                                        v-model="is_hot"                
                                    />
                                </div>                                                                                        
                            </div>
                            <div class="">
                                <p class="text-[14px] leading-[16px] mb-[8px]">Рейтинг</p>                                
                                <rating-select/>
                                <div class="hidden md:flex w-full">
                                    <filter-attr-toggle
                                        title="Кешбэк"
                                        img="img/cashback.svg" toggle-img="img/cashback2.svg"
                                        type="vertical"                                        
                                        disabled              
                                    />
                                </div>
                                
                            </div>
                            <div>
                                <p class="text-[14px] leading-[16px] mb-[8px]">Расположение</p>
                                <div class="grid gap-[16px]">
                                  
                                    <city-select 
                                        type="form" 
                                        searchable 
                                        placeholder="Город" 
                                        v-model="city" 
                                        :options-array="$page.props.cities ?? []"                                                                          
                                    />

                                    <city-area-select                                         
                                        placeholder="Округ"
                                        v-model="city_area"
                                        searchable                                        
                                        :options-array="$page.props.city_areas ?? []"                                        
                                    />
                                    
                                    <city-area-select                                         
                                        placeholder="Район"
                                        v-model="city_district"
                                        searchable                                        
                                        :options-array="$page.props.city_districts ?? []"                                        
                                    />
                                    
                                    <metro-select 
                                        type="form" 
                                        searchable 
                                        placeholder="Станция метро" 
                                        v-model="metro" 
                                        :options-array="$page.props.metros ?? []"
                                    />

                                </div>
                            </div>
                            <div class="md:col-start-4 md:row-start-1 col-start-1 row-start-2">
                                <p class="text-[14px] leading-[16px] mb-[8px]">Период</p>                                                             
                                <period-cost-select 
                                    :options="$page.props.cost_types"
                                    v-model="period_cost"
                                />
                            </div>
                            <div class="col-span-2 md:hidden grid gap-[16px]">
                                <filter-attr-toggle
                                    title="Программа кешбэк"
                                    img="img/cashback.svg" toggle-img="img/cashback2.svg"
                                    type="small"                                    
                                    disabled                   
                                />
                                <filter-attr-toggle
                                    title="Горящие предложения"
                                    img="img/flash.svg" toggle-img="img/flash2.svg"
                                    type="small"
                                    initial-value=true                                        
                                    v-model="is_hot"                   
                                />                                
                            </div>
                        </div>                                               
                        <filter-collapse title="Детально об отеле">
                            <div v-for="category in $page.props.attribute_categories">
                                <div v-if="$page.props.attributes.filter(el => el.category == 'hotel' && el.attribute_category_id == category.id).length > 0">
                                    <span class="inline-block md:pt-[16px] pt-0 md:px-[16px] px-[24px] text-[16px] leading-[19px]">{{ category.name }}</span>
                                    <div class="flex flex-wrap md:p-[8px] p-[16px]">
                                        <div v-for="attribute in $page.props.attributes.filter(el => el.category == 'hotel' && el.attribute_category_id == category.id)" :key="attribute" class="m-[8px]">
                                            <filter-attr-toggle
                                                :title="attribute.name"                                    
                                                type="small"
                                                :initial-value="attribute.id"
                                                :model-value="filterStoreCopy?.getFilterValue('hotels','attr_'+attribute.id)"
                                                @update:modelValue="(event) => attributeHandler('hotels', event, attribute.id)"                                                              
                                            />
                                        </div>                                
                                    </div>
                                </div>                                
                            </div>                                                        
                        </filter-collapse>
                        
                        <filter-collapse title="Детально о номере">
                            <div v-for="category in $page.props.attribute_categories">                               
                                <div v-if="$page.props.attributes.filter(el => el.category == 'room' && el.attribute_category_id == category.id).length > 0">
                                    <span class="inline-block md:pt-[16px] pt-0 md:px-[16px] px-[24px] text-[16px] leading-[19px]">{{ category.name }}</span>
                                    <div class="flex flex-wrap md:p-[8px] p-[16px]">
                                        <div v-for="attribute in $page.props.attributes.filter(el => el.category == 'room' && el.attribute_category_id == category.id)" class="m-[8px]">
                                            <filter-attr-toggle
                                                :title="attribute.name"                                    
                                                type="small"
                                                :initial-value="attribute.id"
                                                :model-value="filterStoreCopy?.getFilterValue('rooms', 'attr_'+attribute.id)"
                                                @update:modelValue="(event) => attributeHandler('rooms', event, attribute.id)"                  
                                            />
                                        </div>                                
                                    </div>
                                </div>                                
                            </div>                                                                                  
                        </filter-collapse>                     
                    </div>
                </div>
                <div class="bg-transparent md:h-[80px] h-auto w-full flex items-center justify-center">
                    <div class="md:w-full w-[calc(100%-48px)] h-full px-[16px] md:py-0 py-[16px] bg-white rounded-b-[24px] flex md:flex-row flex-col items-center justify-between gap-[16px] md:max-w-none max-w-[400px]">
                        <div class="flex items-center justify-between md:gap-[54px] gap-[10px] md:w-initial w-full ">
                            <span class="text-[14px] leading-[16px] font-semibold">Найдено {{ foundMessage  ?? 0 }}</span>
                            <button @click="clearFilters()" class="text-[14px] leading-[16px] underline">Очистить фильтры</button>
                        </div>
                        <div class="flex items-center gap-[8px] md:justify-end justify-between md:w-initial w-full flex-wrap ">
                            <button class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 3V19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M9 5V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 3L9 5L15 3L21 5V21L15 19L9 21L3 19V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="text-white">На карте</span>
                            </button>
                            <button @click="getData()" class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.85718 7H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6.85718 12.143H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6.85718 17.2857H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 7V7.01284" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 12.143V12.1558" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 17.2857V17.2985" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="text-white">Списком</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</template>

<script>
    import SearchPanel from "@/components/widgets/SearchPanel.vue"    
    import { usePage } from '@inertiajs/inertia-vue3'
    import { filterStore } from '@/Store/filterStore.js'    
    import { numWord } from '@/Services/numWord.js'
    import _ from 'lodash'
    import FilterSelect from '@/components/ui/FilterSelect.vue'
    import Button from '@/components/ui/Button.vue'
    import CitySelect from '@/components/ui/CitySelect.vue'
    import CityAreaSelect from '@/components/ui/CityAreaSelect.vue'
    import CityDistrictSelect from '@/components/ui/CityDistrictSelect.vue'
    import MetroSelect from '@/components/ui/MetroSelect.vue'
    import RatingSelect from '@/components/ui/RatingSelect.vue'
    import PeriodCostSelect from '@/components/ui/PeriodCostSelect.vue'
    import FilterAttrToggle from '@/components/ui/FilterAttrToggle.vue'
    import FilterTag from '@/components/ui/FilterTag.vue'
    import FilterCollapse from '@/components/ui/FilterCollapse.vue'    

    let filterGetSetObj = function (model, key) {
        return {
                get() {                                           
                    return this.filterStoreCopy?.getFilterValue(model, key);
                },
                set(val) {
                    if (val)    
                        this.filterStoreCopy.updateFilter(model, false, key, val);                    
                    if (val === null)
                        this.filterStoreCopy.removeFilter(model, key);
                }
            }
    };

    let filterWatchUpdate = function (newVal, oldVal) {                
        if (oldVal != newVal) {                                     
            this.updateFilters(['total']);                  
        }
    };

    export default {
        components: {
            SearchPanel,
            FilterSelect,
            Button,
            CitySelect,
            CityAreaSelect,
            MetroSelect,
            PeriodCostSelect,
            FilterAttrToggle,
            FilterTag,
            FilterCollapse,
            RatingSelect
        },       
        mounted() {
            this.filterStore.init(usePage().url.value);
            this.filterStoreCopy = _.cloneDeep(this.filterStore);                     
        },        
        data() {
            return {
                filterStore,
                initialUrl: usePage().url.value,                
                filterStoreCopy: _.cloneDeep(this.filterStore),                                                           
            }
        },
        computed: {
            isOpen() {
                return usePage().props.value.modals?.filters ?? false;
            },           
            foundMessage() {
                return usePage().props.value.total + ' ' + numWord(usePage().props.value.total, ['предложение', 'предлжения', 'предложений']);
            },
            windowHeight() {
                return window.innerHeight - 300;
            }, 
            hotel_type: filterGetSetObj('hotels', 'hotel_type'),           
            city: filterGetSetObj('hotels', 'city'),
            metro: filterGetSetObj('hotels', 'metro'),                        
            city_area: filterGetSetObj('hotels', 'city_area'),
            city_district: filterGetSetObj('hotels', 'city_district'),
            period_cost: filterGetSetObj('rooms', 'period_cost'),
            is_hot: filterGetSetObj('rooms', 'is_hot'),
            low_cost: filterGetSetObj('rooms', 'low_cost'),                 
        },
        methods: {
            close() {                              
                window.history.pushState({}, this.$page.title, this.initialUrl);
                this.filterStoreCopy.filters = _.cloneDeep(this.filterStore.filters);               
                usePage().props.value.modals.filters = false;
                document.body.classList.remove("fixed");                                           
            },                                       
            getData() {
                this.filterStore.filters = _.cloneDeep(this.filterStoreCopy.filters);                                
                this.$inertia.get(route('filter'), this.filterStore.getFiltersValues(), {
                    preserveState: true,
                    preserveScroll: true,
                    onStart: () => {usePage().props.value.isLoadind = true},
                    onFinish: () => {usePage().props.value.isLoadind = false},                                       
                });
                this.close();
            },
            updateFilters(only) {
                let data = this.filterStoreCopy.getFiltersValues();                          
                this.$inertia.get(route(route().current()), data, {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: only ?? [],                   
                });
            },
            clearFilters() {                
                this.filterStoreCopy.clearFilters();
                this.updateFilters(['total']);
            },            
            attributeHandler(modelType, filterValue, attrID) {                
                if (filterValue == null)
                    this.filterStoreCopy.removeFilter(modelType, 'attr_'+attrID);
                else
                    this.filterStoreCopy.addFilter(modelType, true, 'attr_'+attrID, attrID);

                this.updateFilters(['total']);
            },
            closeTag(obj) {                
                this.filterStoreCopy.removeFilter(obj.modelType, obj.key);
                this.updateFilters(['total']);
            },                  
        },
        watch: {
            isOpen: function (newVal, oldVal) {
                if (newVal == true && (!oldVal || oldVal == false)) {                                           
                    this.initialUrl = usePage().url.value;                        
                    this.filterStoreCopy.filters = _.cloneDeep(this.filterStore.filters);
                    document.body.classList.add("fixed");                       
                }                    
            },
            city: function(newVal, oldVal) {       
                    if (oldVal != newVal) {
                        this.metro = null;
                        this.city_area = null;
                        this.city_district = null;                        
                        this.updateFilters(['total', 'metros', 'city_areas', 'city_districts']);                                               
                    }                    
            },
            city_area: function (newVal, oldVal) {
                if (oldVal != newVal && newVal != null) {
                    this.city_district = null;                                    
                    this.updateFilters(['total', 'city_districts']);                  
                }
                
                if (oldVal != null && newVal == null) {                    
                    this.updateFilters(['total', 'metros', 'city_areas', 'city_districts']);
                }
            },
            city_district: function (newVal, oldVal) {                
                if (oldVal != newVal && newVal != null) {                                    
                    this.updateFilters(['total']);                  
                }
                
                if (oldVal != null && newVal == null) {
                    this.updateFilters(['total', 'metros', 'city_areas', 'city_districts']);
                }
            },
            metro: function (newVal, oldVal) {                
                if (oldVal != newVal && newVal != null) {                                     
                    this.updateFilters(['total']);                  
                }
                
                if (oldVal != null && newVal == null) {
                    this.updateFilters(['total', 'metros', 'city_areas', 'city_districts']);
                }
            },
            hotel_type: filterWatchUpdate,
            period_cost: filterWatchUpdate,
            is_hot: filterWatchUpdate,
            low_cost: filterWatchUpdate,                          
        }
    }
</script>

<style>
.ordering {
    order: 3
}
</style>