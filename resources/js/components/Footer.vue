<template>
    <footer class="fixed bottom-0 z-[10] inset-x-0 md:footer mt-8">
		<div class="container mx-auto p-0 lg:px-4">
			<div class="flex justify-between px-4 py-2 bg-white flex-col lg:flex-row rounded-t-xl text-sm items-center">
				<div class="flex lg:hidden w-full p-2">
					<button clck-btn="map" clck-btn-wth="listpointers" clck-btn-class="bg-[#6170FF]" clck-btn-class-nonclk="bg-[#EAEFFD]" class="p-2.5 rounded-l-lg bg-[#EAEFFD]">
						<img src="img/map.svg" alt="map">
					</button>
					<button clck-btn="listpointers" clck-btn-wth="map" clck-btn-class="bg-[#6170FF]" clck-btn-class-nonclk="bg-[#EAEFFD]" class="p-2.5 rounded-r-lg mr-[10%] bg-[#6170FF]">
						<img src="img/listpointers2.svg" alt="listpointers">
					</button>
					<button data="open-search" clck-btn="" clck-btn-class="bg-[#6170FF]" clck-btn-class-nonclk="bg-[#EAEFFD]" class="p-2.5 rounded-lg mx-[1.7%] ml-auto bg-[#6170FF]">
						<img src="img/search2.svg" alt="search">
					</button>
					<button data="open-modal" clck-btn="" clck-btn-class="bg-[#6170FF]" clck-btn-class-nonclk="bg-[#EAEFFD]" class="p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
						<img src="img/filters.svg" alt="filters">
					</button>
					<button clck-btn="" clck-btn-class="bg-[#6170FF]" clck-btn-class-nonclk="bg-[#EAEFFD]" class="p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
						<img src="img/bolt.svg" alt="bolt">
					</button>
					<button clck-btn="" clck-btn-class="bg-[#6170FF]" clck-btn-class-nonclk="bg-[#EAEFFD]" class="p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
						<img src="img/footer-cashback.svg" alt="footer-cashback">
					</button>
					<button data="favorites-open" clck-btn="" clck-btn-class="bg-[#6170FF]" clck-btn-class-nonclk="bg-[#EAEFFD]" class="p-2.5 rounded-lg mx-[1.7%] bg-[#EAEFFD]">
						<img src="img/heart.svg" alt="heart">
					</button>
				</div>
				<div class="hidden lg:flex py-2">
					<button class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc11.svg)] hover:bg-[url(/img/soc12.svg)]">

					</button>
					<button class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc21.svg)] hover:bg-[url(/img/soc22.svg)]">

					</button>
					<button class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc31.svg)] hover:bg-[url(/img/soc32.svg)]">

					</button>
					<button class="mr-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/soc41.svg)] hover:bg-[url(/img/soc42.svg)]">

					</button>
				</div>
				<div data="footer-copyr" class="hidden lg:block pt-1 mx-auto lg:ml-12 lg:mr-auto">
					© {{appYear}} ООО «Го Румс»
				</div>
				<div class="mr-12 pt-1  hidden lg:flex">
					<a href="#" class="underline">
						Хранение и обработка персональных данных
					</a>
				</div>
				<div class="flex  hidden lg:flex">
					<button class="flex">
						<a class="ml-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/link1_1.svg)] hover:bg-[url(/img/link1_2.svg)]">

						</a>
					</button>
					<button class="flex">
						<a class="ml-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/link2_1.svg)] hover:bg-[url(/img/link2_2.svg)]">

						</a>
					</button>
					<button class="flex">
						<a class="ml-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/link3_1.svg)] hover:bg-[url(/img/link3_2.svg)]">

						</a>
					</button>
					<button class="flex">
						<a class="ml-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)]">

						</a>
					</button>
					<button class="flex">
						<a class="ml-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)]">

						</a>
					</button>
					<button data="favorites-open" class="flex">
						<a class="ml-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)]">

						</a>
					</button>
					<button class="flex">
						<a class="ml-4 w-[24px] h-[24px] bg-no-repeat bg-contain bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)]">

						</a>
					</button>
				</div>
			</div>
		</div>		
	</footer>
</template>

<script>
    export default {
		data() {
			return {
				appYear: new Date().getFullYear(),
			}
		},
        mounted() {
            
        }
    }
</script>
