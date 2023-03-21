<template>
  <div v-if="isActive"
    class="fixed px-[1.625rem] pb-[1.625rem] pt-[3.75rem] lg:p-0 lg:fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] lg:h-[100vh] backdrop-blur-[2.5px] flex flex-col lg:justify-center items-center overflow-y-auto">
    <div class="max-w-[800px] flex flex-col w-full lg:mb-[160px]">
      <button @click="close()"
        class="absolute top-[12px] right-[1rem] lg:static lg:w-[2rem] lg:h-[2rem] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
        <img src="/img/close.svg">
      </button>
      <div>
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
            <button 
              v-for="cost in room?.costs ?? []"
              @click="switchCostType(cost?.period?.type?.id)"
              class="mr-4 flex-1 lg:flex-none text-[0.875rem] leading-[1rem] px-[19px] h-[2rem] flex items-center justify-center rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150"
              :class="cost.value > 0 ? (cost?.period?.type?.id == costType ? 'bg-[#6170FF] text-white' : 'bg-white') : 'text-white bg-slate-400 pointer-events-none'"
              >
              {{ cost?.period?.type?.name }}
            </button>            
          </div>
          <div class="flex flex-col lg:flex-row mt-4 text-sm text-[#515561]">
            <div class="flex">
              <div class="flex flex-col flex-[2_2_0%] lg:flex-none">
                <span>Заезд</span>
                <DatePicker v-model="fromDate" @update:modelValue="calculateDateOut()"/>
                <span class="mt-3">Выезд</span>
                <div class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg">
                  {{ toDate }}
                </div>              
              </div>
              <div class="flex flex-col ml-4 flex-1 lg:flex-none lg:w-[88px]">
                <span>&nbsp;</span>
                <TimePicker v-if="costType == 1" v-model="fromTime"  @update:modelValue="calculateDateOut()"/>
                <div v-if="costType != 1" class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg">{{ fromTime }}</div>
                <span class="mt-3">&nbsp;</span>
                <div
                  class="w-full flex items-center mt-2 h-8 px-3 py-2 border border-[#515561] border-solid rounded-lg">
                  {{ toTime }}
                </div>
              </div>              
              <div class="flex flex-col ml-4 w-[52px]" >
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
              <div class="flex">
                <span>Имя</span>
                <div data="name-error-text" class="flex hidden text-[#E1183D]"><img src="/img/attentionRed.svg"
                    class="mx-2 w-4">Не заполнено</div>
                <div data="name-succes-text" class="flex hidden"><img src="/img/checkcircle.svg" class="ml-2 w-4"></div>
              </div>
              <input data="name-input" placeholder="Как к вам обращаться"
                class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]" wfd-id="id4">
              <div class="flex mt-3">
                <span>Телефон</span>
                <div data="phone-error-text" class="flex hidden text-[#E1183D]"><img src="/img/attentionRed.svg"
                    class="mx-2 w-4">Не заполнено</div>
                <div data="phone-succes-text" class="flex hidden"><img src="/img/checkcircle.svg" class="ml-2 w-4"></div>
              </div>
              <input data="phone-input" placeholder="+7 (___) ___ __ __"
                class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]" wfd-id="id5">
            </div>
            <div class="flex flex-col mt-4 lg:mt-0 lg:ml-4 flex-1">
              <span>Комментарий</span>
              <textarea placeholder="Напишите ваши пожелания"
                class="w-full px-3 py-2 lg:!h-full mt-2 bg-white rounded-[8px] resize-none"></textarea>
            </div>
          </div>
        </div>
        <div class="flex flex-col lg:flex-row items-center p-4 rounded-b-3xl bg-white mx-6 lg:mx-0">
          <span class="lg:w-1/2 lg:max-w-[300px] text-[10px] text-center lg:text-left">Нажимая «Забронировать» вы даёте
            согласие на обработку персональных данных и соглашаетесь c <a class="underline" href="#">пользовательским
              соглашением</a> и <a class="underline" href="#">политикой конфиденциальности</a>.</span>
          <span class="mt-4 lg:ml-4 lg:mt-0">Сумма к оплате: <b class="text-sm">{{ amount }} ₽</b></span>
          <button data="booking-submit"
            class="mt-4 lg:ml-auto lg:mt-0 w-full flex items-center justify-center h-12 lg:w-[248px] rounded-lg bg-[#AAB4D1] text-white">Забронировать</button>
        </div>
      </div>
      <div data="booking-success"
        class="hidden mt-[20vh] lg:m-0 lg:w-[800px] lg:h-[374px] flex flex-col relative items-center justify-center bg-white rounded-3xl p-6 overflow-hidden">
        <img src="/img/bookingSuccess.svg" class="hidden lg:block absolute top-[-51px] left-[17px]">
        <img src="/img/bookingSuccess.svg" class="hidden lg:block absolute bottom-[-42px] right-[63px]">
        <h4 class="text-[1.375rem] lg:text-[28px] font-semibold">Бронирование № 202200006</h4>
        <span class="text-center mt-6 text-sm leading-4 z-[1]">
          Поздравляем!
          <br>Вы забронировали Отель «De Art 13 Новокосино» номер "Свадебный Delux на 1 сутки".
          <br>Дата заезда: 05.12.2022. 22:00.
          <br>Дата выезда: 06.12.2022. 22:00.
          <br>По адресу: Москва, ВАО, Косино-Ухтомский район, ул Наташи Качуевской, д.4.
          <br>Администрация «De Art 13 Новокосино» свяжется с Вами для подтверждения бронирования.
          <br>Ждем Вас и приятного отдыха.
          <button data="booking-close"
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

export default {
  components: {
    DatePicker,
    TimePicker,
    NumSelect,
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
  },
  emits: ['close'],
  data() {
    return {
      costType: 1,      
      fromDate: null,
      fromTime: null, 
      toDate: null,
      toTime: null,               
      startAtHours: 1,
      endAtHours: 6,
      hours: 0,
      days: 0,
      price: 0,
      quantity: 0,
      cost: null,            
    }
  },  
  computed: {    
    amount() {
      return this.price * this.quantity;
    }
  },
  methods: {
    close() {
      this.$emit('close');
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
          let timeString = new Date().toLocaleTimeString('ru-Ru');
          let timeStrSplited = timeString.split(":");          
          this.fromTime = timeStrSplited[0] + ':' + timeStrSplited[1];
          
          this.startAtHours = cost?.period?.start_at ?? 1;
          this.hours = this.startAtHours;
        } 
        
        if (typeId == 2) {
          this.fromTime = cost.period.start_at;          
        }
        
        if (typeId == 3) {
          this.fromTime = cost.period.start_at;
          this.days = this.days > 0 ? this.days : 1;         
        }
        
        this.calculateDateOut();
      }
    },
    selectHours(hours) {
      this.hours = hours;           
      this.calculateDateOut();
    },
    selectDays(days) {
      this.days = days;
      this.calculateDateOut();
    },
    calculateDateOut() {
        if (this.costType == 1) {
          this.quantity = this.days;
          let momentToDateTime = moment(this.fromDate + ' ' + this.fromTime, 'DD.MM.YYYY HH:mm').add(this.hours, 'hours');
          this.toTime = momentToDateTime.format('HH:mm');        
          this.toDate = momentToDateTime.toDate().toLocaleDateString('ru-RU');
        } 
        
        if (this.costType == 2) {
          this.toDate = moment(this.fromDate, 'DD.MM.YYYY').add(1, 'days').toDate().toLocaleDateString('ru-RU');
          this.toTime = this.cost.period.end_at;
          this.quantity = 1;
        }
        
        if (this.costType == 3) {
          this.quantity = this.days;
          this.toDate = moment(this.fromDate, 'DD.MM.YYYY').add(this.days, 'days').toDate().toLocaleDateString('ru-RU');
          this.toTime = this.cost.period.end_at;
        }    
    }, 
    getNumsRange(from, to) {    
      let hours = _.transform(_.range(from, to + 1, 1), function(result, n) {
        let obj = {
          key: n,
          name: n
        };
        result.push(obj);
        return obj;
      }, []);

      return hours;
    }
  }

};
</script>
