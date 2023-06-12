<script lang="ts">
import { defineComponent, inject, watch, ref, onBeforeMount } from "vue";
export default defineComponent({
  name: "Tab",
  props: {
    disabled: String,
  },
  setup() {
    const index = ref(0);
    const isActive = ref(false);

    const tabs = inject("TabsProvider");

    watch(
      () => tabs.selectedIndex,
      () => {
        isActive.value = index.value === tabs.selectedIndex;
      }
    );

    onBeforeMount(() => {
      index.value = tabs.count;
      tabs.count++;
      isActive.value = index.value === tabs.selectedIndex;
    });
    return { index, isActive };
  },
});
</script>

<template>
  <div v-bind="$attrs" v-show="isActive">
    <slot></slot>
  </div>
</template>
