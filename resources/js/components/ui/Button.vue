<template>
  <button
    v-bind="$attrs"
    type="button"
    class="h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150"
    :class="classes + ' ' + style"
  >
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    classes: String,
    disabled: Boolean,
    type: {
      type: String,
      default: 'blue'
    }
  },
  computed: {
    style() {
      if (this.disabled)
        return 'bg-slate-400 pointer-events-none';

      switch (this.type) {
        case "blue":
          return 'bg-blue-500 hover:bg-blue-800';
          break;
        case "red":
          return 'bg-red-500 hover:bg-red-800';
          break;        
        default:
          return 'bg-blue-500 hover:bg-blue-800';
      }
    },
  }
};
</script>
