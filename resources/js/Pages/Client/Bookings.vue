<template>
  <AppHead title="Gorooms.ru" />
  <Menu/>
  <div class="filter h-40 pt-4 -mb-20 xl:pt-8">
    <div class="container mx-auto px-4 min-[1920px]:px-[10vw]">
      <div class="flex justify-between items-center">
        <span class="ml-5 text-white font-semibold text-[22px] lg:text-[28px]">Список Ваших бронирований</span>
      </div>
    </div>
  </div>
  <div class="container mx-auto px-4 relative z-10 min-[1920px]:px-[10vw] pb-[41px]">
    <div class="scrollbar relative overflow-x-auto shadow-md rounded-xl">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class=" text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Дата создания
            </th>
            <th scope="col" class="px-6 py-3">
              Номер бронирования
            </th>
            <th scope="col" class="px-6 py-3">
              Название отеля
            </th>
            <th scope="col" class="px-6 py-3">
              Номер
            </th>
            <th scope="col" class="px-6 py-3">
              Период
            </th>
            <th scope="col" class="px-6 py-3">
              Заезд
            </th>
            <th scope="col" class="px-6 py-3">
              Выезд
            </th>
            <th scope="col" class="px-6 py-3">
              ФИО
            </th>
            <th scope="col" class="px-6 py-3">
              Телефон
            </th>
            <th scope="col" class="px-6 py-3">
              Комментарий
            </th>
            <th scope="col" class="px-6 py-3 text-center">
              Статус
            </th>
            <th scope="col" class="px-6 py-3 text-center">
              Действия
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in (bookings?.data ?? [])" :key="booking.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td scope="col" class="px-6 py-3">
              {{ booking.created_at }}
            </td>
            <td scope="col" class="px-6 py-3 text-center">
              <span>{{ booking.book_number }}</span>
              <br>              
              <button
                v-if="$page.props.user.email_verified && booking?.status?.key == 'out' && booking.review_id == null"
                @click="openReviewForm(booking)" 
                class="font-medium text-orange-500 hover:underline"
              >
                Оставить отзыв
              </button>
            </td>
            <td class="px-6 py-4 text-center">
              <a :href="booking?.room?.hotel?.link" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ booking?.room?.hotel?.name }}</a>
            </td>
            <td scope="col" class="px-6 py-3">
              {{ booking?.room?.full_name }}
            </td>
            <td scope="col" class="px-6 py-3">
              {{ booking.book_type }}
            </td>
            <td scope="col" class="px-6 py-3">
              {{ booking.from_date }}
            </td>
            <td scope="col" class="px-6 py-3">
              {{ booking.to_date }}
            </td>
            <td scope="col" class="px-6 py-3">
              {{ booking.client_fio }}
            </td>
            <td scope="col" class="px-6 py-3">
              {{ booking.client_phone }}
            </td>
            <td scope="col" class="px-6 py-3 overflow-hidden">
              <span class="block overflow-hidden max-h-20">
                {{ booking.book_comment }}
              </span>
            </td>
            <td scope="col" class="px-6 py-3 text-center font-semibold" :class="getStatusClass(booking?.status?.key)">
              {{ booking?.status?.value }}
            </td>
            <td scope="col" class="px-6 py-3">
              <Button v-if="booking?.status?.key != 'cc' && booking?.status?.key !='ch'" @click="cancelBooking(booking.id)" :disabled="inProgress" classes="w-full py-2 px-2 ml-2 h-auto" type="red">
                Отменить
              </Button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mx-auto mt-8 w-full text-center"> 
      <Pagination :links="bookings.links" :meta="bookings.meta"/>
    </div>
  </div>
  <ReviewForm v-if="reviewOpened" :booking="bookingForReview" :ratingCategories="rating_categories" @form-closed="closeReviewForm"/>  
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import Menu from "./partials/Menu.vue";
import ReviewForm from "./partials/ReviewForm.vue";
import Button from "@/components/ui/Button.vue";
import Pagination from "@/components/ui/Pagination.vue";

export default {
  components: {
    AppHead,
    Layout,
    Menu,
    ReviewForm,
    Button,
    Pagination, 
  },
  props: {
    bookings: Object,
    rating_categories: [Object]
  },
  data() {
    return {
      reviewOpened: false,
      bookingForReview: null,
      inProgress: false,
    }
  },
  methods: {
    getStatusClass(status) {
      if (!status) return '';

      let map = {
        'wait' : 'text-gray-500',
        'in' : 'text-blue-600',
        'out' : 'text-green-500',
        'cc' : 'text-orange-500',
        'ch' : 'text-red-500'
      };
      
      return map[status];
    },
    openReviewForm(booking) {
      document.body.classList.add("fixed");
      this.bookingForReview = booking;
      this.reviewOpened = true;
    },
    closeReviewForm() {
      document.body.classList.remove("fixed");
      this.reviewOpened = false;
    },
    cancelBooking(booking_id) {
      this.$inertia.put('/client/bookings/'+booking_id+'/cancel', {}, {
        preserveState: false,
        preserveScroll: false,
        only: ['errors', 'message', 'bookings'],
        onStart: () => {
          this.inProgress = true;
        },
        onError: () => {
          alert("Ошибка!");
        },
        onFinish: () => {
          this.inProgress = false;
        },
      });
    }    
  }
};
</script>
