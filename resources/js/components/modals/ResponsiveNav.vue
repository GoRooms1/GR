<template>
   <div id="menu" class="fixed top-0 left-0 z-40 bg-[#D2DAF0B3] w-full h-[100vh] overflow-hidden backdrop-blur-[2.5px] flex-col justify-center items-center lg:hidden px-7"
        v-bind:class="this.isOpen ? 'flex' : 'hidden'"
   >
        <button v-on:click="hide()" data="close-menu" class="absolute top-[12px] right-[16px]">
            <img src="/img/close.svg">
        </button>
        <div class="flex flex-col px-6 py-8 bg-white rounded-3xl w-full mb-[17%]">
            <h3 class="mb-6 font-semibold">Меню</h3>
            <Link :href="route('search.map')" as="button" class="hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link1_1.svg)] hover:bg-[url(/img/link1_2.svg)] bg-[left_10px_center] text-left mb-2">Карта</Link>
            <button class="btn-disabled hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link2_1.svg)] hover:bg-[url(/img/link2_2.svg)] bg-[left_10px_center] text-left mb-2">Горящие предложения</button>
            <button class="btn-disabled hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link3_1.svg)] hover:bg-[url(/img/link3_2.svg)] bg-[left_10px_center] text-left mb-2">Бонусная программа</button>
            <button class="hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link4_1.svg)] hover:bg-[url(/img/link4_2.svg)] bg-[left_10px_center] text-left mb-2">Добавить объект</button>
            <Link :href="route('contact')" as="button" class="hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link5_1.svg)] hover:bg-[url(/img/link5_2.svg)] bg-[left_10px_center] text-left mb-2">Контакты</Link>
            <button data="favorites-open" class="btn-disabled hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link6_1.svg)] hover:bg-[url(/img/link6_2.svg)] bg-[left_10px_center] text-left mb-2">Избранное</button>
            <button class="hover:outline outline-solid outline-[#6170FF] rounded-lg py-1 pl-[42px] bg-no-repeat bg-[url(/img/link7_1.svg)] hover:bg-[url(/img/link7_2.svg)] bg-[left_10px_center] text-left">Личный кабинет</button>
            <h3 class="mb-6 mt-10 font-semibold">Мы в социальных сетях</h3>
            <div class="grid grid-cols-2 grid-rows-2 gap-2">
                <button class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc11.svg)] hover:bg-[url(/img/soc12.svg)] pl-[42px] w-full text-left">
                    Facebook
                </button>
                <button class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc31.svg)] hover:bg-[url(/img/soc32.svg)] pl-[42px] w-full text-left">
                    Вконтакте
                </button>
                <button class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc21.svg)] hover:bg-[url(/img/soc22.svg)] pl-[42px] w-full text-left">
                    Instagram
                </button>
                <button class="h-[24px] bg-no-repeat bg-contain bg-[left_10px_center] bg-[url(/img/soc41.svg)] hover:bg-[url(/img/soc42.svg)] pl-[42px] w-full text-left">
                    YouTube
                </button>
            </div>
        </div>
    </div> 
</template>

<script>
    import {Link} from '@inertiajs/inertia-vue3'
    export default {
        components: {
            Link
        },        
        created() {
            window.addEventListener('resize', this.handleResize);
            this.handleResize();
        },
        destroyed() {
            window.removeEventListener('resize', this.handleResize);
        },  
        data() {
            return {
                isOpen: false,
                screenWidth: window.innerWidth,           
            }
        },
        methods: {
            show() {                
                this.isOpen = true;                
            },
            hide() {                
                this.isOpen = false;                
            }, 
            handleResize() {                
                if (this.isOpen)
                {
                    this.screenWidth = window.innerWidth;
                    if (this.screenWidth > 1024)
                       this.hide(); 
                }         
            },          
        }
    }
</script>
