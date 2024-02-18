<template>
  <div class="fixed px-[1.625rem] pb-[1.625rem] xs:pt-[2.25rem] sm:pt-[3.75rem] pt-[1.75rem] lg:p-0 lg:fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] lg:h-[100vh] backdrop-blur-[2.5px] flex flex-col lg:justify-center items-center overflow-y-auto">
    <div class="max-w-[800px] flex flex-col w-full lg:mb-[160px]">
      <button @click="close" class="absolute top-[12px] right-[0.85rem] lg:static lg:w-[2rem] lg:h-[2rem] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
        <img src="/img/close.svg">
      </button>
      <form v-if="!reviewForm.wasSuccessful"  @submit.prevent="submitReview">        
        <div class="bg-[#EAEFFD] flex flex-col w-full p-6 pt-4 lg:p-4 z-[1] shadow-md lg:shadow-none rounded-t-3xl rounded-b-3xl lg:rounded-b-none mt-6 lg:mt-0">          
          <span class="text-[#515561]">Рейтинг</span>
          <div class="grid grid-cols-2 grid-rows-3 gap-[24px] mt-2">
            <div v-for="category in ratingCategories" :key="category.id" class="flex h-[26px] justify-between relative">
              <div class="text-xs">{{ category.name }}</div>
              <div class="text-xs">{{ reviewForm.rating.find(e => e.id === category.id).value }}</div>
              <input type="range" min="0" max="10" step="0.1" v-model="reviewForm.rating.find(e => e.id === category.id).value" class="absolute bottom-0 left-0 h-[4px] w-full raiting-range">
            </div>            
          </div>
          <div class="flex flex-col lg:flex-row mt-4 text-sm text-[#515561]">
            <div class="flex flex-col mt-2 lg:mt-0 lg:mr-2 w-full">
              <div class="flex">
                <span>Имя</span>
                <div v-if="reviewForm?.errors?.name" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                  <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                  {{ reviewForm?.errors?.name }}
                </div>              
              </div>
              <input v-model="reviewForm.name" placeholder="Как к вам обращаться" class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]">
              <div class="flex mt-2">
                <span>Номер бронирования</span>
                <div v-if="reviewForm?.errors?.book_number" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                  <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                  {{ reviewForm?.errors?.book_number }}
                </div>
              </div>
              <input v-model="reviewForm.book_number" placeholder="Номер" class="w-full px-[12px] h-8 mt-2 bg-white rounded-[8px]">
              <div class="flex mt-2">
                <span>Комментарий</span>
                <div v-if="reviewForm?.errors?.comment" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                  <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                  {{ reviewForm?.errors?.comment }}
                </div>
              </div>              
              <textarea v-model="reviewForm.comment" placeholder="Напишите ваши пожелания" class="w-full px-3 py-2 mt-2 flex-1 bg-white rounded-[8px] resize-none"></textarea>
            </div>
            <div class="flex flex-col mt-2 lg:mt-0 lg:ml-2 w-full">
              <div class="flex">
                <span>Фото</span>
                <div v-if="reviewForm?.errors?.photo" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                  <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                  {{ reviewForm?.errors?.photo }}
                </div>
              </div>
              <div @click="$refs.photo.click()" class="flex w-full h-full p-4 mt-2 bg-white border-dashed border-2 rounded-lg items-center mx-auto text-center cursor-pointer">
                <img v-if="preview" :src="preview" class="rounded-lg mx-auto w-full" alt="preview">
                <input @change="showFilePreview($event); reviewForm.photo = $event.target.files[0];" ref="photo" id="photo" type="file" class="hidden" accept="image/*">
                <label v-if="!preview" class="cursor-pointer">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-700 mx-auto mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"></path>
                  </svg>
                  <h5 class="mb-2 text-xl font-bold tracking-tight ">Загрузить фотографию</h5>
                  <p class="font-normal text-sm text-gray-400 md:px-6">Размер выбранного фото не должен превышать <b class="text-gray-600">10mb</b></p>
                  <p class="font-normal text-sm text-gray-400 md:px-6">и должен быть в формате <b class="text-gray-600">JPG, PNG, или GIF</b></p>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="px-4 py-2 rounded-b-3xl bg-white mx-6 lg:mx-0">
          <Button classes="flex w-full lg:w-[248px] lg:ml-auto lg:mt-0" submit="true" :disabled="reviewForm.processing">Оставить отзыв</Button>        
        </div>
      </form>

      <div v-if="reviewForm.wasSuccessful" class="mt-[20vh] lg:m-0 lg:w-[800px] lg:h-[374px] flex flex-col relative items-center justify-center bg-white rounded-3xl p-6 overflow-hidden">
        <img src="/img/bookingSuccess.svg" class="hidden lg:block absolute top-[-51px] left-[17px]">
        <img src="/img/bookingSuccess.svg" class="hidden lg:block absolute bottom-[-42px] right-[63px]">
        <h4 class="text-[1.375rem] lg:text-[28px] font-semibold">Отзыв</h4>
        <span class="flex flex-col text-center mt-6 text-sm leading-4 z-[1]">
          {{$page.props.flash.message}}
          <Button @click="close" classes="lg:hidden mt-2">Закрыть</Button>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import Button from "@/components/ui/Button.vue"
export default {
  components: {
    useForm,
    Button,
  },
  emmits: ["form-closed"],
  props: {
    booking: Object,
    ratingCategories: [Object]
  },
  data() {
    return {      
      reviewForm: useForm({
        rating: this.getDefRatingValues(),
        booking_id: this.booking.id,        
        book_number: this.booking.book_number,
        comment: null,
        name: this.$page.props.user.name,
        photo: null,
      }),
      preview: null,
    }
  },
  methods: {
    getDefRatingValues() {      
      let rating = [];

      this.ratingCategories.forEach(el => {
        rating.push({
          id: el.id,
          value: 10,
        });       
      });

      return rating;
    },
    showFilePreview(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) {this.preview = null; return;}
      this.preview = URL.createObjectURL(files[0]);
    },
    close() {
      this.$emit('form-closed');
    },
    submitReview() {      
      this.reviewForm.post("/client/review", {
        forceFormData: true,
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'errors', 'bookings'],
      }); 
    }, 
  },
};
</script>
