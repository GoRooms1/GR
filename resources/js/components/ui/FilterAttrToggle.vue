<template>
  <button @click="toggle()" :class="btnClass + ' ' + activeClass">
    <img v-if="!value && img" :src="img" :class="imgClass" :alt="title"/>
    <img v-if="value && toggleImg"
      :src="toggleImg"
      :class="imgClass"
      :alt="title"
    />
    <span :class="titleClass">{{ title }}</span>
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    title: String,
    img: String,
    toggleImg: String,
    type: String,
    modelValue: {
      type: [String, Boolean, Number],
      default: null,
    },
    disabled: Boolean,
    initialValue: [String, Boolean, Number],
  },
  created() {},
  emits: ["update:modelValue"],
  data() {
    return {
      localValue: null,
    };
  },
  computed: {
    titleClass() {
      switch (this.type) {
        case "horizontal":
          return "flex text-sm";
          break;
        case "vertical":
          return "text-[14px] leading-[16px] mt-auto";
          break;
        case "small":
          return "text-[14px] leading-[16px] whitespace-nowrap";
          break;
        default:
          return "";
      }
    },
    imgClass() {
      switch (this.type) {
        case "horizontal":
          return "sm:mr-3 w-[3.5rem]";
          break;
        case "vertical":
          return "mt-[19px] max-w-full";
          break;
        case "small":
          return "small-icon";
          break;
        default:
          return "";
      }
    },
    btnClass() {
      switch (this.type) {
        case "horizontal":
          return "px-[12px] row-span-2 flex items-center text-sm text-left rounded-[8px]";
          break;
        case "vertical":
          return "w-full mt-[16px] pb-[8px] flex items-center flex-col justify-center h-[128px] rounded-[8px]";
          break;
        case "small":
          return "px-[12px] h-[32px] flex items-center gap-[8px] justify-center md:hover:outline outline-solid outline-[#6170FF] transition duration-150 rounded-[8px]";
          break;
        case "square":
          return "p-2.5 rounded-lg mx-[1.7%]";
          break;
        default:
          return "";
      }
    },
    activeClass() {
      switch (this.type) {
        case "square":
          return this.value
            ? "bg-[#6170FF] text-white"
            : this.disabled
            ? "btn-disabled pointer-events-none bg-slate-200"
            : "bg-[#EAEFFD]";
          break;
        default:
          return this.value
            ? "bg-[#6170FF] text-white"
            : this.disabled
            ? "btn-disabled pointer-events-none bg-slate-200"
            : "bg-white";
      }
    },
    value() {
      return this.modelValue ?? this.localValue;
    },
  },
  methods: {
    toggle() {
      if (!this.initialValue) return false;
      if (!this.value) {
        let value = this.initialValue ?? true;
        this.localValue = value;
        this.emmitUpdate(value);
      } else {
        this.localValue = null;
        this.emmitUpdate(null);
      }
    },
    emmitUpdate(value) {
      this.$emit("update:modelValue", value);
    },
  },
  watch: {
    modelValue: function (newVal, oldVal) {
      if (!newVal && oldVal) this.localValue = newVal;
    },
  },
};
</script>
