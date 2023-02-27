<template>
    <div v-if="isOpen" data="modal-search-filter" class="items-center justify-center fixed top-0 left-0 z-40 bg-[#D2DAF0B3] w-full h-[100vh] overflow-hidden backdrop-blur-[2.5px] flex">
        <div class="flex flex-grow flex-col lg:gap-[8px] gap-[32px] max-w-[890px] w-full pb-[15px] md:overflow-hidden max-[768px]:pb-[40px] max-[768px]:pt-[40px] pt-[15px] overflow-x-hidden scrollbar overflow-y-auto md:px-[20px] px-0 h-[100%] relative ">
            <button @click="closeAndReturnFilters()" class="absolute right-0 max-[768px]:right-[10px] top-[15px] max-[768px]:top-0 w-[32px] h-[32px] md:bg-white bg-transparent rounded-[8px] flex items-center justify-center">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L15 15" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                    <path d="M1 15L15 1" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </button>
            <!-- <search-panel/> -->
           
            <div class="max-w-[832px] mx-auto w-full px-[16px] max-[768px]:mb-[40px] md:h-full">
                <div data="filter-content" class="scrollbar overflow-y-auto max-h-auto max-w-[820px] bg-transparent" style="max-height: 904px;">
                    <div data="filter-main" class="bg-[#EAEFFD] rounded-t-[16px] max-w-[800px] w-full md:rounded-b-none rounded-b-[16px]">
                        <p class="px-[16px] py-[15px] text-[16px] leading-[19px] font-semibold">Фильтры</p>
                        <div class="grid md:grid-cols-4 grid-cols-2  gap-[16px] p-[16px] bg-[#EAEFFD] shadow-sm">
                            <div class="">
                                <p class="text-[14px] leading-[16px] mb-[8px]">Тип заведения</p>
                                <div class="relative z-[5]">
                                    <button select-data="place-type" data="button-tab" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between">
                                        <span select-text="" class="text-[14px] leading-[16px]">Отель</span>
                                        <svg data="filter-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <svg data="filter-close" class="hidden" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_790_13114)">
                                                <path d="M0.999146 0.999203L10.9999 11" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                <path d="M0.999146 11L10.9999 0.999203" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_790_13114">
                                                    <rect width="12" height="12" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </button>
                                    <div class="absolute top-[32px] sm:left-0 left-[-16px] z-10 sm:w-full w-[calc(200%+48px)] hidden">
                                        <div class="flex items-center justify-between bg-white w-full">
                                            <div class="sm:w-[45%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                                            <div class="sm:w-[45%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
                                        </div>
                                        <div class="flex flex-col gap-[8px] rounded-[8px] bg-white py-[12px] px-[16px] shadow-xl">
                                            <button select-parent="place-type" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                Отель
                                            </button>
                                            <button select-parent="place-type" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                Аппартаменты
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button data="items-type" class="w-full mt-[16px] pb-[8px] bg-[#6170FF] rounded-[8px] hidden md:flex items-center flex-col justify-center h-[128px] select-none">
                                    <img class="mt-[18px] max-w-full" src="img/flash2.svg" alt="flash">
                                    <span class="text-[14px] leading-[16px] text-white mt-auto px-[5px] text-center">Горящие предложения</span>
                                </button>
                            </div>
                            <div class="">
                                <p class="text-[14px] leading-[16px] mb-[8px]">Рейтинг</p>
                                <div class="relative z-[5]">
                                    <button select-data="rating" data="button-tab" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between">
                                        <div class="flex items-center gap-[8px]">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 14.1667L5 16.6667L6.25 11.6667L2.5 7.5L7.91667 7.08333L10 2.5L12.0833 7.08333L17.5 7.5L13.75 11.6667L15 16.6667L10 14.1667Z" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <span select-text="" class="text-[14px] leading-[16px]">Любой</span>
                                        </div>
                                        <svg data="filter-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        <svg data="filter-close" class="hidden" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_790_13114)">
                                                <path d="M0.999146 0.999203L10.9999 11" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                <path d="M0.999146 11L10.9999 0.999203" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_790_13114">
                                                    <rect width="12" height="12" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </button>
                                    <div class="absolute top-[32px] sm:left-0 right-[-16px] z-10 sm:w-full w-[calc(200%+48px)] hidden">
                                        <div class="flex items-center justify-between bg-white w-full">
                                            <div class="sm:w-[45%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                                            <div class="sm:w-[45%] w-[26%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
                                        </div>
                                        <div class="flex flex-col gap-[8px] rounded-[8px] bg-white py-[12px] px-[16px] shadow-xl">
                                            <button select-parent="rating" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                Любой
                                            </button>
                                            <button select-parent="rating" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                6+
                                            </button>
                                            <button select-parent="rating" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                7+
                                            </button>
                                            <button select-parent="rating" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                8+
                                            </button>
                                            <button select-parent="rating" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                9+
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button data="items-type" class="w-full mt-[16px] pb-[8px] bg-white rounded-[8px] md:flex hidden items-center flex-col justify-center h-[128px] select-none">
                                    <img class="mt-[19px] max-w-full" src="img/cashback.svg" alt="cashback">
                                    <span class="text-[14px] leading-[16px] mt-auto">Кешбэк</span>
                                </button>
                            </div>
                            <div>
                                <p class="text-[14px] leading-[16px] mb-[8px]">Расположение</p>
                                <div class="grid gap-[16px]">
                                  
                                    <city-select name="city" type="form" searchable placeholder="Город" v-model="city" :options-array="filter.cities ?? []"/>
                                    <div data="select-data-div" class="relative md:static z-[3]">
                                        <button select-data="place" data="button-tab" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between">
                                            <span select-text="" class="text-[14px] leading-[16px]">Округ</span>
                                            <svg data="filter-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <svg data="filter-close" class="hidden" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_790_13114)">
                                                    <path d="M0.999146 0.999203L10.9999 11" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                    <path d="M0.999146 11L10.9999 0.999203" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_790_13114">
                                                        <rect width="12" height="12" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                        <div class="absolute max-[768px]:top-[32px] max-[768px]:right-[-16px] z-100 md:w-[376px] w-[calc(200%+48px)] hidden">
                                            <div class="flex items-center justify-between bg-white w-full">
                                                <div class="md:w-[22%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                                                <div class="md:w-[73%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
                                            </div>
                                            <div class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[296px] md:max-h-[calc(45vh-48px)] overflow-y-auto rounded-[8px] shadow-xl">
                                                <div class="bg-white rounded-t-[8px]">
                                                    <input type="text" placeholder="Округ" class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-[14px] leading-[16px] " wfd-id="id8">
                                                </div>
                                                <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
                                                    <button select-parent="place" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Восточный
                                                    </button>
                                                    <button select-parent="place" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Западный
                                                    </button>
                                                    <button select-parent="place" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Северный
                                                    </button>
                                                    <button select-parent="place" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Северо-восточный
                                                    </button>
                                                    <button select-parent="place" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Северо-западный
                                                    </button>
                                                    <button select-parent="place" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Центральный
                                                    </button>
                                                    <button select-parent="place" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Центральный
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div data="select-data-div" class="relative md:static z-[2]">
                                        <button select-data="district" data="button-tab" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between">
                                            <span select-text="" class="text-[14px] leading-[16px]">Район</span>
                                            <svg data="filter-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <svg data="filter-close" class="hidden" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_790_13114)">
                                                    <path d="M0.999146 0.999203L10.9999 11" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                    <path d="M0.999146 11L10.9999 0.999203" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_790_13114">
                                                        <rect width="12" height="12" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                        <div class="absolute max-[768px]:top-[32px] max-[768px]:right-[-16px] z-100 md:w-[376px] w-[calc(200%+48px)] hidden">
                                            <div class="flex items-center justify-between bg-white w-full">
                                                <div class="md:w-[22%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                                                <div class="md:w-[73%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
                                            </div>
                                            <div class="filter-scrollbar2 p-[16px] bg-white flex flex-col gap-[8px] max-h-[248px] md:max-h-[calc(45vh-96px)] overflow-y-auto rounded-[8px] shadow-xl">
                                                <div class="bg-white rounded-t-[8px]">
                                                    <input type="text" placeholder="Район" class="placeholder:text-[#A7ABB7] px-[10px] h-[32px] w-full bg-[#EAEFFD] rounded-[8px] text-[14px] leading-[16px] " wfd-id="id9">
                                                </div>
                                                <div class="flex flex-col gap-[8px] rounded-[8px] bg-white">
                                                    <button select-parent="district" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Академический
                                                    </button>
                                                    <button select-parent="district" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Алексеевский
                                                    </button>
                                                    <button select-parent="district" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Алтуфьевский
                                                    </button>
                                                    <button select-parent="district" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Арбат
                                                    </button>
                                                    <button select-parent="district" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Алексеевский
                                                    </button>
                                                    <button select-parent="district" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Алтуфьевский
                                                    </button>
                                                    <button select-parent="district" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                        Арбат
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <metro-select name="metro" type="form" searchable placeholder="Станция метро" v-model="metro" :options-array="filter.metros ?? []"/>
                                </div>
                            </div>
                            <div class="md:col-start-4 md:row-start-1 col-start-1 row-start-2">
                                <p class="text-[14px] leading-[16px] mb-[8px]">Период</p>
                                <div class="grid gap-[16px]">
                                    <div class="relative z-[4]">
                                        <button select-data="time" data="button-tab" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between">
                                            <span select-text="" class="text-[14px] leading-[16px]">На сутки</span>
                                            <svg data="filter-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.83337 4.33333L6.00004 8.5L10.1667 4.33333" stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                            <svg data="filter-close" class="hidden" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_790_13114)">
                                                    <path d="M0.999146 0.999203L10.9999 11" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                    <path d="M0.999146 11L10.9999 0.999203" stroke="#6170FF" stroke-width="2" stroke-linecap="round"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_790_13114">
                                                        <rect width="12" height="12" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                        <div class="absolute top-[32px] sm:left-0 left-[-16px] z-10 sm:w-full w-[calc(200%+48px)] hidden">
                                            <div class="flex items-center justify-between bg-white w-full">
                                                <div class="sm:w-[45%] w-[24%] bg-[#EAEFFD] h-[16px] rounded-r-[8px]"></div>
                                                <div class="sm:w-[45%] w-[72%] bg-[#EAEFFD] h-[16px] rounded-l-[8px]"></div>
                                            </div>
                                            <div class="flex flex-col gap-[8px] rounded-[8px] bg-white py-[12px] px-[16px] shadow-xl">
                                                <button select-parent="time" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                    На час
                                                </button>
                                                <button select-parent="time" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                    На ночь
                                                </button>
                                                <button select-parent="time" class="text-[14px] leading-[16px] w-full px-[8px] h-[32px] flex items-center justify-start rounded-[8px] md:hover:border border-solid border-[#6170FF] transition duration-150">
                                                    На сутки
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button data="price-item" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between md:hover:outline outline-solid outline-[#6170FF] transition duration-150 bg-[#6170FF] text-white">
                                        <span class="text-[14px] leading-[16px]">До 1500 ₽</span>
                                    </button>
                                    <button data="price-item" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between md:hover:outline outline-solid outline-[#6170FF] transition duration-150">
                                        <span class="text-[14px] leading-[16px]">1500-2500 ₽</span>
                                    </button>
                                    <button data="price-item" class="w-full px-[12px] h-[32px] bg-white rounded-[8px] flex items-center justify-between md:hover:outline outline-solid outline-[#6170FF] transition duration-150">
                                        <span class="text-[14px] leading-[16px]">От 3000 ₽</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-2 md:hidden grid gap-[16px]">
                                <button data="items-type" class="rounded-[8px] bg-white  px-[5px] h-[32px] flex items-center justify-center gap-[8px]">
                                    <img src="img/cashback-small.svg" alt="cashback">
                                    <span class="text-[14px] leading-[16px] ">Программа кешбэк</span>
                                </button>
                                <button data="items-type" class="rounded-[8px] bg-[#6170FF] px-[5px] h-[32px] flex items-center justify-center gap-[8px]">
                                    <img src="img/flash-small2.svg" alt="flash">
                                    <span class="text-[14px] leading-[16px] text-white">Горящие предложения</span>
                                </button>
                            </div>
                        </div>
                        <div class="shadow-sm">
                            <button data="filter-tab" class="flex items-center justify-between md:px-[16px] px-[24px] md:py-[14px] py-[24px] w-full">
                                <p class="text-[16px] leading-[19px] font-semibold">Детально об отеле</p>
                                <div data="tab-closed">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.83301 13.0002L5.99967 17.1669L10.1663 13.0002" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M10.167 7.16692L6.00033 3.00025L1.83366 7.16692" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <div data="tab-open" class="hidden">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.1667 17.1668L6.00002 13.0001L1.83335 17.1668" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M1.83386 2.99982L6.00053 7.16648L10.1672 2.99982" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </button>
                            <div class="maxh overflow-hidden">
                                <span class="inline-block md:pt-[16px] pt-0 md:px-[16px] px-[24px] text-[16px] leading-[19px]">Удобства</span>
                                <div class="flex flex-wrap md:p-[8px] p-[16px]">
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Услуги прачечной</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Оплата картой</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Wi-Fi</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">10 минут до&nbsp;метро</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">5 минут до&nbsp;метро</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Доставка еды</button>
                                </div>
                                <span class="text-[16px] md:px-[16px] px-[24px] leading-[19px]">Парковка</span>
                                <div class="flex flex-wrap md:p-[8px] md:pb-[24px] pb-[16px] p-[16px]">
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Городская</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Платная</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Бесплатная</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Отеля</button>
                                </div>
                            </div>
                        </div>
                        <div class="shadow-sm">
                            <button data="filter-tab" class="flex items-center justify-between md:px-[16px] md:py-[14px] px-[24px] py-[24px] w-full">
                                <p class="text-[16px] leading-[19px] font-semibold ">Детально о номере</p>

                                <div data="tab-closed">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.83301 13.0002L5.99967 17.1669L10.1663 13.0002" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M10.167 7.16692L6.00033 3.00025L1.83366 7.16692" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <div data="tab-open" class="hidden">
                                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.1667 17.1668L6.00002 13.0001L1.83335 17.1668" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M1.83386 2.99982L6.00053 7.16648L10.1672 2.99982" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>

                            </button>
                            <div class="maxh overflow-hidden">
                                <span class="inline-block md:px-[16px] px-[24px] text-[16px] leading-[19px] md:pt-[16px] pt-0">Особенности номера</span>
                                <div class="flex flex-wrap md:p-[8px] p-[16px]">
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Двухкомнатный</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Ультрафиолетовая лампа</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Звукоизоляция</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Пилон</button>
                                </div>
                                <span class="inline-block md:px-[16px] px-[24px] text-[16px] leading-[19px]">В&nbsp;ванной комнате</span>
                                <div class="flex flex-wrap md:p-[8px] p-[16px] md:pb-[24px] pb-[16px]">
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Общий санузел</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Тапочки</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Фен</button>
                                    <button clck-btn="" clck-btn-class="bg-[#6170FF] text-white" class="m-[8px] text-[14px] leading-[16px] px-[12px] h-[32px] flex items-center justify-center bg-white rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] transition duration-150 ">Туалет с ванной напротив номера</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data="filter-footer" class="bg-transparent md:h-[80px] h-auto w-full flex items-center justify-center">
                    <div class="md:w-full w-[calc(100%-48px)] h-full px-[16px] md:py-0 py-[16px] bg-white rounded-b-[24px] flex md:flex-row flex-col items-center justify-between gap-[16px] md:max-w-none max-w-[400px]">
                        <div class="flex items-center justify-between md:gap-[54px] gap-[10px] md:w-initial w-full ">
                            <span class="text-[14px] leading-[16px] font-semibold">Найдено {{ foundMessage  ?? 0 }}</span>
                            <button class="text-[14px] leading-[16px] underline">Очистить фильтры</button>
                        </div>
                        <div class="flex items-center gap-[8px] md:justify-end justify-between md:w-initial w-full flex-wrap ">
                            <button class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 3V19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M9 5V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 3L9 5L15 3L21 5V21L15 19L9 21L3 19V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="text-white">На карте</span>
                            </button>
                            <button @click="getData()" class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.85718 7H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6.85718 12.143H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6.85718 17.2857H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 7V7.01284" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 12.143V12.1558" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3 17.2857V17.2985" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span class="text-white">Списком</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</template>

<script>
    import SearchPanel from "@/components/widgets/SearchPanel.vue"    
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import { filterStore } from '@/Store/filterStore.js'    
    import { numWord } from '@/Services/numWord.js'
    import _ from 'lodash'
    import Select from '@/components/ui/Select.vue'
    import Button from '@/components/ui/Button.vue'
    import CitySelect from '@/components/ui/CitySelect.vue'
    import MetroSelect from '@/components/ui/MetroSelect.vue'
    import FilterAttrToggle from '@/components/ui/FilterAttrToggle.vue'
    export default {
        components: {
            SearchPanel,
            Select,
            Button,
            CitySelect,
            MetroSelect,
            FilterAttrToggle,
        },
        props: {
            filter: {
                type: Object,
                default: {},
            }
        },
        mounted() {
            this.filterStore.init(usePage().url.value);                       
        },        
        data() {
            return {
                filterStore,              
                form: useForm({}),
                nonAtrributes: ['city', 'metro'],
                city: 'init',
                metro: 'init',
                initialUrl: usePage().url.value,
                initialFilters: [],
            }
        },
        computed: {
            isOpen() {
                return usePage().props.value.modals?.filters ?? false;
            },           
            foundMessage() {
                return usePage().props.value.total + ' ' + numWord(usePage().props.value.total, ['предложение', 'предлжения', 'предложений']);
            },
            attributes() {
                return _.cloneDeep(_.filter(this.filterStore.filters, el => !this.nonAtrributes.includes(el.key)));
            },
        },
        methods: {
            close() {
                usePage().props.value.modals.filters = false;                
            },
            closeAndReturnFilters() {
                this.close();
                window.history.replaceState({}, this.$page.title, this.initialUrl);
                this.filterStore.filters = this.initialFilters;
                this.updateFilters(['total']);
            },                               
            getData() {                                
                this.$inertia.get(route('hotels.index'), this.filterStore.getFiltersValues(), {
                    preserveState: true,
                    preserveScroll: true,
                    only: ['hotels', 'rooms'],                    
                });
                this.close();
            },
            updateFilters(only) {
                let data = this.filterStore.getFiltersValues();                
                this.$inertia.get(route('hotels.index'), data, {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: only ?? [],                   
                });
            },            
        },
        watch: {
            isOpen: {
                handler (newVal, oldVal) {
                    if (newVal == true && oldVal == false) {
                        this.initialUrl = usePage().url.value;
                        this.initialFilters = this.filterStore.filters; 
                    }                    
                },
                immediate: true           
            },
            city: {
                handler(newVal, oldVal) {       
                    if (oldVal != newVal && oldVal != 'init' && newVal != 'init') {                                         
                        this.filterStore.removeFilter('hotels', false, 'metro');
                        this.updateFilters(['total', 'metros']);                                               
                    }                    
                },                               
            },
            metro: function (newVal, oldVal) {                
                if (oldVal != newVal && newVal != null) {                                     
                    this.updateFilters(['total']);                  
                }
                
                if (oldVal != null && newVal == null) {
                    this.updateFilters(['total', 'metros']);
                }
            },                     
            attributes: {
                handler(newVal, oldVal) {         
                    if (!_.isEqual(newVal, oldVal)) {                        
                        this.updateFilters(['total']);                                             
                    }                    
                },
                deep: true
            },            
        }
    }
</script>