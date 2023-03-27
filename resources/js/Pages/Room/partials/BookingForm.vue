<template>
  <div
    class="fixed px-[1.625rem] pb-[1.625rem] pt-[3.75rem] lg:p-0 lg:fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] lg:h-[100vh] backdrop-blur-[2.5px] flex flex-col lg:justify-center items-center overflow-y-auto">
    <div class="max-w-[800px] flex flex-col w-full lg:mb-[160px]">
      <button @click="close()"
        class="absolute top-[12px] right-[1rem] lg:static lg:w-[2rem] lg:h-[2rem] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
        <img src="/img/close.svg">
      </button>      
      <div v-if="!bookingSuccess">
        <div class="flex flex-col p-6 lg:p-4 rounded-t-3xl bg-white lg:shadow-md z-[2] mx-6 lg:mx-0">
          <span
            class="font-semibold text-[1.375rem] text-center lg:text-left lg:text-[1.75rem] leading-8">Бронирование</span>
          <span class="text-sm text-center lg:text-left mt-4 lg:mt-2">
            {{ room.hotel.type.single_name }} <b>{{ room.hotel.name }}</b>, Номер {{ room.number ? room.number + " / " :
              "" }}
            {{ room?.name?.length > 1 ? room.name : "" }}
            {{
              room.category?.name?.length > 1
              ? "(" + room.category.name + ")"
              : ""
            }}
          </span>
        </div>
        <div
          class="bg-[#EAEFFD] flex flex-col w-full p-6 pt-4 lg:p-4 z-[1] shadow-md lg:shadow-none rounded-3xl lg:rounded-none">
          <div class="flex">
            <button v-for="cost in room?.costs ?? []" @click="switchCostType(cost?.period?.type?.id)"
              class="mr-4 flex-1 lg:flex-none text-[0.875rem] leading-[1rem] px-[19px] h-[2rem] flex items-center justify-center rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150"
              :class="cost.value > 0 ? (cost?.period?.type?.id == costType ? 'bg-[#6170FF] text-white' : 'bg-white') : 'text-white bg-slate-400 pointer-events-none'">
              {{ cost?.period?.type?.name }}
            </button>
          </div>
          <div class="flex flex-col lg:flex-row mt-4 text-sm text-[#515561]">
            <div class="flex">
              <div class="flex flex-col flex-[2_2_0%] lg:flex-none">
                <span>Заезд</span>                
                <DatePicker v-model="form.from_date" @update:modelValue="calculate()" />
                <span class="mt-3">Выезд</span>                
                <div class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg">
                  {{ form.to_date }}
                </div>
              </div>
              <div class="flex flex-col ml-4 flex-1 lg:flex-none lg:w-[88px]">
                <span>&nbsp;</span>
                <TimePicker v-if="costType == 1" v-model="form.from_time" @update:modelValue="calculate()" />
                <div v-if="costType != 1"
                  class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg">{{
                    form.from_time }}</div>
                <span class="mt-3">&nbsp;</span>
                <div class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg">
                  {{ form.to_time }}
                </div>
              </div>
              <div class="flex flex-col ml-4 w-[52px]">
                <span v-if="costType == 1" style="">Часы</span>
                <span v-if="costType == 3">Сутки</span>
                <NumSelect v-if="costType == 1" :options-array="getNumsRange(startAtHours, endAtHours)" not-null
                  :model-value="hours" @update:modelValue="(event) => selectHours(event)" />
                <NumSelect v-if="costType == 3" :options-array="getNumsRange(1, 14)" not-null :model-value="days"
                  @update:modelValue="(event) => selectDays(event)" />
              </div>
            </div>
            <div class="flex flex-col mt-4 lg:mt-0 lg:ml-4">
              <div class="flex">
                <span>Имя</span>
                <div v-if="form.errors.client_fio" class="flex text-[#E1183D]">
                  <img src="/img/attentionRed.svg" class="mx-2 w-4">
                  Не заполнено
                </div>
                <div v-if="!form.errors.client_fio" class="flex">
                  <img src="/img/checkcircle.svg" class="ml-2 w-4">
                </div>
              </div>
              <input v-model="form.client_fio" @input="validate()" placeholder="Как к вам обращаться"
                class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]">
              <div class="flex mt-3">
                <span>Телефон</span>
                <div v-if="form.errors.client_phone" class="flex text-[#E1183D]">
                  <img src="/img/attentionRed.svg" class="mx-2 w-4">
                  Не заполнено
                </div>
                <div v-if="!form.errors.client_phone" class="flex">
                  <img src="/img/checkcircle.svg" class="ml-2 w-4">
                </div>
              </div>
              <input v-model="form.client_phone" @input="validate(); phoneHandle()" v-maska :data-maska="phoneMask" placeholder="+7 (___) ___ __ __"
                class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]">
            </div>
            <div class="flex flex-col mt-4 lg:mt-0 lg:ml-4 flex-1">
              <span>Комментарий</span>
              <textarea v-model="form.comment" placeholder="Напишите ваши пожелания"
                class="w-full px-3 py-2 lg:!h-full mt-2 bg-white rounded-[8px] resize-none"></textarea>
            </div>
          </div>
        </div>
        <div class="flex flex-col lg:flex-row items-center p-4 rounded-b-3xl bg-white mx-6 lg:mx-0">
          <span class="lg:w-1/2 lg:max-w-[300px] text-[10px] text-center lg:text-left">Нажимая «Забронировать» вы даёте
            согласие на обработку персональных данных и соглашаетесь c <a class="underline" href="#">пользовательским
              соглашением</a> и <a class="underline" href="#">политикой конфиденциальности</a>.</span>
          <span class="mt-4 lg:ml-4 lg:mt-0">Сумма к оплате: <b class="text-sm">{{ amount }} ₽</b></span>
          <button @click="submit"
            class="mt-4 lg:ml-auto lg:mt-0 w-full flex items-center justify-center h-12 lg:w-[248px] rounded-lg text-white"
            :class="isValidated ? 'bg-blue-500 hover:bg-blue-800' : 'bg-slate-400 pointer-events-none'">
            Забронировать
          </button>
        </div>
      </div>
      <div v-if="bookingSuccess"
        class="mt-[20vh] lg:m-0 lg:w-[800px] lg:h-[374px] flex flex-col relative items-center justify-center bg-white rounded-3xl p-6 overflow-hidden">
        <img src="/img/bookingSuccess.svg" class="hidden lg:block absolute top-[-51px] left-[17px]">
        <img src="/img/bookingSuccess.svg" class="hidden lg:block absolute bottom-[-42px] right-[63px]">
        <h4 class="text-[1.375rem] lg:text-[28px] font-semibold">{{ $page.props.flash.message?.title }}</h4>
        <span class="text-center mt-6 text-sm leading-4 z-[1]">
          <span v-html="$page.props.flash.message?.body">
          </span>
          <button @click="close"
            class="lg:hidden mt-6 w-full flex items-center justify-center h-12 rounded-lg bg-[#6170FF] text-white">
            На главную
          </button>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from '@/components/ui/DatePicker.vue'
import TimePicker from '@/components/ui/TimePicker.vue'
import NumSelect from '@/components/ui/NumSelect.vue'
import _ from "lodash"
import moment from 'moment'
import { vMaska } from "maska"
import { useForm, usePage } from "@inertiajs/inertia-vue3"
import intus from "intus"
import { isRequired, isMin, isMax } from "intus/rules"

export default {
  components: {
    DatePicker,
    TimePicker,
    NumSelect,    
  },
  directives: {
    maska: vMaska,
  },
  props: {
    isActive: {
      type: Boolean,
      default: false,
    },
    room: Object,
  },
  mounted() {
    this.switchCostType(1);
    this.validate();
  }, 
  data() {
    return {
      costType: 1,
      startAtHours: 1,
      endAtHours: 6,
      hours: 0,
      days: 0,
      price: 0,
      amount: 0,
      cost: null,      
      form: useForm({
        room_id: this.room.id,
        client_fio: null,
        client_phone: null,
        from_date: null,
        from_time: null,
        to_date: null,
        to_time: null,
        book_comment: null,
        book_type: 'hour',
        hours_count: null,
        days_count: null,        
      }),
      bookingSuccess: false,
      valudationRules: {
        client_fio: [isRequired(), isMin(3), isMax(190)],        
        client_phone: [isRequired(), isMin(18), isMax(18)],        
      },
      phoneMask: '+7 (###) ### ## ##',      
    }
  },
  computed: {    
    isValidated() {
      return !this.form.hasErrors;
    }
  },
  methods: {
    close() {
      usePage().props.value.flash.message = null;
      this.bookingSuccess = false;      
      eventBus.emit('booking-close');
    },
    switchCostType(typeId) {
      if (typeId) {
        this.costType = typeId;

        let cost = _.find(this.room.costs, (el) => {
          return el?.period?.cost_type_id == typeId;
        });

        this.cost = cost;
        this.price = cost.value;          

        if (typeId == 1) {
          this.form.from_time = moment().format('HH:mm');
          this.startAtHours = cost?.period?.start_at ?? 1;
          this.hours = this.startAtHours;
          this.form.book_type = 'hour';
        }

        if (typeId == 2) {
          this.form.from_time = cost.period.start_at;
          this.form.book_type = 'night';
        }

        if (typeId == 3) {
          this.form.from_time = cost.period.start_at;
          this.days = this.days > 0 ? this.days : 1;
          this.form.book_type = 'day';
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
    calculate() {
      if (this.costType == 1) {
        let momentToDateTime = moment(this.form.from_date + ' ' + this.form.from_time, 'DD.MM.YYYY HH:mm').add(this.hours, 'hours');
        this.form.to_time = momentToDateTime.format('HH:mm');
        this.form.to_date = momentToDateTime.toDate().toLocaleDateString('ru-RU');
        this.form.hours_count = this.hours;
        this.form.days_count = 0;
        this.amount = this.price * this.hours;
      }

      if (this.costType == 2) {
        this.form.to_date = moment(this.form.from_date, 'DD.MM.YYYY').add(1, 'days').toDate().toLocaleDateString('ru-RU');
        this.form.to_time = this.cost.period.end_at;
        this.form.hours_count = 0;
        this.form.days_count = 0;
        this.amount = this.price;
      }

      if (this.costType == 3) {
        this.form.to_date = moment(this.form.from_date, 'DD.MM.YYYY').add(this.days, 'days').toDate().toLocaleDateString('ru-RU');
        this.form.to_time = this.cost.period.end_at;
        this.form.days_count = this.days;
        this.form.hours_count = 0;
        this.amount = this.price * this.days;
      }
    },
    getNumsRange(from, to) {
      let hours = _.transform(_.range(from, to + 1, 1), function (result, n) {
        let obj = {
          key: n,
          name: n
        };
        result.push(obj);
        return obj;
      }, []);

      return hours;
    },
    phoneHandle() {
      let value = this.form.client_phone ?? '';
      //Handle Ru phone number
      if (_.isEmpty(value) || value.startsWith('+7 ')) {
        this.phoneMask = '+7 (###) ### ## ##';
        this.valudationRules.client_phone = [isRequired(), isMin(18), isMax(18)];        
      }

      //Handle other countries phone number
      if (value === '+') {
        this.phoneMask = "";              
        this.valudationRules.client_phone = [isRequired()];
      } 
    },
    validate() {
      let validation = intus.validate(this.form.data(), this.valudationRules);      
      this.form.clearErrors();
      this.form.setError(validation.errors());     
    },
    submit() {
      if (this.isValidated) {
        this.form.post(route("rooms.booking"), {
          onSuccess: () => this.bookingSuccess = true,
        });
      };
    },
  }
};
</script>
