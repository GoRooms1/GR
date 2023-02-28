<template>
    <button 
        @click="toggle()" class="rounded-[8px]" 
        :class="btnClass + ' ' + (value ? 'bg-[#6170FF] text-white' : (disabled ? 'btn-disabled pointer-events-none bg-slate-200' : 'bg-white'))"
    >
        <img :src="img" :class="imgClass + ' ' + (!value && img ? '' : 'hidden')">
        <img :src="toggleImg" :class="imgClass + ' ' + (value && toggleImg ? '' : 'hidden')">     
        <span :class="titleClass">{{ title }}</span>              
        <slot/>
    </button>
</template>

<script>
    import { filterStore  } from '@/Store/filterStore.js'
    export default {        
        props: {
            title: String,
            img: String,
            toggleImg: String,
            type: String,
            modelValue: [String, Boolean, Number],           
            disabled: Boolean,            
            attrModel: {
                type: String,
                default: 'rooms',
            },
            filterKey: String,
            isAttribute: {
                type: Boolean,
                default: false,
            },
            attrId: String,
        },
        created() {
            this.filterStore.addTitle(this.isAttribute ? this.attrId : this.filterKey, this.title);
            this.emmitUpdate();
        },
        emits: ['update:modelValue'],
        data() {
            return {
                filterStore,                
            }
        },
        computed: {
            titleClass() {
                switch(this.type) {
                    case 'horizontal':
                        return 'flex text-sm'
                        break;
                    case 'vertical':
                        return 'text-[14px] leading-[16px] mt-auto';
                        break;
                    case 'small':
                        return 'text-[14px] leading-[16px] whitespace-nowrap';
                        break;
                    default:
                        return ''
                }
            },
            imgClass() {
                switch(this.type) {
                    case 'horizontal':
                        return 'sm:mr-3 w-[3.5rem]';
                        break;
                    case 'vertical':
                        return 'mt-[19px] max-w-full';
                        break;
                    case 'small':
                        return 'small-icon';
                        break;
                    default:
                        return ''
                }
            },            
            btnClass() {
                switch(this.type) {
                    case 'horizontal':
                        return 'px-[12px] row-span-2 flex items-center text-sm text-left'
                        break;
                    case 'vertical':
                        return 'w-full mt-[16px] pb-[8px] md:flex items-center flex-col justify-center h-[128px]';
                        break;
                    case 'small':
                        return 'px-[12px] h-[32px] flex items-center gap-[8px] justify-center md:hover:outline outline-solid outline-[#6170FF] transition duration-150';
                        break;
                    default:
                        return ''
                }
            },
            value() {
                return this.filterStore.getFilterValue(this.attrModel, this.isAttribute, this.filterKey, this.attrId);
            }
        },
        methods: {
            toggle() { 
                if ( (this.isAttribute && !this.attrId) || (!this.isAttribute && !this.filterKey) )
                    return false;
                if (!this.value) {
                    let value = this.isAttribute ? this.attrId : true;                    
                    this.filterStore.addFilter(this.attrModel, this.isAttribute, this.filterKey, value, this.title);
                }
                else {                    
                    this.filterStore.removeFilter(this.attrModel, this.isAttribute, this.filterKey, this.attrId);
                }
            },
            emmitUpdate() {
                this.$emit('update:modelValue', this.value);
            }
        },
        watch: {
            value: function(newVal, oldVal) {
                if (newVal != oldVal)
                    this.emmitUpdate();
            }
        }
    }
</script>
