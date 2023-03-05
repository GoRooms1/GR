<template>
    <div v-click-outside="hide" class="relative md:static" :class="collapsed ? 'z-[1]' : 'z-[5]'">
        <button @click="toggle()" class="w-full px-[12px] h-[32px] flex items-center justify-between bg-white rounded-[8px]" 
            :class="(options.length == 0 && !searchable) ? 'btn-disabled pointer-events-none' : ''"
        >
            <span class="text-sm leading-[16px]">{{ getOptionName(selectedOption?.key) ?? placeholder }}</span>            
            <svg v-if="selectedOption?.key == null || notNull == true" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block" :class="collapsed ? '' : 'rotate-180'">
                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>                 
        </button>            
        <div v-if="selectedOption?.key && notNull == false" class="relative">
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
        <div v-if="!collapsed" class="absolute max-[768px]:top-[32px] max-[768px]:right-[-16px] z-100 md:w-[376px] w-[calc(200%+48px)]">
            <div class="flex items-center justify-between bg-white w-full">               
                <div class="md:w-[22%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                <div class="md:w-[73%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
            </div>
            <div class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[296px] md:max-h-[calc(45vh-48px)] overflow-y-auto rounded-[8px] shadow-xl">
                <div v-if="searchable" class="bg-white rounded-t-[8px]">
                    <input type="text" :placeholder="placeholder" v-model="searchValue" class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-sm leading-[16px] ">
                </div>
                <button v-for="option in options" @click="choose" :data-key="option.key" :data-name="option.name" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                    {{ option.name }}
                </button>
                <div v-if="options.length == 0 && searchable">
                    <span class="p-[16px]">Совпаденйи не найдено</span>
                </div>               
            </div>
        </div>
    </div>
</template>

<script>
    import vClickOutside from "click-outside-vue3"
    import _ from 'lodash'    
    export default {
        directives: {
            clickOutside: vClickOutside.directive
        },
        props: {
            placeholder: String,
            searchable: Boolean,
            notNull: {
                type: Boolean,
                default: false,
            },           
            optionsArray: Array,
            modelValue: {
                type: Object,
                default: null,
            },
            left: {
                type: Boolean,
                default: true,
            }                                                                            
        },        
        data() {
            return {                                            
                collapsed: true,
                searchValue: '',
                value: null,                                         
            }
        },        
        emits: ['update:modelValue'],
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
        methods: {
            toggle() {
                this.collapsed = !this.collapsed;
            },
            hide() {
                this.collapsed = true;
            },
            choose(event) {                
                let value = {
                    key: event.currentTarget.dataset['key'],
                    name: event.currentTarget.dataset['name']
                };
                if (!_.isEqual(value, this.modelValue)) {
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
            getOptionName(key) {
                return this.optionsArray.find(el => el.key == key)?.name ?? key;
            },
            emmitUpdate(value) {
                this.$emit('update:modelValue', value);
            }     
        },
        watch: {
            modelValue: function (newVal, oldVal) {
                if (!newVal && oldVal)
                    this.value = newVal;
            }
        }        
    }
</script>
