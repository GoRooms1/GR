<template>
   <div class="shadow-sm bg-[#EAEFFD] md:rounded-b-none rounded-b-[16px]">
        <button @click="toggle" class="flex items-center justify-between md:px-[16px] px-[24px] md:py-[14px] py-[24px] w-full">
            <p class="text-[16px] leading-[19px] font-semibold">{{ title }}</p>
            <div v-if="collapsed == true">
                <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.83301 13.0002L5.99967 17.1669L10.1663 13.0002" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.167 7.16692L6.00033 3.00025L1.83366 7.16692" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <div v-if="collapsed == false">
                <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.1667 17.1668L6.00002 13.0001L1.83335 17.1668" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M1.83386 2.99982L6.00053 7.16648L10.1672 2.99982" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
        </button>
        <div class="overflow-hidden">
            <slot v-if="collapsed != true"/>
        </div>       
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
        },
        data() {
            return {
                collapsed: true,
            }
        },
        methods: {
            toggle() {
                this.collapsed = !this.collapsed;
            }
        }        
    }
</script>
