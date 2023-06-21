<template>
  <div class="bg-slate-200 w-full h-full">
    <img      
      :src="src"
      :class="class"
      alt="img"      
      :loading="lazy ? 'lazy' : 'eager'"
      :width="width"
      :height="height"
    />
  </div>
</template>

<script>
export default {
  props: {
    src: String,
    class: String, 
    lazy: Boolean,
    width: [String, Number],
    height: [String, Number],
  },
};
</script>
