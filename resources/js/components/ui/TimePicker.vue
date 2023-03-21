<template>
    <div class="relative z-[5] mt-2">
      <button
        @click="toggle"
        class="w-full px-[12px] min-w-[5rem] h-8 bg-white rounded-[8px] flex items-center justify-between">
        <span class="text-[0.875rem] leading-[1rem]">
          {{ selectedTime }}
        </span>
        <img src="/img/clock.svg" class="ml-1 min-[300px]:ml-2 w-5">
      </button>
      <div class="absolute top-[2rem] sm:left-0 left-[-1rem] z-10" :class="isActive ? 'block' : 'hidden'">
        <div class="flex items-center justify-between bg-white w-full">
          <div class="sm:w-[45%] w-[24%] bg-[#EAEFFD] h-[1rem] rounded-r-[8px]"></div>
          <div class="sm:w-[45%] w-[72%] bg-[#EAEFFD] h-[1rem] rounded-l-[8px]"></div>
        </div>
        <div class="flex rounded-[8px] bg-white py-[12px] shadow-xl">
          <div class="filter-scrollbar3 overflow-y-auto max-h-[152px] py-[2px] px-[1rem]">
            <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
              <button v-for="hour in hours" @click="changeHour(hour)"
                class="text-[0.875rem] leading-[1rem] w-full px-[8px] h-[2rem] flex items-center justify-start rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150">
                {{ hour }}
              </button>            
            </div>
          </div>
          <div class="max-h-[300px] py-[2px] px-[1rem]">
            <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
              <button v-for="minute in minutes" @click="changeMinute(minute)"
                class="text-[0.875rem] leading-[1rem] w-full px-[8px] h-[2rem] flex items-center justify-start rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150">
                {{ minute }}
            </button>         
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vClickOutside from "click-outside-vue3"
import _ from "lodash"

export default {
  directives: {
    clickOutside: vClickOutside.directive,
  },
  props: {
    modelValue: String,
  },
  mounted() {    
    this.hours = _.transform(_.range(0, 24, 1), function(result, n) {
      let val = n;
      if (val < 10)
        val = '0' + val;
      result.push(val.toString());
      return val.toString();
    }, []);
    this.minutes = _.transform(_.range(0, 46, 15), function(result, n) {
      let val = n;
      if (val < 10)
        val = '0' + val;
      result.push(val.toString());
      return val.toString();
    }, []);
  },
  data() {
    return {   
      isActive: false,
      value: this.modelValue ?? '00:00', 
      hours: ['00'],
      minutes: ['00'],  
    } 
  },
  computed: {
    selectedTime() {
      return this.modelValue ?? this.value;
    },   
  },  
  emits: ["update:modelValue"],
  methods: {
    toggle() {
      this.isActive = !this.isActive;
    },
    hide() {
      this.isActive = false;
    },
    changeHour(hour) {      
      this.value = hour + ':' + this.value.split(':')[1];
      this.changeTime(this.value);      
    },
    changeMinute(minute) {      
      this.value = this.value.split(':')[0] + ':' + minute;
      this.changeTime(this.value);      
    },
    changeTime(value) {   
      this.$emit("update:modelValue", value);
      this.hide();
    }
  },
  watch: {
      modelValue: function (newVal, oldVal) {
        if (newVal != oldVal) this.value = newVal;
      },
    },
};
</script>
