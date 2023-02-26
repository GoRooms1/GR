<template>
    <div v-click-outside="hide" class="relative md:static" :class="classes + ' ' + (collapsed ? 'z-[1]' : 'z-[4]') ">
        <button @click="toggle()" type="button" class="w-full px-[12px] h-[32px] flex items-center justify-between bg-white rounded-[8px]">
            <span class="text-sm leading-[16px]">{{ selectedOption ?  selectedOption : placeholder }}</span>            
            <svg v-if="collapsed" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block">
                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>                 
        </button>            
        <button v-if="!collapsed" type="button" @click="clear()" class="px-[12px] h-[32px] select-clear"> 
            <svg   width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_790_13114)">
                    <path d="M0.999146 0.999203L10.9999 11" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M0.999146 11L10.9999 0.999203" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                </g>
                <defs>
                    <clipPath id="clip0_790_13114">
                        <rect width="12" height="12" fill="white"></rect>
                    </clipPath>
                </defs>
            </svg>
        </button>                     
        <div v-if="!collapsed" 
            :class="type == 'intro' ? 'absolute top-[32px] w-[calc(200%+4rem)] max-[330px]:w-[calc(100%+3rem)] right-[-1.5rem] block' : 'absolute max-[768px]:top-[32px] max-[768px]:right-[-16px] z-100 md:w-[376px] w-[calc(200%+48px)]'">
            <div class="flex items-center justify-between bg-white w-full">
                <div v-if="type == 'intro'" class="w-[72%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                <div v-if="type == 'intro'" class="w-[24%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>

                <div v-if="type == 'form'" class="md:w-[22%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                <div v-if="type == 'form'" class="md:w-[73%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
            </div>
            <div :class=" type == 'intro' ? 'filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[60vh] overflow-y-auto rounded-[24px] pb-[20px] shadow-xl max-h-[388px]' : 'filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[200px] md:max-h-[calc(45vh-144px)] overflow-y-auto rounded-[8px] shadow-xl' ">
                <div v-if="searchable" class="bg-white rounded-t-[8px]">
                    <input type="text" :placeholder="placeholder" v-model="searchValue" class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-sm leading-[16px] " wfd-id="id7">
                </div>
                <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
                    <button v-for="option in options" @click="choose" :data-key="option.name" class="text-sm leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.2341 12.231H16.3395L12.6232 3H12.6201L10.117 8.22059L7.6201 3H7.61703L3.89461 12.231H3V13H8.12561V12.231H7.10846L8.29412 9.30208L10.117 13L11.9461 9.30208L13.1256 12.231H12.1085V13H17.2341V12.231Z" :fill="'#' + option.color "></path>
                        </svg>
                        <span class="p-[16px]">{{ option.name }}</span>                                                
                    </button>
                </div>
                <div v-if="options.length == 0">
                    <span class="p-[16px]">Совпаденйи не найдено</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vClickOutside from "click-outside-vue3"
    import { filterStore  } from '@/Store/filterStore.js'
    export default {
        directives: {
            clickOutside: vClickOutside.directive
        },
        props: {
            placeholder: String,
            searchable: Boolean,
            optionsArray: Array,
            modelValue: String, 
            classes: String, 
            type: {
                type: String,
                default: 'intro',
            },                                           
        },
        created() {
            this.emmitUpdate();
        },
        data() {
            return {
                filterStore,
                collapsed: true,
                searchValue: '',                                         
            }
        },
        computed: {
            options: function() {                                
                if (this.searchValue) {
                    let searchValue = this.searchValue.toLowerCase().trim();
                    return this.optionsArray.filter(function (el) {                 
                        return el.name.toString().toLowerCase().startsWith(searchValue);                 
                    }, searchValue);                   
                }                    
                else {
                    return this.optionsArray ?? [];
                }
            },
            selectedOption: function() {
                return this.filterStore.getFilterValue('hotels', false, 'metro') ?? null;
            }
        },
        emits: ['update:modelValue'],
        methods: {
            toggle() {
                this.collapsed = !this.collapsed;
            },
            hide() {
                this.collapsed = true;
            },
            choose(event) {                
                let value = event.currentTarget.dataset['key'];
                this.filterStore.updateFilter('hotels', false, 'metro', value, value);
                this.hide();                                               
            },            
            clear() {                
                this.searchValue = '';                 
                this.filterStore.removeFilter('hotels', false, 'metro');
                this.hide();             
            },
            emmitUpdate() {
                this.$emit('update:modelValue', this.selectedOption);
            },            
        },
        watch: {
            selectedOption: function(newVal, oldVal) {
                if (oldVal != newVal)
                    this.emmitUpdate();        
            }
        }
    }
</script>
