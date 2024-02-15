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
					Подтверждение Вашего Email адреса
				</div>
				<div id="password-reset-form" class="p-6 lg:p-4" @submit.prevent="submitResend">
          <div v-if="!wasSuccessful" class="flex flex-col">
            <span v-if="user.can_resend_verification" class="text-center leading-4 z-[1] p-2">Прежде чем продолжить, пожалуйста, проверьте свою электронную почту на наличие ссылки для подтверждения.</span>
            <span v-if="user.can_resend_verification" class="text-center leading-4 z-[1] p-2">Если вы не получили электронное письмо, нажмите кнопку ниже.</span>
            <span v-if="!user.can_resend_verification" class="text-center leading-4 z-[1] p-2">Ссылка для подтверждения email адреса была отправлена! Попробуйте сделать запрос позднее.</span>
          </div>
          <div v-if="wasSuccessful" class="flex flex-col">
            <span class="text-center leading-4 z-[1] p-2">
					    {{$page.props.flash.message}}
					  </span>
          </div>          
					<Button class="p-2 mt-4 w-full" @click="submitResend" :disabled="processing || !user.can_resend_verification">Запросить ссылку для подтверждения</Button>          
        </div>				
			</div>
		</div>		
	</div>
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import Button from "@/components/ui/Button.vue"
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    AppHead,
    Layout,    
    Button,
    Link,   
  },
  props: {
    user: Object,
  },
  data() {
    return {
      wasSuccessful: false,
      processing: false,    
    }   
  },
  methods: {
    submitResend() {      
      this.$inertia.post("/email/resend", {}, {
        preserveState: true,
        preserveScroll: true,
        only: ['flash', 'auth', 'user', 'errors'],
        onStart: () => {
          this.processing = true;
        },
        onFinish: () => {
          this.processing = false;          
        },
        onSuccess: () => {          
          this.wasSuccessful = true;
        }        
      });
    },
  }  
};
</script>
