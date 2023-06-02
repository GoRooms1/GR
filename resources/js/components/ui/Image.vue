<template>
  <div class="bg-slate-200 w-full h-full">
    <img
      v-if="!noImage"
      :src="src"
      :class="class"
      alt="img"
      @error="loadError"
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
  data() {
    return {
      noImage: false,
    };
  },
  methods: {
    loadError(e) {
      this.noImage = true;
    },
  },
};
</script>
