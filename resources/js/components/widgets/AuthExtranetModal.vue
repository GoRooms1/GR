<template>
	<div id="auth-extranet"
		class="fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] backdrop-blur-[2.5px] flex flex-col justify-center items-center" style="padding-top: 40px;">
		<div class="w-full flex flex-col pb-2 overflow-y-auto lg:overflow-visible" :style="'max-width: ' + (tab === 'register' ? '900px' : '432px') + ' ;'">
			<button @click="$eventBus.emit('auth-extranet-close')"
				class="absolute top-[12px] right-[16px] lg:static lg:w-[32px] lg:h-[32px] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
			<img src="/img/close.svg" alt="close">
			</button>
			<div v-if="tab !== 'reset'" class="bg-white rounded-3xl mx-6 lg:mx-0">        
				<div class="bg-orange-400 rounded-t-3xl">
          <div class="flex">
            <span class="p-2 my-2 mb-4 ml-4 mr-2 flex w-full items-center justify-center text-white text-xl">Отельер</span>
            <Link @click="$eventBus.emit('auth-extranet-close')" href="/instructions"
              class="p-2 my-2 mb-4 mr-4 ml-2 flex w-full items-center justify-center rounded-lg bg-orange-400 text-white border-white border-2 hover:bg-white hover:text-orange-400"
            >
              Инструкции
            </Link>
          </div>          
          <div class="flex">
            <button @click="tab = 'login'"
              class="p-2 my-2 mb-4 ml-4 mr-2 flex w-full items-center justify-center rounded-lg"
              :class="tab === 'login' ? 'bg-white text-orange-400' : 'bg-orange-400 text-white border-white border-2 hover:bg-white hover:text-orange-400'">Вход</button>
            <button @click="tab = 'register'"
              class="p-2 my-2 mb-4 mr-4 ml-2 flex w-full items-center justify-center rounded-lg"
              :class="tab === 'register' ? 'bg-white text-orange-400' : 'bg-orange-400 text-white border-white border-2 hover:bg-white hover:text-orange-400'">Регистрация</button>
          </div>
				</div>       
				<form v-if="tab === 'login'" id="login-extranet-form" class="flex flex-col p-6 lg:p-4" @submit.prevent="submitLogin">					
          <input v-model="login.hotelier" name="hotelier" type="checkbox" class="w-5 h-5 accent-[#6170FF] hidden">          
					<div class="flex mt-2 items-start">
						<span>Email</span>
						<div v-if="login?.errors?.email" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
              {{ login?.errors?.email }}
						</div>						
					</div>
					<input v-if="login?.hotelier" name="email" type="email" placeholder="Ваша@почта" v-model="login.email"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">					
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
					<Button class="mt-4" submit="true" type="orange" :disabled="login.processing">Войти</Button>
          <span class="mt-4 text-sm">Нажимая "Регистрация", вы <Link href="/privacy-policy" class="underline">соглашаетесь с политикой хранения и обработкой персональных данных.</Link></span>
				</form>

				<form v-if="tab === 'register'" id="register-extranet-form" class="flex flex-wrap p-6 lg:p-4 -mx-4"  @submit.prevent="submitRegister">
					<div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>ФИО</span>
              <div v-if="register?.errors?.name" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors?.name }}
              </div>
            </div>
            <input name="name" type="text" placeholder="Как к вам обращаться" v-model="register.name"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto">
          </div>
          <div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>Телефон</span>
              <div v-if="register?.errors?.phone" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors?.phone }}
              </div>
            </div>
            <input name="phone" type="text"
              @input="phoneHandle"
              v-maska
              :data-maska="phoneMask"
              placeholder="+7 (___) ___ __-__"
              data-maska-tokens="C:[0-9 \-\+()]"
              v-model="register.phone"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto">
          </div>
					<div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>Должность</span>
              <div v-if="register?.errors?.position" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors?.position }}
              </div>
            </div>
            <input name="position" type="text" placeholder="Должность" v-model="register.position"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto">
          </div>
          <div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>Email</span>
              <div v-if="register?.errors?.email" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors?.email }}
              </div>
            </div>
            <input name="email" type="email" placeholder="Ваша@почта" v-model="register.email"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto">
          </div>					
          <div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>Пароль</span>
              <div v-if="register?.errors?.password" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors?.password }}
              </div>
            </div>
            <input name="password" type="password" placeholder="*******" v-model="register.password"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto">
          </div>
          <div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>Код</span>
              <div v-if="register?.errors?.code" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors?.code }}
              </div>
            </div>
            <input name="code" type="text" placeholder="Придумайте кодовое слово" v-model="register.code"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto">
          </div>						
					<div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>Объект</span>
              <div v-if="register?.errors['hotel.name']" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors['hotel.name'] }}
              </div>
            </div>
            <input name="hotel[name]" type="text" placeholder="Название объекта размещения" v-model="register.hotel.name"
              class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto">	
          </div>          
					<div class="w-full lg:w-1/2 px-4 flex flex-col">
            <div class="flex mt-2">
              <span>Тип объекта</span>
              <div v-if="register?.errors['hotel.type']" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors['hotel.type'] }}
              </div>
            </div>         
            <form-select
              not-null                  
              placeholder="Тип объекта"
              v-model="register.hotel.type"
              :options-array="$page.props.hotel_types ?? []"                                        
            />
          </div>
          <div class="w-full px-4">           
            <div class="flex mt-2">
              <span>Адрес объекта</span>
              <div v-if="register?.errors?.address" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
                <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
                {{ register?.errors?.address }}
              </div>
            </div>
            <vue-dadata 
              :token="$page.props.dadata_token"
              :url="$page.props.dadata_suggest_url"
              input-name="address"
              placeholder="Начните вводить адрес"              
              v-model="register.address"
              v-model:suggestion="dadataSuggestion"
              :highlight-options="{
                caseSensitive: false,
                splitBySpace: false,
                highlightTag: 'mark',
                highlightClass: 'bg-[#eaeffd]',
                highlightStyle: '',
                wrapperTag: 'span',
                wrapperClass: '',
              }"
              :classes="{
                container: 'relative w-full',
                search: '',
                input: 'w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500 mt-auto',
                suggestions: 'vue-dadata__suggestions absolute z-10 w-full filter-scrollbar flex flex-col gap-[8px] rounded-[8px] bg-white px-[16px] overflow-y-auto',
                suggestionItem: 'vue-dadata__suggestion-item text-[14px] px-[8px] rounded-[8px] border border-solid border-transparent hover:border-[#6170FF] transition duration-150 cursor-pointer',
                suggestionCurrentItem: '',
              }"             
              ref="address"              
              @update:suggestion="updateDadatSuggestions()"
            />
          </div>          
          <Button class="mt-6 mx-4 w-full" submit="true" type="orange" :disabled="register.processing">Зарегистрироваться</Button>
          <span class="mt-4 text-sm mx-4 w-full">Нажимая "Зарегистрироваться", вы <Link href="/privacy-policy" class="underline">соглашаетесь с политикой хранения и обработкой персональных данных.</Link></span>          					
				</form>        
			</div>

			<div v-if="tab === 'reset'" class="bg-white rounded-3xl mx-6 lg:mx-0 block">
				<div class=" bg-orange-400 rounded-t-3xl text-white p-4 text-center">
					Сброс пароля
				</div>
				<form v-if="!reset.wasSuccessful" id="password-reset-extranet-form" class="flex flex-col p-6 lg:p-4" @submit.prevent="submitReset">
					<div class="flex mt-2">
						<span>Email</span>
            <div v-if="reset?.errors?.email" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
              {{ reset?.errors?.email }}
						</div>
					</div>
					<input name="email" type="email" placeholder="Ваша@почта" v-model="reset.email"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
					<Button class="p-2 mt-4" submit="true" type="orange" :disabled="reset.processing">Отправить ссылку для сброса пароля</Button>
				</form>

				<div v-if="reset.wasSuccessful" class="flex flex-col p-6 lg:p-4">
					<span class="text-center leading-4 z-[1] p-2">
					  Ссылка на сброс пароля была отправлена!
					</span>
					<Link href="/" @click="$eventBus.emit('auth-extranet-close')" class="p-2 mt-4 h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-orange-400 hover:bg-orange-500">На главную</Link>
				</div>
			</div>
		</div>    
	</div> 
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import Button from "@/components/ui/Button.vue";
import FormSelect from "@/components/ui/FormSelect.vue";
import { vMaska } from "maska";
import { Link } from "@inertiajs/vue3";
import { VueDadata } from 'vue-dadata';

export default {
  components: {
    useForm,
    Button,
    FormSelect,
    Link,
    VueDadata,
  },
  directives: {
    maska: vMaska,
  }, 
  data() {
    return {
      tab: this.$page.props.path === "/lk/start" ? "register" : "login",
      phoneMask: "+7 (###) ### ##-##",
      dadataSuggestion: {},
      login: useForm({
        phone: null,
        email: null,
        password: null,
        hotelier: true,        
      }),
      reset: useForm({
        email: null,       
      }),
      register: useForm({
        name: null,
        phone: null,
        email: null,
        position: null,
        password: null,
        code: null,
        hotel: {
          name: null,
          type: null,
        },
        address: '',
      }),      
    }
  },  
  methods: {
    updateDadatSuggestions() {
      this.$nextTick(() => {
        if (!this.dadataSuggestion?.data?.house && this.dadataSuggestion?.data) {        
          this.$refs.address.inputFocused = true;
          this.$refs.address.suggestionsVisible = true;
          this.register.address = this.register.address + ', ';          
        }

        if (!this.register?.address) {
          this.$refs.address.inputFocused = false;
          this.$refs.address.suggestionsVisible = false;         
        }
      });       
    },    
    resetForms() {
      this.tab = "login";
      this.login = useForm({
        phone: null,
        email: null,
        password: null,
        hotelier: true,        
      });
      this.login.clearErrors();

      this.reset = useForm({
        email: null,       
      });
      this.reset.wasSuccessful = false;
      this.reset.clearErrors();

      this.register = useForm({
        name: null,
        phone: null,
        email: null,
        position: null,
        password: null,
        code: null,
        hotel: {
          name: null,
          type: null,
        },
        address: '',
      });
      this.register.clearErrors();
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
      this.reset.post("/password/email", {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'errors'],       
      });
    },
    submitRegister() {      
      this.register.post("/lk/object/store", {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'errors'],
        onSuccess: () => {
          this.resetForms();          
        }
      });
    },
  }
};
</script>
