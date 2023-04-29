<template>
  <div
    class="search-box w-full bg-white p-0 px-[8px] py-[12px] flex items-center"
    :class="searchInputClasses"
  >    
    <button class="p-[8px]">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z"
          stroke="#6170FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M19.9999 20L15.8032 15.8033" stroke="#6170FF" stroke-width="2" stroke-linecap="round"
          stroke-linejoin="round"></path>
      </svg>
    </button>
    <input :value='searchValue' @input='evt=>searchValue=evt.target.value'  @keyup="search" type="text"
      class="bg-transparent p-[8px] grow text-[16px] leading-[19px] text-ellipsis whitespace-nowrap overflow-hidden placeholder:text-[#A7ABB7] text-[#515561] text-[1rem]"
      placeholder="Название отеля, адрес, метро, округ, район, город" />
    <div class="md:flex hidden items-center gap-[8px]">
      <button @click="getDataOnMap()"
        class="flex items-center gap-[8px] bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15 3V19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M9 5V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M3 3L9 5L15 3L21 5V21L15 19L9 21L3 19V3Z" stroke="white" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round"></path>
        </svg>
        <span class="text-white">На карте</span>
      </button>
      <button @click="getDataOnList()"
        class="flex items-center gap-[8px] bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6.85718 7H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M6.85718 12.143H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          </path>
          <path d="M6.85718 17.2857H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          </path>
          <path d="M3 7V7.01284" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M3 12.143V12.1558" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          </path>
          <path d="M3 17.2857V17.2985" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          </path>
        </svg>
        <span class="text-white">Списком</span>
      </button>
    </div>
  </div>
  <div v-if="count > 0 && searchValue"
    class="absolute z-[11] w-[75%] max-[768px]:w-full flex flex-col py-3 px-4 bg-white rounded-b-[24px] cursor-default scrollbar overflow-y-auto max-h-[60vh] gap-[8px] max-[768px]:text-[0.8125rem] shadow-xl"
    :class="forModal === true ? 'max-[768px]:top-[64px]' : ''"
  >
    <div v-for="category in result" class="w-full flex flex-col">
      <div v-if="category.data.length > 0" class="px-2.5 py-1.5 font-semibold">{{ category.title }}</div>      
      <Link v-if="!category.blank" v-for="obj in category.data" as="button" :href="obj.link"
        class="whitespace-nowrap flex px-2 py-1.5 pl-[40px] rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] cursor-pointer relative">
        <div v-if="category.title == 'Метро'" class="metro-search-icon">
            <svg
              width="20"
              height="16"
              viewBox="0 0 20 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M17.2343 12.231H16.3397L12.6234 3H12.6203L10.1173 8.22059L7.62034 3H7.61728L3.89485 12.231H3.00024V13H8.12586V12.231H7.1087L8.29436 9.30208L10.1173 13L11.9463 9.30208L13.1259 12.231H12.1087V13H17.2343V12.231Z"
                :fill="'#' + obj?.color"
              ></path>
            </svg>
        </div>
        <div class="whitespace-nowrap mr-auto">{{ obj.name }}</div>
        <div class="whitespace-nowrap">{{ obj?.city ?? '' }}</div>
      </Link>
      <button v-if="category.blank" v-for="obj in category.data" @click="openLinkBlank(obj.link)"
        class="whitespace-nowrap flex px-2 py-1.5 pl-[40px] rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] cursor-pointer relative">
        <div class="whitespace-nowrap mr-auto">{{ obj.name }}</div>
        <div class="whitespace-nowrap">{{ obj?.city ?? '' }}</div>
    </button>
    </div>    
  </div>
</template>

<script>
import { useForm, usePage } from "@inertiajs/vue3";
import { filterStore } from "@/Store/filterStore.js";
import { Link } from "@inertiajs/vue3";
import _ from 'lodash';

export default {
  components: {
    Link,
  },
  props: {
    forModal: {
      type: Boolean,
      default: false,
    },
    url: {
      type: String,
      default: null,
    }
  },
  data() {
    return {
      filterStore,
      searchValue: null,
      searchState: null,
      result: [],
      count: 0,
    };
  },
  computed: {
    searchInputClasses() {
      if (this.forModal === true)
        return this.count > 0 ? 'lg:rounded-b-none lg:rounded-t-[16px] rounded-t-[24px] lg:p-[8px]' : 'lg:rounded-t-[16px] rounded-t-[24px] lg:rounded-b-none rounded-b-[24px] lg:p-[8px]';
      else
        return this.count > 0 ? 'md:rounded-b-none md:rounded-t-[16px] rounded-t-[24px] md:p-[8px]' : 'md:rounded-t-[16px] rounded-t-[24px] md:rounded-b-none rounded-b-[24px] md:p-[8px]';
    },
  },
  methods: {
    getDataOnList() {
      this.$inertia.get("/search", this.filterStore.getFiltersValues(), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
        only: ['hotels', 'rooms', 'is_rooms_filter', 'page_description'],
        //onSuccess: () => {},
        onStart: () => {
          usePage().props.isLoadind = true;
        },
        onFinish: () => {
          usePage().props.isLoadind = false;
        },
      });      
    },
    getDataOnMap() {
      this.$inertia.get("/search_map", this.filterStore.getFiltersValues(), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
        only: ['hotels', 'rooms', 'is_rooms_filter', 'page_description'],
        //onSuccess: () => {},
        onStart: () => {
          usePage().props.isLoadind = true;
        },
        onFinish: () => {
          usePage().props.isLoadind = false;
          eventBus.emit('data-received');
        },
      });      
    },  
    search() {
      let data = this.filterStore.getFiltersValues();
      data.search = this.searchValue;
      
      if (this.searchState) this.searchState.cancel();
      
      if (!this.searchValue) {
        this.count = 0;
        this.result = [];
        return null;
      }
      
      this.searchState = _.debounce(() => {
        this.$inertia.get(this.url ?? this.$page.url.split('?')[0], data, {
          preserveState: true,
          preserveScroll: true,
          only: ["search_result"],
          onStart: () => {this.count = 0; this.result = [] },
          onSuccess: () => {            
            this.result = _.sortBy(usePage().props.search_result, 'sort');
            this.result.forEach(el => {
              this.count += el?.data?.length ?? 0;
            });                        
          },
        });
      }, 50);

      this.searchState();
    },
    openLinkBlank(link) {
      if (typeof window !== "undefined") window.open(link, '_blank');      
    },
  },
};
</script>
