<template>
    <button v-bind="$attrs" class="h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150"
        :class="classes + ' ' + (disabled ? 'bg-slate-400 pointer-events-none' : 'bg-blue-500 hover:bg-blue-800 ')">
        <slot/>
    </button>
</template>

<script>
export default {
    props: {       
        classes: String,
        disabled: Boolean,        
    }
}
</script>
