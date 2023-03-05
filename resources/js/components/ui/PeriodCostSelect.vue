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
            :class="selectedOption?.key == range.type_key + '_' + range.key ? 'bg-[#6170FF] text-white' : 'bg-white'"
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
                type: Object,
                default: null,
            },
        },
        emits: ['update:modelValue'],
        mounted() {            
            let type = this.selectedOption?.key.split('_')[0] ?? this.options[0]?.key;
            if (type) {
                    this.type = {
                    key: type,
                };
            }           
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
                    if (this.type?.key && type_key != this.type.key)
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
                let value = {                    
                    key: event.currentTarget.dataset['type'] + '_' + event.currentTarget.dataset['key'],
                    name: event.currentTarget.dataset['name']
                };                
                if (this.selectedOption?.key == value?.key) {
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
