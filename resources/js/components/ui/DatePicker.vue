<template>
  <div class="relative z-[5] mt-2">
    <button @click="toggleMenu()" class="w-full px-[12px] h-8 bg-white rounded-[8px] flex items-center justify-between">
      <span class="text-[0.875rem] leading-[1rem]">{{ date }}</span>
      <img src="/img/calendar.svg" alt="calendar" class="ml-1 min-[300px]:ml-2 w-5">
    </button>
    <div v-if="isArrowOpen === true" class="absolute top-[2rem] left-0 z-10 w-full block">
      <div class="flex items-center justify-between bg-white w-full">
        <div class="w-[45%] bg-[#EAEFFD] h-[1rem] rounded-r-[8px]"></div>
        <div class="w-[45%] bg-[#EAEFFD] h-[1rem] rounded-l-[8px]"></div>
      </div>
    </div>
    
    <VueDatePicker
      ref="datepicker"
      @update:model-value="e => emitValue(e)"
      :model-value="date"
      model-type="dd.MM.yyyy"
      :format="dateFormat"
      :enable-time-picker="false"
      :min-date="new Date()"
      position="left"
      locale="ru"
      auto-apply
      required      
      input-class-name="hidden"
      menu-class-name="datepicker-menu"     
      calendar-class-name="datepicker-calendar"
      calendar-cell-class-name="datepicker-cell"     
      @open="isOpen = true; isArrowOpen = true"
      @closed="isArrowOpen = false; closed()"
    >
      <template 
        #month-year="{
            day,
            month,
            year,
            months,                    
            handleMonthYearChange
        }"
      >       
        
        <div class="datepicker-controls">
          <div class="flex items-center justify-center bg-white w-full leading-4 overflow-hidden" style="padding: 1.3125rem;">
            <input @change="changeDay" class="w-[2.25rem] py-2 px-2.5 text-[#A7ABB7] text-sm bg-[#EAEFFD] rounded-lg mx-2" :value="date.split('.')[0] ?? '00' ">
            .
            <input @change="changeMonth" class="w-[2.25rem] py-2 px-2.5 text-[#A7ABB7] text-sm bg-[#EAEFFD] rounded-lg mx-2" :value="date.split('.')[1] ?? '00'">
            .
            <input @change="changeYear" class="w-[3.25rem] py-2 px-2.5 text-[#A7ABB7] text-sm bg-[#EAEFFD] rounded-lg mx-2" :value="date.split('.')[2] ?? '0000'">
          </div>
          <div class="flex justify-between w-full" style="padding: 1.3125rem;">
            <div 
              class="datepicker__arrow datepicker__arrow-left"
              @click="handleMonthYearChange(false)"
            >
            </div>
            <div class="datepicker__month-year">
              <span>{{ months[month].text + ' ' }}</span>
              <span>{{ year }}</span>
            </div>
            <div 
              class="datepicker__arrow datepicker__arrow-right"
              @click="handleMonthYearChange(true)"
            >            
            </div>
          </div>
          
        </div>
      </template>     
    </VueDatePicker>
  </div>
</template>

<script>
import VueDatePicker from "@vuepic/vue-datepicker";
import moment from "moment";

export default {
  components: {
    VueDatePicker,    
  },
  props: {
    modelValue: String,
  }, 
  data() {
    return {
      date: this.modelValue ?? moment().format("DD.MM.YYYY"),
      isArrowOpen: false,
      isOpen: false,
    }
  },  
  emits: ["update:modelValue"],
  methods: {   
    dateFormat(date) {
      return moment(date).format("DD.MM.YYYY");
    },    
    emitValue(e) {      
      this.date = e;
      this.$emit("update:modelValue", this.date);      
    },
    closed() {
      setTimeout(() => {
        this.isOpen = false;        
      }, 200);
    },
    toggleMenu() {      
      if (this.isOpen)
        this.$refs.datepicker.closeMenu();
      else
        this.$refs.datepicker.openMenu();        
    },
    changeDay(event) {
      let dateTmp = moment(this.date, "DD.MM.YYYY");
      let value = event.currentTarget?.value ?? 1;
      dateTmp = moment(dateTmp).set("date", value);
      this.date = this.dateFormat(dateTmp);
      this.emitValue(this.date);    
    },
    changeMonth(event) {
      let dateTmp = moment(this.date, "DD.MM.YYYY");
      let value = event.currentTarget?.value ?? 1;
      dateTmp = moment(dateTmp).set("month", value-1);
      this.date = this.dateFormat(dateTmp);
      this.emitValue(this.date);     
    },
    changeYear(event) {
      let dateTmp = moment(this.date, "DD.MM.YYYY");
      let value = event.currentTarget.value;
      dateTmp = moment(dateTmp).set("year", value);
      this.date = this.dateFormat(dateTmp);
      this.emitValue(this.date);    
    } 
  },
  watch: {
    modelValue: function (newVal, oldVal) {
      if (newVal != oldVal) this.date = newVal;
    },
  },
};
</script>
