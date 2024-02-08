<template>
  <AppHead title="Gorooms.ru" />
  <div
		class="fixed top-0 left-0 z-50 bg-[#D2DAF0B3] w-full h-[100%] backdrop-blur-[2.5px] flex flex-col justify-center items-center pt-[70px] pb-[104px]">
		<div class="max-w-[432px] w-full flex flex-col">
      <Link as="button" href="/"
				class="absolute top-[12px] right-[16px] lg:static lg:w-[32px] lg:h-[32px] lg:p-2 lg:bg-white lg:rounded-lg lg:ml-auto lg:mr-[-48px]">
			  <img src="/img/close.svg" alt="close">
			</Link>			
			<div class="bg-white rounded-3xl mx-6 lg:mx-0 block">
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
          <div class="flex mt-2">
						<span>Пароль</span>
            <div v-if="reset?.errors?.password" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
              {{ reset?.errors?.password }}
						</div>
					</div>
          <input name="password" type="password" placeholder="*******" v-model="reset.password"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
            <div class="flex mt-2">
						<span>Пароль</span>
            <div v-if="reset?.errors?.password_confirmation" class="text-[#E1183D] flex items-start text-sm" style="margin-top: 2px;">
              <img src="/img/attentionRed.svg" class="flex mx-2 w-4" style="margin-top: 1px;">
              {{ reset?.errors?.password_confirmation }}
						</div>
					</div>
          <input name="password_confirm" type="password" placeholder="*******" v-model="reset.password_confirmation"
						class="w-full h-8 rounded-md py-2 px-2 placeholder-zinc-500">
          <input type="hidden" name="token" v-model="reset.token">      
					<Button class="p-2 mt-4" submit="true" :disabled="reset.processing">Установить новый пароль</Button>
				</form>

				<div v-if="reset.wasSuccessful" class="flex flex-col p-6 lg:p-4">
					<span class="text-center leading-4 z-[1] p-2">
					  Ссылка на сброс пароля была отправлена!
					</span>
					<Link href="/" @click="" class="p-2 mt-4 h-[48px] px-[16px] text-center flex items-center justify-center flex-grow gap-[8px] text-white rounded-md transition duration-150 undefined bg-blue-500 hover:bg-blue-800">На главную</Link>
				</div>
			</div>
		</div>		
	</div>
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import { useForm } from "@inertiajs/vue3";
import Button from "@/components/ui/Button.vue"
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    AppHead,
    Layout,
    useForm,
    Button,
    Link,   
  },
  data() {
    return {      
      reset: useForm({
        email: this.$page.props.email,
        password: null,
        password_confirmation: null,
        token: this.$page.props.token, 
      }),
    }
  },
  methods: {
    submitReset() {
      console.log('submit reset');
      this.reset.post("/password/reset", {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'errors'],
      });
    },
  }  
};
</script>
