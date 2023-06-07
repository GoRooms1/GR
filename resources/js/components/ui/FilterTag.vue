<template>
  <div v-if="isShow"
    class="flex items-center gap-[8px] rounded-[10px] bg-[#3B24C6] h-[32px] px-[12px] w-[fit-content]"
  >
    <span class="text-white text-[12px] leading-[14px] whitespace-nowrap">{{
      title
    }}</span>
    <button type="button" @click="close()" v-if="removable == true">
      <img src="/img/close_tag.svg" alt="close" width="12" height="12"/>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    filterModel: String,
    filterKey: String,
    isAttribute: {
      type: Boolean,
      default: false,
    },
    filterValue: [String, Number, Boolean],
    removable: {
      type: Boolean,
      default: true,
    },
    title: String,
  },  
  emmits: ["tag-closed"],
  data() {
    return {
      isShow: true,
    }
  },  
  methods: {
    close() {
      if (this.removable == true) {
        this.$emit("tag-closed", {
          modelType: this.filterModel,
          key: this.filterKey,
          isAttribute: this.isAttribute          
        });
        this.isShow = false;
      }
    },
  },
};
</script>
