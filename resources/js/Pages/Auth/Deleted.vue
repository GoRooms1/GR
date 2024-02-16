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
					Удаление аккаунта
        </div>
        <div class="flex flex-col p-6 lg:p-4">
          <span class="text-center leading-4 z-[1] p-2">Удаление аккаунта прошло успешно! Спасибо, что всё это время Вы были с нами!</span>
          <span class="text-center leading-4 z-[1] p-2">С уважением, команда GoRooms</span>
          <Link as="button" class="w-full h-12 text-center bg-blue-500 text-white rounded-md mt-3 hover:bg-blue-800">На главную</Link>          
        </div>			
      </div>
    </div>				
	</div>
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    AppHead,
    Layout,   
    Link,   
  },
};
</script>
