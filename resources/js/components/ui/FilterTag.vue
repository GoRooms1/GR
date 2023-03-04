<template>
    <div class="flex items-center gap-[8px] rounded-[10px] bg-[#3B24C6] h-[32px] px-[12px] w-[fit-content]">
        <span class="text-white text-[12px] leading-[14px] whitespace-nowrap">{{ title }}</span>
        <button type="button" @click="close()" v-if="isRemovable()">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_791_56790)">
                    <path d="M0.999268 0.999207L11.0001 11" stroke="white" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M0.999268 11L11.0001 0.999207" stroke="white" stroke-width="2" stroke-linecap="round"></path>
                </g>
                <defs>
                    <clipPath id="clip0_791_56790">
                        <rect width="12" height="12" fill="white"></rect>
                    </clipPath>
                </defs>
            </svg>
        </button>
    </div>
</template>

<script>
    import { filterStore  } from '@/Store/filterStore.js'
    import { usePage } from '@inertiajs/inertia-vue3'
    export default {
        props: {
            title: String,                
            attrModel: String,
            filterKey: String,
            isAttribute: {
                type: Boolean,
                default: false,
            },
            filterValue: [String, Number, Boolean],
            initialFilterStore: Object,
        },
        created() {
            this.customfilterStore = this.initialFilterStore ?? this.filterStore;
        },
        data() {
            return {
                filterStore,
                customfilterStore: this.initialFilterStore ?? this.filterStore,
            }
        },
        methods: {
            close() {
                if (this.isRemovable()) {
                    this.customfilterStore.removeFilter(this.attrModel, this.isAttribute, this.filterKey, this.filterValue);
                }
            },
            isRemovable() {
                return !filterStore.notRemovableFilters.includes(this.filterKey);
            }
        }
    }
</script>
