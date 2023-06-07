<template>
  <div class="bg-slate-200 w-full h-full">
    <img      
      :src="src"
      :class="class"
      alt="img"      
      :loading="lazy ? 'lazy' : 'eager'"
    />
  </div>
</template>

<script>
export default {
  props: {
    src: String,
    class: String, 
    lazy: Boolean, 
  },
};
</script>
