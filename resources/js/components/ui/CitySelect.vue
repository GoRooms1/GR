<template>
    <div v-click-outside="hide" class="relative md:static" :class="classes + ' ' + (collapsed ? 'z-[1]' : 'z-[2]') ">       
        <button @click="toggle()" type="button" class="w-full px-[12px] h-[32px] flex items-center justify-between bg-white rounded-[8px]">
            <span class="text-sm leading-[16px]">{{ selectedOption ?  selectedOption : placeholder }}</span>            
            <svg v-if="collapsed" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block">
                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>                 
        </button>            
        <button v-if="!collapsed" type="button" class="px-[12px] h-[32px] select-clear"> 
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
        <div v-if="!collapsed" class="absolute top-[32px] w-[calc(200%+4rem)] max-[330px]:w-[calc(100%+3rem)] left-[-1.5rem]">
            <div class="flex items-center justify-between bg-white w-full">
                <div class="w-[24%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                <div class="w-[72%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
            </div>
            <div class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[60vh] overflow-y-auto rounded-[24px] pb-[20px] shadow-xl max-h-[388px] ">
                <div v-if="searchable" class="bg-white rounded-t-[8px]">
                    <input type="text" :placeholder="placeholder" v-model="searchValue" class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-sm leading-[16px] " wfd-id="id7">
                </div>
                <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
                    <button v-for="option in options" @click="choose" :data-value="option" type="button" class="text-sm leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                        {{ option }}
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
            classes: String,                                            
        },
        data() {
            return {
                collapsed: true,
                searchValue: '',
                filterStore,                                                               
            }
        },
        emits: ['update:modelValue'],
        computed: {
            options: function() {                                
                if (this.searchValue) {
                    let searchValue = this.searchValue.toLowerCase().trim();
                    return this.optionsArray.filter(function (el) {                 
                        return el.toString().toLowerCase().startsWith(searchValue);               
                    }, searchValue);                   
                }                    
                else {
                    return this.optionsArray ?? [];
                }
            },
            selectedOption: function() {
                return this.filterStore.getFilterValue('hotels', false, 'city') ?? null;
            },
        },
        methods: {
            toggle() {
                this.collapsed = !this.collapsed;
            },
            hide() {
                this.collapsed = true;
            },
            choose(event) {                
                let value = event.target.dataset['value'];
                this.filterStore.updateFilter('hotels', false, 'city', value, value); 
                this.hide();                                              
            },            
            emmitUpdate() {
                this.$emit('update:modelValue', this.selectedOption);
            },                         
        },
        watch: {
            selectedOption: function (newVal, oldVal) {
                if (newVal != oldVal)
                    this.emmitUpdate();
            }
        }

    }
</script>
