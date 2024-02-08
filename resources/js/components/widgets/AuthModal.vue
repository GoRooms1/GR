<template>
	<div id="auth"
		class="fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] backdrop-blur-[2.5px] flex flex-col justify-center items-center pt-[70px] pb-[104px]">
		<div class="max-w-[432px] w-full flex flex-col">
			<button @click="$eventBus.emit('auth-close')"
				class="absolute top-[12px] right-[16px] lg:static lg:w-[32px] lg:h-[32px] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
			<img src="/img/close.svg" alt="close">
			</button>
			<div v-if="tab !== 'reset'" class="bg-white rounded-3xl mx-6 lg:mx-0">
				<div class="flex bg-[#6170FF] rounded-t-3xl">
					<button
						class="p-2 my-4 ml-4 mr-2 flex w-full items-center justify-center rounded-lg bg-[#6170FF] text-white border-white border-2">Вход</button>
					<button
						class="p-2 my-4 mr-4 ml-2 flex w-full items-center justify-center rounded-lg bg-white text-[#6170FF]">Регистрация</button>
				</div>
				<form id="login-form" class="flex flex-col p-6 lg:p-4" @submit.prevent="submitLogin">
					<div class="flex ml-auto items-center">
						<span class="flex mr-2">
						  Отельер
						</span>
						<input v-model="login.hotelier" name="is_otel" type="checkbox" class="flex w-5 h-5 accent-[#6170FF]">
					</div>
					<div class="flex mt-2 items-start" v-if="login?.hotelier">
						<span>Email</span>
						<div v-if="login?.errors?.email" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
              {{ login?.errors?.email }}
						</div>						
					</div>
					<input v-if="login?.hotelier" name="email" type="email" placeholder="Ваша@почта" v-model="login.email"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<div class="flex mt-2" v-if="!login?.hotelier">
						<span>Телефон</span>
						<div v-if="login?.errors?.phone" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="padding-top: 1px;">
              {{ login?.errors?.phone }}
						</div>
					</div>
					<input v-if="!login?.hotelier" name="phone" type="text"
            @input="phoneHandle"
            v-maska
            :data-maska="phoneMask"
            placeholder="+7 (___) ___ __-__"
            data-maska-tokens="C:[0-9 \-\+()]" 
            v-model="login.phone"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 ">
					<div class="flex mt-2">
						<span>Пароль</span>
						<div v-if="login?.errors?.password" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="padding-top: 1px;">
              {{ login?.errors?.password }}
						</div>
					</div>
					<input name="password" type="password" placeholder="*******" v-model="login.password"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<div class="flex mt-4 text-sm">
						<span>Забыли пароль?&nbsp;</span>
						<button type="button" @click="tab = 'reset'" class="underline">Восстановить пароль через email</button>
					</div>
					<Button class="mt-4" submit="true" :disabled="login.processing">Войти</Button>
				</form>

				<form id="registration-form" class="flex flex-col p-6 lg:p-4 hidden">
					<div class="flex mt-2">
						<span>Имя</span>
					</div>
					<input name="name" type="text" placeholder="Как к вам обращаться"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<div class="flex mt-2">
						<span>Телефон</span>
					</div>
					<input name="phone" type="text" placeholder="+7 (___) ___ __-__"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<div class="flex mt-2">
						<span>Email</span>
					</div>
					<input name="email" type="email" placeholder="Ваша@почта"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<div class="flex mt-2">
						<span>Пол</span>
					</div>
					<input name="gender" type="text" class="hidden" value="m">
					<div class="flex w-full">
						<button
							class="mr-4 flex-1 lg:flex-none text-[0.875rem] leading-[1rem] px-[19px] h-[2rem] flex items-center justify-center rounded-[8px] md:hover:outline outline-solid hover:outline-[#6170FF] outline transition duration-150 bg-[#6170FF] text-white outline-[#6170FF]">М</button>
						<button
							class="mr-4 flex-1 lg:flex-none text-[0.875rem] leading-[1rem] px-[19px] h-[2rem] flex items-center justify-center rounded-[8px] md:hover:outline outline-solid hover:outline-[#6170FF] outline transition duration-150 bg-white outline-[#AAB4D1]">Ж</button>
					</div>
					<div class="flex mt-2">
						<span>Пароль</span>
					</div>
					<input name="password" type="password" placeholder="*******"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<div class="flex mt-2">
						<span>Повторите пароль</span>
					</div>
					<input name="password-confirm" type="password" placeholder="*******"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<button
						class="p-2 mt-4 w-full flex items-center justify-center rounded-lg bg-[#AAB4D1] text-white">Зарегистрироваться</button>
				</form>
			</div>

			<div v-if="tab === 'reset'" class="bg-white rounded-3xl mx-6 lg:mx-0 block">
				<div class=" bg-[#6170FF] rounded-t-3xl text-white p-4 text-center">
					Сброс пароля
				</div>
				<form v-if="!reset.wasSuccessful" id="password-reset-form" class="flex flex-col p-6 lg:p-4" @submit.prevent="submitReset">
					<div class="flex mt-2">
						<span>Email</span>
            <div v-if="reset?.errors?.email" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
              {{ reset?.errors?.email }}
						</div>
					</div>
					<input name="email" type="email" placeholder="Ваша@почта" v-model="reset.email"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<Button class="p-2 mt-4" submit="true" :disabled="reset.processing">Отправить ссылку для сброса пароля</Button>
				</form>

				<div v-if="reset.wasSuccessful" class="flex flex-col p-6 lg:p-4">
					<span class="text-center leading-4 z-[1] p-2">
					  Ссылка на сброс пароля была отправлена!
					</span>
					<Link href="/" @click="$eventBus.emit('auth-close')" class="p-2 mt-4 h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-blue-500 hover:bg-blue-800">На главную</Link>
				</div>
			</div>
		</div>		
	</div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import Button from "@/components/ui/Button.vue"
import { vMaska } from "maska";
import { Link } from "@inertiajs/vue3";
export default {
  components: {
    useForm,
    Button,
    Link
  },
  directives: {
    maska: vMaska,
  },
  mounted() {
    console.log("Auth mounted.");
  },
  data() {
    return {
      tab: "login",
      phoneMask: "+7 (###) ### ##-##",
      login: useForm({
        phone: null,
        email: null,
        password: null,
        hotelier: false,        
      }),
      reset: useForm({
        email: null,       
      }),
    }
  },
  methods: {
    resetForms() {
      this.tab = "login";
      this.login = useForm({
        phone: null,
        email: null,
        password: null,
        hotelier: false,        
      });
      this.login.clearErrors();
      this.reset = useForm({
        email: null,       
      });
      this.reset.wasSuccessful = false;
      this.reset.clearErrors();
    },
    phoneHandle(e) {
      let value = e.target.value ?? "";
      //Handle Ru phone number
      if (value == null || value == '' || value.startsWith("+7")) {
        this.phoneMask = "+7 (###) ### ##-##";
      }

      //Handle other countries phone number
      if (value === "+") {
        this.phoneMask = "C".repeat(25);
      }
    },
    submitLogin() {
      console.log('submit login');
      this.login.post("/login", {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'errors'],
        onSuccess: () => {
          this.resetForms();
        }
      });
    },
    submitReset() {
      console.log('submit reset');
      this.reset.post("/password/email", {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'errors'],
      });
    },
  }
};
</script>
