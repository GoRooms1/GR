<template>
    <client-oly>
  <div v-click-outside="hide" class="relative z-[5] mt-2">
    <button @click="toggle" class="w-full px-[12px] h-8 bg-white rounded-[8px] flex items-center justify-between">
      <span class="text-[0.875rem] leading-[1rem]">
        {{ dateString }}
      </span>
      <img src="/img/calendar.svg" class="ml-1 min-[300px]:ml-2 w-5">
    </button>
    <div class="absolute top-[2rem] left-0 z-10 w-full" :class="isActive ? 'block' : 'hidden'">
      <div class="flex items-center justify-between bg-white w-full">
        <div class="w-[45%] bg-[#EAEFFD] h-[1rem] rounded-r-[8px]"></div>
        <div class="w-[45%] bg-[#EAEFFD] h-[1rem] rounded-l-[8px]"></div>
      </div>
      <div ref="datepicker"
        class="rounded-t-lg p-4 flex items-center justify-center bg-white w-[24.25rem] max-w-[calc(100vw-6.25rem)] leading-4">
        <input ref="day" @input="changeDay"
          class="w-[2.25rem] py-2 px-2.5 text-[#A7ABB7] text-sm bg-[#EAEFFD] rounded-lg mx-2" value="16" />
        .
        <input ref="month" @input="changeMonth"
          class="w-[2.25rem] py-2 px-2.5 text-[#A7ABB7] text-sm bg-[#EAEFFD] rounded-lg mx-2" value="11" />
        .
        <input ref="year" @input="changeYear"
          class="w-[3.25rem] py-2 px-2.5 text-[#A7ABB7] text-sm bg-[#EAEFFD] rounded-lg mx-2" value="2022" />
      </div>
    </div>
  </div>
    </client-oly>
</template>

<script>

import vClickOutside from "click-outside-vue3"
import datepicker from "js-datepicker/src/datepicker";

export default {
  directives: {
    clickOutside: vClickOutside.directive,
  },
  props: {
    modelValue: String,
  },
  mounted() {
    this.datePicker = datepicker(this.$refs.datepicker, {
      alwaysShow: true,
      disableYearOverlay: true,
      minDate: new Date(),
      disabledDates: [],
      customDays: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
      customMonths: ["Январь", "Ферваль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
      dateSelected: new Date(),
      onSelect: (instance, date) => {
        this.changeDate(date);
        this.hide();
      }
    });
    this.changeDate(new Date());
  },
  data() {
    return {
      datePicker: null,
      isActive: false,
      selectedDate: null,
      dateString: '',
    }
  },
  emits: ["update:modelValue"],
  methods: {
    toggle() {
      this.isActive = !this.isActive;
    },
    hide() {
      this.isActive = false;
    },
    changeDate(date) {
      if (date) {
        this.selectedDate = date;
        const dateStr = date.toLocaleDateString("ru");
        this.dateString = dateStr;
        const dateStrSplited = dateStr.split(".");
        this.$refs.day.value = dateStrSplited[0];
        this.$refs.month.value = dateStrSplited[1];
        this.$refs.year.value = dateStrSplited[2];

        this.$emit("update:modelValue", dateStr);
      } else {
        this.datePicker.setDate(this.selectedDate);
      }
    },
    changeDay(event) {
      event.target.value = event.target.value.substring(0, 2).replace(/[^0-9]+/g, "");
      const day = Number(event.target.value);
      if (day < this.datePicker.minDate.getDate()) return;
      this.selectedDate.setDate(day);
      this.datePicker.setDate(this.selectedDate, true);
      this.changeDate(this.selectedDate);
    },
    changeMonth(event) {
      event.target.value = event.target.value.substring(0, 2).replace(/[^0-9]+/g, "");
      const month = Number(event.target.value);
      if (month - 1 < this.datePicker.minDate.getMonth()) return;
      this.selectedDate.setMonth(month - 1);
      this.datePicker.setDate(this.selectedDate, true);
      this.changeDate(this.selectedDate);
    },
    changeYear(event) {
      event.target.value = event.target.value.substring(0, 4).replace(/[^0-9]+/g, "");
      const year = Number(event.target.value);
      if (year < this.datePicker.minDate.getFullYear()) return;
      this.selectedDate.setFullYear(year);
      this.datePicker.setDate(this.selectedDate, true);
      this.changeDate(this.selectedDate);
    },
  }
};
</script>
