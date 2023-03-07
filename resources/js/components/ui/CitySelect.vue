<template>
    <div v-click-outside="hide" class="relative md:static" :class="collapsed ? 'z-[1]' : 'z-[4]'">       
        <button @click="toggle()" type="button" class="w-full px-[12px] h-[32px] flex items-center justify-between bg-white rounded-[8px]">
            <span class="text-sm leading-[16px]">{{ selectedOption ?  selectedOption : placeholder }}</span>            
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="block" :class="collapsed ? '' : 'rotate-180'">
                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>                 
        </button>        
        <div v-if="!collapsed" 
            :class="type == 'intro' ? 'absolute top-[32px] w-[calc(200%+4rem)] max-[330px]:w-[calc(100%+3rem)] left-[-1.5rem]' : 'absolute max-[768px]:top-[32px] max-[768px]:right-[-16px] z-10 md:w-[376px] w-[calc(200%+48px)] block'">
            <div class="flex items-center justify-between bg-white w-full">                
                <div v-if="type == 'intro'" class="w-[24%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                <div v-if="type == 'intro'" class="w-[72%] max-[330px]:w-[48%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>

                <div v-if="type == 'form'" class="md:w-[22%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                <div v-if="type == 'form'" class="md:w-[73%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
            </div>
            <div :class=" type == 'intro' ? 'filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[60vh] overflow-y-auto rounded-[24px] pb-[20px] shadow-xl max-h-[388px]' : 'filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[344px] md:max-h-[calc(45vh)] overflow-y-auto rounded-[8px] shadow-xl' ">
                <div v-if="searchable" class="bg-white rounded-t-[8px]">
                    <input type="text" :placeholder="placeholder" v-model="searchValue" class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-sm leading-[16px] " wfd-id="id7">
                </div>
                <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
                    <button v-for="option in options" @click="choose" :data-value="option.name" type="button" class="text-sm leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                        {{ option.name }}
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
                let value = event.target.dataset['value'];
                if (this.modelValue != value) {
                    this.emmitUpdate(value);
                    this.value = value;
                }
                                    
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
