<template>
    <div v-click-outside="hide" class="relative md:static" :class="(collapsed ? 'z-[1]' : 'z-[4]') ">
        <button @click="toggle()" type="button" class="w-full px-[12px] h-[32px] flex items-center bg-white justify-between rounded-[8px]">
            <div class="flex items-center gap-[8px]">
                <svg v-if="type != 'intro'" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.2344 14.231H16.3398L12.6235 5H12.6205L10.1174 10.2206L7.62046 5H7.6174L3.89497 14.231H3.00037V15H8.12598V14.231H7.10882L8.29448 11.3021L10.1174 15L11.9464 11.3021L13.126 14.231H12.1088V15H17.2344V14.231Z" fill="#6170FF"></path>
                </svg>
                <span class="flex items-center text-sm leading-[16px]">{{ selectedOption ?  selectedOption : placeholder }}</span>
            </div>                        
            <svg v-if="!selectedOption" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block" :class="collapsed ? '' : 'rotate-180'">
                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>                 
        </button>
        <div v-if="selectedOption" class="relative">
            <button type="button" @click="clear()" class="px-[12px] h-[32px] select-clear">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        </div>                            
        <div v-if="!collapsed" 
            class="absolute block z-100"
            :class="type == 'intro' ? 'top-[32px] w-[calc(200%+4rem)] max-[330px]:w-[calc(100%+3rem)] right-[-1.5rem]' : 'max-[768px]:top-[32px] max-[768px]:right-[-16px] md:w-[376px] w-[calc(200%+48px)]'">
            <div class="flex items-center justify-between bg-white w-full">
                <div class="bg-[#EAEFFD] h-[16px] rounded-r-[8px]" :class="type == 'intro' ? 'w-[72%] max-[330px]:w-[48%]' : 'md:w-[22%] w-[72%]'"></div>
                <div class="bg-[#EAEFFD] h-[16px] rounded-l-[8px]" :class="type == 'intro' ? 'w-[24%] max-[330px]:w-[48%]' : 'md:w-[73%] w-[24%]'"></div>
            </div>
            <div class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] overflow-y-auto shadow-xl" :class=" type == 'intro' ? 'max-h-[60vh] rounded-[24px] pb-[20px] max-h-[388px]' : 'max-h-[200px] md:max-h-[calc(45vh-144px)] rounded-[8px]' ">
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
    export default {
        directives: {
            clickOutside: vClickOutside.directive
        },
        props: {
            placeholder: String,
            searchable: Boolean,
            optionsArray: Array,
            modelValue: String,            
            type: {
                type: String,
                default: 'intro',
            },                                           
        },        
        data() {
            return {                
                collapsed: true,
                searchValue: '',
                value: null,                                        
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
            selectedOption() {                
                return this.modelValue ?? this.value;
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
                if (this.modelValue != value) {
                    this.emmitUpdate(value);
                    this.value = value;
                }              
                                    
                this.hide();                                               
            },            
            clear() {                
                this.searchValue = '';
                this.emmitUpdate(null);
                this.value = null;
                this.hide();             
            },
            emmitUpdate(value) {                                
                this.$emit('update:modelValue', value);
            },           
        },
        watch: {
            modelValue: function (newVal, oldVal) {
                if (!newVal && oldVal)
                    this.value = newVal;
            }
        }        
    }
</script>
