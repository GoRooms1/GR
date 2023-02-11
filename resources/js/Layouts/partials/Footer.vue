<template>
    <footer class="fixed bottom-0 z-[10] inset-x-0 md:footer mt-8">
		<div class="container mx-auto p-0 lg:px-4">
			 <div class="flex justify-between px-4 py-2 bg-white flex-col lg:flex-row rounded-t-xl text-sm items-center">
				<slot/>
    		</div>
		</div>		
	</footer>
</template>

<script>	
	import NavLink from "@/components/ui/NavLink.vue"
	import Navigation from "./Navigation.vue"	
	
    export default {
		components: {           
			NavLink,
			Navigation,				
        },
		data() {
			return {
				appYear: new Date().getFullYear(),
			}
		},        
    }
</script>
