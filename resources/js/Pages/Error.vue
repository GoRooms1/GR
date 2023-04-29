<template>
   <AppHead title="Gorooms.ru" />
   <div class="container mx-auto px-4 w-full">
		<div class="flex flex-col lg:flex-row mx-auto w-full justify-center items-center h-[calc(100vh-104px)]">
			<div class="text-[#3B24C6] text-center font-bold text-[150px] xl:text-[300px] lg:text-[254px] md:text-[320px] sm:text-[228px] border-b lg:border-r lg:border-b-0 border-slate-300 py-4 px-8 w-full md:w-auto">
				<h1>
					{{ status }}
				</h1>
			</div>
			<div class="flex flex-col py-4 px-8 justify-center gap-8 lg:gap-12 text-center lg:text-left">
				<div class="uppercase text-[32px] text-[#6170FF]">{{ title }}</div>
				<div class="text-[20px]">{{ description }}</div>
				<div class="text-[20px]">
					Перейдите на 
					<Link href="/" class="underline text-[#6170FF] font-bold">главную страницу!</Link>
				</div>
			</div>
		</div>		
	</div> 
</template>

<script>
import AppHead from "@/components/ui/AppHead.vue"
import Layout from "@/Layouts/Layout.vue"
import { Link } from "@inertiajs/vue3"

export default { 
  components: {
    AppHead,
    Layout,
    Link
  },
  props: {   
    status: Number,
    title: String,
    description: String
  }, 
};
</script>
