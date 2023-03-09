<template>
    <div class="grid gap-[16px]">
        <filter-select
            :options-array="options"
            not-null
            v-model="type"
        />
        <button            
            v-for="range in ranges"
            :data-key="range.key" :data-type="range.type_key"
            :data-name="range.type_name + ': ' + range.name"         
            class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between md:hover:outline outline-solid outline-[#6170FF] transition duration-150"
            :class="selectedOption == range.type_key + '_' + range.key ? 'bg-[#6170FF] text-white' : 'bg-white'"
            @click="toggle"
        >
            <span class="text-[14px] leading-[16px]">{{ range.name }}</span>
        </button>
        
        
    </div>
    
</template>

<script>
import FilterSelect from '@/components/ui/FilterSelect.vue'
    export default {
        components: {
            FilterSelect
        },
        props: {
            options: Array,
            modelValue: {
                type: [String],
                default: null,
            },
        },
        emits: ['update:modelValue'],
        mounted() {
            if (this.selectedOption)
                this.type = this.selectedOption.split('_')[0]; 
            else
            this.type = this.options[0].key;                  
        },
        data() {
            return {
                type: null,
                value: null,            
            }
        },
        computed: {
            ranges() {
                let result = [];
                this.options.forEach(type => {                    
                    let type_key = type.key;
                    let type_name = type.name; 
                    if (this.type && type_key != this.type)
                        return;                 
                    type.cost_ranges.forEach(range => {                        
                        range.type_key = type_key;
                        range.type_name = type_name;
                        result.push(range);
                    });
                });
                return result;
            }, 
            selectedOption() {
                return this.modelValue ?? this.value;
            }
        },
        methods: {
            toggle(event) {                                
                let value = event.currentTarget.dataset['type'] + '_' + event.currentTarget.dataset['key']; 
                console.log();               
                if (this.selectedOption == value) {
                    this.value = null;                    
                } else {
                    this.value = value;
                }                 
                this.emmitUpdate(this.value);
            },
            emmitUpdate(value) {                
                this.$emit('update:modelValue', value);
            }
        },
        watch: {
            type: function(newVal, oldVal) {                                
                if (newVal != oldVal && oldVal != null) {
                    this.value = null;
                    this.emmitUpdate(this.value);
                }
            },
            modelValue: function (newVal, oldVal) {
                if (!newVal && oldVal) {
                    this.value = newVal;
                }                    
            }
        }
        
    }
</script>
