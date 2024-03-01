<template>
  <AppHead title="Gorooms.ru" />
  <Menu/>
  <div class="container mx-auto py-4 min-[1920px]:px-[10vw] z-10">
        <div class="mb-4 px-2 flex flex-wrap">          
            <form class="flex w-full lg:w-6/12 px-3" @submit.prevent="submitUpdate">
              <div v-show="!saveSuccess" class="w-full bg-white rounded-3xl p-4 flex flex-col">
                <h3 class="font-semibold text-base mb-4">
                    Настройки аккаунта
                </h3>
                <div class="flex-wrap lg:flex text-sm leading-4">
                  <div class="flex my-2">
                      <span>Почта</span>
                      <div v-if="!user.email_verified && !userForm?.errors?.email" class="text-[#E1183D] flex items-start text-sm">
                          <img src="/img/attentionRed.svg" class="flex mx-2 w-4">
                          Подтвердите e-mail чтобы оставлять отзывы
                      </div>
                      <div v-if="userForm?.errors?.email" class="text-[#E1183D] flex items-start text-sm">
                          <img src="/img/attentionRed.svg" class="flex mx-2 w-4">
                          {{ userForm?.errors?.email }}
                      </div>
                  </div>
                  <div class="w-full flex">
                      <input :disabled="user.email != null" name="email" type="email" placeholder="Ваша@почта" v-model="userForm.email" 
                        class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500"
                        :class="user.email != null ? 'bg-[#e5e7eb]' : ''"
                      >
                      <button v-if="!user.email_verified && user.email" @click="submitEmailVerify" 
                        class="w-1/3 py-2 px-2 ml-2 text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-green-500 hover:bg-green-800" type="button"
                        :class="user.can_resend_verification ? '' : 'pointer-events-none btn-disabled'"
                      >
                        Подвердить
                      </button>
                  </div>
                  <div class="flex my-2">
                    <span>Имя</span>
                    <div v-if="userForm?.errors?.name" class="text-[#E1183D] flex items-start text-sm">
                      <img src="/img/attentionRed.svg" class="flex mx-2 w-4">
                      {{ userForm?.errors?.name }}
                    </div>
                  </div>
                  <input name="name" type="text" placeholder="Как к вам обращаться" v-model="userForm.name" class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">                       
                  <div class="flex my-2">
                      <span>Телефон</span>                           
                  </div>
                  <span class="flex w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 bg-[#e5e7eb]">{{ user.phone_hidden }}</span>
                  <div class="flex my-2">
                    <span>Пол</span>
                    <div v-if="userForm?.errors?.gender" class="text-[#E1183D] flex items-start text-sm">
                      <img src="/img/attentionRed.svg" class="flex mx-2 w-4">
                      {{ userForm?.errors?.gender }}
                    </div>
                  </div>
                  <input name="gender" type="text" class="hidden" v-model="userForm.gender">
                  <div class="flex w-full">
                    <button type="button"
                      @click="userForm.gender = 'm'"
                      class="mr-4 flex-1 lg:flex-none text-[0.875rem] leading-[1rem] px-[19px] h-[2rem] flex items-center justify-center rounded-[8px] md:hover:outline outline-solid hover:outline-[#6170FF] outline transition duration-150"
                      :class="userForm.gender === 'm' ? 'bg-[#6170FF] text-white outline-[#6170FF]' : ' bg-white outline-[#AAB4D1]'">М</button>
                    <button type="button"
                      @click="userForm.gender = 'f'"
                      class="mr-4 flex-1 lg:flex-none text-[0.875rem] leading-[1rem] px-[19px] h-[2rem] flex items-center justify-center rounded-[8px] md:hover:outline outline-solid hover:outline-[#6170FF] outline transition duration-150"
                      :class="userForm.gender === 'f' ? 'bg-[#6170FF] text-white outline-[#6170FF]' : ' bg-white outline-[#AAB4D1]'">Ж</button>
                  </div>
                  <div class="flex my-2">
                      <span>Придумайте новый пароль</span>
                      <div v-if="userForm?.errors?.password" class="text-[#E1183D] flex items-start text-sm">
                          <img src="/img/attentionRed.svg" class="flex mx-2 w-4">
                          {{ userForm?.errors?.password }}
                      </div>
                  </div>
                  <input name="password" type="password" placeholder="*****" v-model="userForm.password" class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 ">
                  <div class="flex my-2">
                      <span>Повторите пароль</span>
                      <div v-if="userForm?.errors?.password_confirmation" class="text-[#E1183D] flex items-start text-sm">
                          <img src="/img/attentionRed.svg" class="flex mx-2 w-4">
                          {{ userForm?.errors?.password_confirmation }}
                      </div>
                  </div>
                  <input name="password_confirmation" type="password" placeholder="*****" v-model="userForm.password_confirmation" class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 ">
                  <div class="flex items-center my-2 w-full">
                      <input name="notify_review" type="checkbox" v-model="userForm.notify_review" class="flex w-5 h-5 accent-[#6170FF]">
                      <span class="flex ml-2">Уведомлять о возможности оставить отзыв по смс</span>
                  </div>
                  <div class="flex items-center my-2 w-full">
                      <input name="notify_hot" type="checkbox" v-model="userForm.notify_hot" class="flex w-5 h-5 accent-[#6170FF]">
                      <span class="flex ml-2">Уведомлять об акциях и горящих предложениях по e-mail</span>
                  </div>
                  
                  <Button 
                    class="w-full mt-4" 
                    :disabled="userForm.processing"
                    submit="true"
                  >
                    Сохранить
                  </Button>
                </div>                    
              </div>
              <div v-show="saveSuccess" class="w-full bg-white rounded-3xl p-4 flex flex-col items-center text-center">
                <div class="w-full flex justify-end">
                  <button type="button" @click="saveSuccess = false; $page.props.flash.message = null;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_228_7234)">
                        <path d="M2 2L22 22" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                        <path d="M2 22L22 2" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                      </g>
                      <defs>
                        <clipPath id="clip0_228_7234">
                          <rect width="24" height="24" fill="white"></rect>
                        </clipPath>
                      </defs>
                    </svg>
                  </button>                  
                </div>
                <div class="flex items-center justify-center font-semibold pb-4 h-full">
                  <span class="flex">{{ $page.props.flash.message }}</span>                  
                </div>                
              </div>
            </form>
            <div  class="lg:w-6/12 w-full px-3 my-4 lg:my-0">
                <div class=" bg-white rounded-3xl p-4 flex flex-col">
                    <h3 class="font-semibold text-base mb-4">
                        Действия с аккаунтом
                    </h3>
                    <button @click="$inertia.post('/logout')" class="w-full mt-4 h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-blue-500 hover:bg-blue-800" type="submit">
                      Выйти из аккаунта
                    </button>
    
                    <button @click="openDeleteUserDialog" class="w-full mt-4 h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-red-500 hover:bg-red-800" type="submit">
                      Удалить аккаунт
                    </button>
                </div>
            </div>            
        </div>   
    </div>  
</template>

<script>
import Button from "@/components/ui/Button.vue"
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import Menu from "./partials/Menu.vue";
import { useForm } from "@inertiajs/vue3";

export default {
  components: {
    AppHead,
    Layout,
    Menu, 
    useForm,
    Button,  
  },
  props: {
    user: Object,
  },
  data() {
    return {
      userForm: useForm({
        phone: this.user.phone,
        name: this.user.name,
        email: this.user.email,
        gender: this.user.gender,
        password: null,
        password_confirmation: null,
        notify_review: this.user.notify_review,
        notify_hot: this.user.notify_hot
      }),      
      saveSuccess: false,
      verifyProcessing: false,
    }
  },
  mounted() {
    this.validateUserForm();
  },
  methods: {
    validateUserForm(){      
      this.userForm.errors = {};
      if (this.user.need_change_password && !this.userForm.password) this.userForm.errors.password = "Рекомендуем сменить пароль";
      if (!this.userForm.email) this.userForm.errors.email = "Не заполнено";
      if (!this.userForm.gender) this.userForm.errors.gender = "Не заполнено";
      if (!this.userForm.name) this.userForm.errors.name = "Не заполнено";
    },
    submitUpdate() {      
      this.userForm.post("/client/settings/update", {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'user', 'errors'],
        onSuccess: () => {
          this.saveSuccess = true;
          this.userForm.password = null;
          this.userForm.password_confirmation = null;
        }
      });
    },
    submitEmailVerify() {
      this.$inertia.post("/email/resend", {}, {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'user', 'errors'],
        onStart: () => {
          this.verifyProcessing = true;
        },
        onFinish: () => {
          this.verifyProcessing = false;          
        },
        onSuccess: () => {          
          this.saveSuccess = true;
        }        
      });
    },
    openDeleteUserDialog() {
      if (confirm("Вы уверены что хотите полностью удалить аккаунт "+this.user.name+", без возможности восстановления?")) {
        this.deleteUser();
      }
    },
    deleteUser() {
      this.$inertia.post("/client/delete/resend", {}, {
        preserveState: true,
        preserveScroll: true,        
        onError: () => {
          alert("Ошибка во время удаления!");
        },
        onSuccess() {
          alert("Вам на почту отправлено письмо со ссылкой, пройдя по которой Ваш аккаунт будем полностью удален. Спасибо.");
        }         
      })
    }
  }
};
</script>
