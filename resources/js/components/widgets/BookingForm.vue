<template>
  <div
    class="flex fixed px-[1.625rem] pb-[1.625rem] xs:pt-[2.25rem] sm:pt-[3.75rem] pt-[1.75rem] lg:p-0 lg:fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] lg:h-[100vh] backdrop-blur-[2.5px] flex-col lg:justify-center items-center overflow-y-auto"
  >
    <div class="max-w-[800px] flex flex-col w-full lg:mb-[160px]">
      <button
        @click="close()"
        class="absolute top-[12px] right-[0.85rem] lg:static lg:w-[2rem] lg:h-[2rem] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]"
      >
        <img src="/img/close.svg" alt="close"/>
      </button>
      <form v-if="bookingSuccess !== true" @submit.prevent="">
        <div
          class="flex flex-col p-6 lg:p-4 rounded-t-3xl bg-white lg:shadow-md z-[2] mx-6 lg:mx-0"
        >
          <span
            class="font-semibold text-[1.375rem] text-center lg:text-left lg:text-[1.75rem] leading-8"
            >Бронирование</span
          >
          <span class="text-sm text-center lg:text-left mt-4 lg:mt-2">
            {{ room?.hotel?.type?.single_name }} <b>{{ room?.hotel?.name }}</b
            >, Номер {{ room?.number ? room?.number + " / " : "" }}
            {{ room?.name?.length > 1 ? room?.name : "" }}
            {{
              room?.category?.name?.length > 1
                ? "(" + room?.category?.name + ")"
                : ""
            }}
          </span>
        </div>
        <div
          class="bg-[#EAEFFD] flex flex-col w-full p-6 pt-4 lg:p-4 z-[1] shadow-md lg:shadow-none rounded-3xl lg:rounded-none"
        >
          <div class="flex">
            <button
              v-for="cost in room?.costs ?? []"
              @click="switchCostType(cost?.id)"
              class="mr-4 flex-1 lg:flex-none text-[0.875rem] leading-[1rem] px-[19px] h-[2rem] flex items-center justify-center rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150"
              :class="
                cost?.value > 0
                  ? cost?.id == costType
                    ? 'bg-[#6170FF] text-white'
                    : 'bg-white'
                  : 'text-white bg-slate-400 pointer-events-none'
              "              
            >
              {{ cost?.name }}
            </button>
          </div>
          <div class="flex flex-col lg:flex-row mt-4 text-sm text-[#515561]">
            <div class="flex">
              <div class="flex flex-col flex-[2_2_0%] lg:flex-none">
                <span>Заезд</span>
                <DatePicker 
                  @update:modelValue="e => changeDateFrom(e)"
                  :model-value="form.from_date"
                />
                <span class="mt-3">Выезд</span>
                <div
                  class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg"
                >
                  {{ form.to_date }}
                </div>
              </div>
              <div class="flex flex-col ml-4 flex-1 lg:flex-none lg:w-[88px]">
                <span>&nbsp;</span>
                <TimePicker
                  v-if="costType == 1"
                  v-model="form.from_time"
                  @update:modelValue="calculate()"
                />
                <div
                  v-if="costType != 1"
                  class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg"
                >
                  {{ form.from_time }}
                </div>
                <span class="mt-3">&nbsp;</span>
                <div
                  class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg"
                >
                  {{ form.to_time }}
                </div>
              </div>
              <div class="flex flex-col ml-4 w-[52px]">
                <span v-if="costType == 1" style="">Часы</span>
                <span v-if="costType == 3">Сутки</span>
                <NumSelect
                  v-if="costType == 1"
                  :options-array="getNumsRange(startAtHours, endAtHours)"
                  not-null
                  :model-value="hours"
                  @update:modelValue="(event) => selectHours(event)"
                />
                <NumSelect
                  v-if="costType == 3"
                  :options-array="getNumsRange(1, 14)"
                  not-null
                  :model-value="days"
                  @update:modelValue="(event) => selectDays(event)"
                />
              </div>
            </div>
            <div class="flex flex-col mt-4 lg:mt-0 lg:ml-4">
              <div v-if="room != null" class="flex">
                <span>Имя</span>                
                <div v-if="form.errors.client_fio || v$.form.client_fio.$errors.length > 0" class="flex text-[#E1183D]">
                  <img src="/img/attentionRed.svg" class="mx-2 w-4" />
                  Не заполнено
                </div>
                <div v-if="!form.errors.client_fio && v$.form.client_fio.$errors.length == 0" class="flex">
                  <img src="/img/checkcircle.svg" class="ml-2 w-4">
                </div>
              </div>
              <input
                v-model="form.client_fio"
                @input="v$.form.client_fio.$touch; delete form.errors.client_fio;"
                placeholder="Как к вам обращаться"
                class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]"
                id="booking-client_fio"
              />
              <div v-if="room != null" class="flex mt-3">
                <span>Телефон</span>
                <div
                  v-if="form.errors.client_phone || v$.form.client_phone.$errors.length > 0"
                  class="flex text-[#E1183D]"
                >
                  <img src="/img/attentionRed.svg" class="mx-2 w-4" />
                  Не заполнено
                </div>
                <div v-if="!form.errors.client_phone && v$.form.client_phone.$errors.length == 0" class="flex">
                  <img src="/img/checkcircle.svg" class="ml-2 w-4">
                </div>
              </div>
              <input
                v-model="form.client_phone"
                @input="phoneHandle(); v$.form.client_phone.$touch; delete form.errors.client_phone;"
                v-maska
                :data-maska="phoneMask"
                placeholder="+7 (___) ___ __-__"
                data-maska-tokens="C:[0-9 \-\+()]"
                class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]"
                id="booking-client_phone"
              />
            </div>
            <div class="flex flex-col mt-4 lg:mt-0 lg:ml-4 lg:flex-1">
              <span>Комментарий</span>
              <textarea
                v-model="form.book_comment"
                placeholder="Напишите ваши пожелания"
                class="w-full px-3 py-2 lg:!h-full mt-2 bg-white rounded-[8px] resize-none h-[80px]"
                id="booking-book_comment"
              ></textarea>
            </div>
          </div>
        </div>
        <div
          class="flex flex-col lg:flex-row items-center p-4 rounded-b-3xl bg-white mx-6 lg:mx-0"
        >
          <span
            class="lg:w-1/2 lg:max-w-[300px] text-[10px] text-center lg:text-left"
            >Нажимая «Забронировать» вы даёте согласие на обработку персональных
            данных и соглашаетесь c
            <a class="underline" href="#">пользовательским соглашением</a> и
            <a class="underline" href="#">политикой конфиденциальности</a
            >.</span
          >
          <span class="mt-4 lg:ml-4 lg:mt-0"
            >Сумма к оплате: <b class="text-sm">{{ amount }} ₽</b></span
          >
          <button
            @click="submit"
            class="mt-4 lg:ml-auto lg:mt-0 w-full flex items-center justify-center h-12 lg:w-[248px] rounded-lg text-white"
            :class="(form.errors ?? []).length > 0 || (v$.$errors ?? []).length > 0 ?
               'bg-slate-400 pointer-events-none' : 'bg-blue-500 hover:bg-blue-800'"
            id="booking-submit"
          >
            Забронировать
          </button>          
        </div>
      </form>
      <div
        v-if="bookingSuccess === true"
        class="mt-[20vh] lg:m-0 lg:w-[800px] lg:h-[374px] flex flex-col relative items-center justify-center bg-white rounded-3xl p-6 overflow-hidden"
        id="booking-success_msg"
      >
        <img
          src="/img/bookingSuccess.svg"
          class="hidden lg:block absolute top-[-51px] left-[17px]"
        />
        <img
          src="/img/bookingSuccess.svg"
          class="hidden lg:block absolute bottom-[-42px] right-[63px]"
        />
        <h4 class="text-[1.375rem] lg:text-[28px] font-semibold">
          {{ $page.props.flash.message?.title }}
        </h4>
        <span class="text-center mt-6 text-[16px] leading-4 z-[1]">
          <span v-html="$page.props.flash.message?.body"></span>
          <br><br>        
          <span class="text-red-500" v-html="$page.props.flash.message?.notice" ></span>
          <button
            @click="close"
            class="lg:hidden mt-6 w-full flex items-center justify-center h-12 rounded-lg bg-[#6170FF] text-white"
          >
            На главную
          </button>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, minLength, maxLength } from '@vuelidate/validators'
import DatePicker from "@/components/ui/DatePicker.vue";
import TimePicker from "@/components/ui/TimePicker.vue";
import NumSelect from "@/components/ui/NumSelect.vue";
import moment from "moment";
import { vMaska } from "maska";
import { useForm } from "@inertiajs/vue3";

export default {
  setup () {
    return { v$: useVuelidate() }
  },
  components: {    
    DatePicker,
    TimePicker,
    NumSelect,
  },
  directives: {
    maska: vMaska,
  },
  props: {    
    room: Object,
  },  
  data() {
    return {
      costType: 1,
      startAtHours: 1,
      endAtHours: 6,
      hours: 0,
      days: 0,      
      amount: 0,
      cost: null,
      form: useForm({
        room_id: this.room?.id,
        client_fio: this.$page.props?.user?.name ?? null,
        client_phone: this.$page.props?.user?.phone ?? null,
        from_date: moment().format("DD.MM.YYYY"),
        from_time: null,
        to_date: null,
        to_time: null,
        book_comment: null,
        book_type: "hour",
        hours_count: null,
        days_count: null,
        amount: 0,
      }),
      bookingSuccess: false,
      phoneMask: "+7 (###) ### ##-##",
    };
  },
  validations () {
    return {
      form: { 
        client_fio: { required, minLengthValue: minLength(3), maxLengthValue: maxLength(190) },
        client_phone: { required, phoneValidator: this.phoneValidator },
      },      
    }
  },  
  methods: {
    init() {
      this.setDefaultValues();      
      this.switchCostType(1);
      this.v$.$validate(); 
    },
    phoneValidator(value) {
      if (this.phoneMask === '+7 (###) ### ##-##') return value.length == this.phoneMask.length;
      return value.length >= 7;
    },
    close() {      
      this.$page.props.flash.message = null;
      this.bookingSuccess = false;
      this.$eventBus.emit("booking-close");
    },
    switchCostType(typeId) {
      if (typeId) {
        this.costType = typeId;

        let cost = this.room.costs.find(el => el?.id == typeId);

        this.cost = cost;        

        if (typeId == 1) {
          this.form.from_time = moment().format("HH:mm");
          this.startAtHours = cost?.period?.start_at ?? 1;
          this.hours = this.startAtHours;
          this.form.book_type = "hour";
        }

        if (typeId == 2) {
          this.form.from_time = cost.period.start_at;
          this.form.book_type = "night";
        }

        if (typeId == 3) {
          this.form.from_time = cost.period.start_at;
          this.days = this.days > 0 ? this.days : 1;
          this.form.book_type = "day";
        }

        if (cost.value == 0 && typeId < 3) this.switchCostType(typeId + 1);

        this.calculate();
      }
    },
    selectHours(hours) {
      this.hours = hours;
      this.calculate();
    },
    selectDays(days) {
      this.days = days;
      this.calculate();
    },
    changeDateFrom(e) {      
      this.form.from_date = e;
      this.calculate();
    },
    calculate() {
      if (this.costType == 1) {
        let momentToDateTime = moment(
          this.form.from_date + " " + this.form.from_time,
          "DD.MM.YYYY HH:mm"
        ).add(this.hours, "hours");
        this.form.to_time = momentToDateTime.format("HH:mm");
        this.form.to_date = momentToDateTime
          .toDate()
          .toLocaleDateString("ru-RU");
        this.form.hours_count = this.hours;
        this.form.days_count = 0;

        let hours = 0;
        this.amount = 0;

        while (hours < this.hours) {
          let date = moment(this.form.from_date + " " + this.form.from_time, "DD.MM.YYYY HH:mm").add(hours, "hours");
          let price = this.getPriceOnDate(date.format("DD.MM.YYYY"));
          this.amount += price;          
          hours++;
        }        
      }

      if (this.costType == 2) {
        this.form.to_date = moment(this.form.from_date, "DD.MM.YYYY")
          .add(1, "days")
          .toDate()
          .toLocaleDateString("ru-RU");
        this.form.to_time = this.cost.period.end_at;
        this.form.hours_count = 0;
        this.form.days_count = 0;

        this.amount = this.getPriceOnDate(this.form.from_date);
      }

      if (this.costType == 3) {
        this.form.to_date = moment(this.form.from_date, "DD.MM.YYYY")
          .add(this.days, "days")
          .toDate()
          .toLocaleDateString("ru-RU");
        this.form.to_time = this.cost.period.end_at;
        this.form.days_count = this.days;
        this.form.hours_count = 0;

        let days = 0;
        this.amount = 0;

        while (days < this.days) {
          let date = moment(this.form.from_date, "DD.MM.YYYY").add(days, "days");
          let price = this.getPriceOnDate(date.format("DD.MM.YYYY"));
          this.amount += price;          
          days++;
        }
      }

      this.form.amount = this.amount;
    }, 
    getPriceOnDate(date) {      
      if ((this.cost?.actual_cost_periods ?? []).length === 0)
        return this.cost?.value ?? 0;

      let dateMoment = moment(date, "DD.MM.YYYY");

      let periodCost = this.cost.actual_cost_periods.find((el) => dateMoment.isSameOrAfter(el.date_from, "YYYY-MM-DD") && dateMoment.isSameOrBefore(el.date_to, "YYYY-MM-DD"));
      
      if (periodCost?.value)
        return periodCost?.value;

      return this.cost?.value ?? 0;
    },  
    getNumsRange(from, to) {
      let hours = [];
      for (let index = from; index < to + 1; index++) {
        hours.push({
          key: index,
          name: index
        });        
      }
      return hours;
    },
    phoneHandle() {
      let value = this.form.client_phone ?? "";
      //Handle Ru phone number
      if (value == null || value == '' || value.startsWith("+7")) {
        this.phoneMask = "+7 (###) ### ##-##";
      }

      //Handle other countries phone number
      if (value === "+") {
        this.phoneMask = "C".repeat(25);
      }
    },
    submit() {
      this.form.post("/rooms/booking", {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'errors'],
        onSuccess: () => {this.bookingSuccess = true;},        
      });
    },
    setDefaultValues() {
      this.costType = 1;
      this.startAtHours = 1;
      this.endAtHours = 6;
      this.hours = 0;
      this.days = 0;      
      this.amount = 0;
      this.cost = null;
      this.form.room_id = this.room?.id;
      this.form.client_fio = this.$page.props?.user?.name ?? null;
      this.form.client_phone = this.$page.props?.user?.phone ?? null;
      this.form.from_date = moment().format("DD.MM.YYYY");
      this.form.from_time = null;
      this.form.to_date = null;
      this.form.to_time = null;
      this.form.book_comment = null;
      this.form.book_type = "hour";
      this.form.hours_count = null;
      this.form.days_count = null;
      this.form.bookingSuccess = false;
      this.form.phoneMask = "+7 (###) ### ##-##";
      this.form.amount = 0;    
    },
  },
  watch: {
    room(newVal, oldVal) {
      if (newVal != null && oldVal == null)
        this.init();
    } 
  }  
};
</script>
