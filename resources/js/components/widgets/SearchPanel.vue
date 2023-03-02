<template>
   <div id="seach-panel" class="z-[11] max-w-[832px] w-full mx-auto px-[16px] md:pt-[64px] pt-[32px] md:pb-[52px] pb-[24px] transition">
        <div class="relative">
            <div data="search-input" class="shadow-xl w-full bg-white md:rounded-t-[16px] rounded-t-[24px]  md:rounded-b-none rounded-b-[24px] md:p-[8px] p-0  px-[8px] py-[12px] flex items-center">
                <button class="p-[8px]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M19.9999 20L15.8032 15.8033" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                <input disabled type="text" class="bg-transparent p-[8px] grow text-[16px] leading-[19px] text-ellipsis whitespace-nowrap overflow-hidden placeholder:text-[#A7ABB7] text-[#515561] text-[1rem]" placeholder="Название отеля, адрес, метро, округ, район, город" wfd-id="id11">
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
            <div data="search-input-content" class="absolute z-[11] w-[75%] max-[768px]:w-full flex hidden flex-col py-3 px-4 bg-white rounded-b-[24px] cursor-default scrollbar overflow-y-auto max-h-[60vh] gap-[8px] max-[768px]:text-[0.8125rem] shadow-xl">
                <div class="px-2.5 py-1.5 font-semibold"></div>
                <button class="whitespace-nowrap flex px-2 py-1.5 pl-[40px] rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] cursor-pointer relative"><img src="" class="absolute inset-y-[11px] left-[13px]">
                    <div class="whitespace-nowrap mr-auto"></div>
                </button>
            </div>
            <div class="md:flex justify-between hidden">
                <div class="p-[8px] flex items-center gap-[8px]">
                    <filter-attr-toggle
                        title="Low Cost"
                        type="small"
                        attr-model="rooms"
                        filter-key="low_cost"            
                    />
                    <filter-attr-toggle
                        title="От 1 часа"
                        type="small"
                        attr-model="rooms"
                        is-attribute
                        attr-id="68"                    
                    />                
                    <filter-attr-toggle
                        title="Горящие предложения"
                        type="small"
                        attr-model="rooms"
                        filter-key="is_hot"
                    />
                    <filter-attr-toggle
                        title="Кешбэк"
                        type="small"
                        disabled
                    />
                    <filter-attr-toggle
                        title="Арт дизайн"
                        type="small"
                        attr-model="rooms"
                        is-attribute
                        attr-id="52"
                    />
                    <filter-attr-toggle
                        title="Джакузи"
                        type="small"
                        attr-model="rooms"
                        is-attribute
                        attr-id="65"
                    />
                </div>
                <div class="p-[8px]">
                    <button @click="openFilters()" class="flex items-center gap-[16px] p-[8px]">
                        <span class="text-[14px] leading-[16px] whitespace-nowrap">Больше фильтров</span>
                        <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.83301 13.0002L5.99967 17.1669L10.1663 13.0002" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M10.167 7.16692L6.00033 3.00025L1.83366 7.16692" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="md:p-[8px] p-0 pt-[8px] flex items-center gap-[8px] flex-wrap">
                <filter-tag 
                    v-for="tag in filterStore.filters"
                    :title="tag.title"
                    :attr-model="tag.modelType"
                    :filter-key="tag.key"
                    :is-attribute="tag.isAttribute"
                    :filter-value="tag.value"                        
                />
            </div>
        </div>
    </div>
</template>

<script>
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import { filterStore  } from '@/Store/filterStore.js'    
    import FilterAttrToggle from '@/components/ui/FilterAttrToggle.vue'
    import FilterTag from '@/components/ui/FilterTag.vue'
    
    export default {
        components: {
            FilterAttrToggle,
            FilterTag,
        },
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
                    only: ['hotels', 'rooms'],                                  
                    //onSuccess: () => {},
                    onStart: () => {usePage().props.value.isLoadind = true},
                    onFinish: () => {usePage().props.value.isLoadind = false},
                });
                this.closeFilters();
            },
            openFilters() {
                usePage().props.value.modals.filters = true;
            },
            closeFilters() {
                usePage().props.value.modals.filters = false;
            }
        }

    }
</script>
