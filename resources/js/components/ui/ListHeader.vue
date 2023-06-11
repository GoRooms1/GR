<template>
  <div class="filter h-32 xl:h-40 pt-4 -mb-16 xl:pt-8">
    <div class="container mx-auto px-4 min-[1920px]:px-[10vw]">
      <div class="flex justify-between items-center">        
        <span v-if="title" class="text-white font-bold xl:text-3xl">
          {{ title }}
        </span>
        <h1 v-else-if="h1" 
          class="text-white font-bold xl:text-3xl"
          :class="$page.props.isLoadind == true ? 'invisible' : ''"
        >
          {{ h1 }}
        </h1>
        <button class="xl:hidden">
          <svg
            width="32"
            height="32"
            viewBox="0 0 32 32"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M8.33301 23.0972V8.00195"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M22.9997 8.00042L22.9998 23.2861"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M2.99976 17.7639L8.33309 23.0972L13.6664 17.7639"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M28.3333 13.333L22.9999 7.99967L17.6666 13.333"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
          </svg>
        </button>
        <div class="hidden xl:flex items-center">
          <div class="flex items-center mr-8">
            <div class="text-white text-sm mr-4">Сортировка</div>

            <div
              class="flex items-center border border-white rounded-lg overflow-hidden"
            >
              <button
                
                class="text-white h-8 pt-1 px-4 cursor-pointer text-blue-500 bg-white"
              >
                <svg
                  class="img1 hidden"
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M5.83301 8L9.99967 12.1667L14.1663 8"
                    stroke="white"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
                <svg
                  class="img2"
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M5.83301 8L9.99967 12.1667L14.1663 8"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </button>
              <button                
                class="text-white h-8 pt-1 px-4 cursor-pointer"
              >
                <svg
                  class="img1"
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M14.167 12L10.0003 7.83333L5.83366 12"
                    stroke="white"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
                <svg
                  class="img2 hidden"
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M14.167 12L10.0003 7.83333L5.83366 12"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </button>
            </div>
          </div>
          <div class="flex items-center text-sm">
            <div class="mr-2">
              <svg
                class="-mt-1"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M12 17L6 20L7.5 14L3 9L9.5 8.5L12 3L14.5 8.5L21 9L16.5 14L18 20L12 17Z"
                  stroke="white"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                ></path>
              </svg>
            </div>
            <div class="text-sm text-white text-sm mr-4">Рейтинг</div>
            <div
              class="flex items-center border border-white rounded-lg overflow-hidden"
            >
              <button                
                class="text-white h-8 leading-8 px-4 border-r border-white hover:bg-white hover:text-[#6170FF] bg-white text-[#6170FF]"
              >
                Любой
              </button>
              <button                
                class="text-white px-2 h-8 leading-8 px-4 border-r border-white cursor-pointer hover:bg-white hover:text-[#6170FF]"
              >
                6+
              </button>
              <button               
                class="text-white px-2 h-8 leading-8 px-4 border-r border-white cursor-pointer hover:bg-white hover:text-[#6170FF]"
              >
                7+
              </button>
              <button               
                class="text-white px-2 h-8 leading-8 px-4 border-r border-white cursor-pointer hover:bg-white hover:text-[#6170FF]"
              >
                8+
              </button>
              <button                
                class="text-white px-2 h-8 leading-8 px-4 cursor-pointer hover:bg-white hover:text-[#6170FF]"
              >
                9+
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {    
    title: {
      type: String,
      default: null,
    },
    h1: {
      type: String,
      default: null,
    },
  },
};
</script>
