<template>
  <div
    class="search-box w-full bg-white p-0 px-[8px] py-[12px] flex items-center"
    :class="searchInputClasses"
  >
    <button class="p-[8px]">      
      <img src="/img/search.svg" alt="search"/>
    </button>
    <input
      :value="searchValue"
      @input="(evt) => (searchValue = evt.target.value)"
      @keyup="search"
      type="text"
      class="bg-transparent p-[8px] grow text-[16px] leading-[19px] text-ellipsis whitespace-nowrap overflow-hidden placeholder:text-[#A7ABB7] text-[#515561] text-[1rem]"
      placeholder="Название отеля, адрес, метро, округ, район, город"
    />
    <div class="md:flex hidden items-center gap-[8px]">
      <button
        @click="getDataOnMap()"
        class="flex items-center gap-[8px] bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150"
      >
        <img src="/img/map2.svg" alt="map"/>
        <span class="text-white">На карте</span>
      </button>
      <button
        @click="getDataOnList()"
        class="flex items-center gap-[8px] bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150"
      >
        <img src="/img/listpointers2.svg" alt="list"/>
        <span class="text-white">Списком</span>
      </button>
    </div>
  </div>
  <div
    v-if="count > 0 && searchValue"
    class="absolute z-[11] w-[75%] max-[768px]:w-full flex flex-col py-3 px-4 bg-white rounded-b-[24px] cursor-default scrollbar overflow-y-auto max-h-[60vh] gap-[8px] max-[768px]:text-[0.8125rem] shadow-xl"
    :class="forModal === true ? 'max-[768px]:top-[64px]' : ''"
  >
    <div v-for="category in result" class="w-full flex flex-col">
      <div v-if="category.data.length > 0" class="px-2.5 py-1.5 font-semibold">
        {{ category.title }}
      </div>
      <Link
        v-if="!category.blank"
        v-for="obj in category.data"
        as="button"
        :href="obj.link"
        class="whitespace-nowrap flex px-2 py-1.5 pl-[40px] rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] cursor-pointer relative"
      >
        <div v-if="category.title == 'Метро'" class="metro-search-icon">
          <MetroIcon :color="obj?.color"/>         
        </div>
        <div class="whitespace-nowrap mr-auto">{{ obj.name }}</div>
        <div class="whitespace-nowrap">{{ obj?.city ?? "" }}</div>
      </Link>
      <button
        v-if="category.blank"
        v-for="obj in category.data"
        @click="openLinkBlank(obj.link)"
        class="whitespace-nowrap flex px-2 py-1.5 pl-[40px] rounded-[8px] md:hover:outline outline-solid outline-[#6170FF] cursor-pointer relative"
      >
        <div class="whitespace-nowrap mr-auto">{{ obj.name }}</div>
        <div class="whitespace-nowrap">{{ obj?.city ?? "" }}</div>
      </button>
    </div>
  </div>
</template>

<script>
import { filterStore } from "@/Store/filterStore.js";
import { Link } from "@inertiajs/vue3";
import sortBy from "lodash/sortBy";
import MetroIcon from "@/components/ui/MetroIcon.vue";

export default {
  components: {
    Link,
    MetroIcon
  },
  props: {
    forModal: {
      type: Boolean,
      default: false,
    },
    url: {
      type: String,
      default: null,
    },
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
        return this.count > 0
          ? "lg:rounded-b-none lg:rounded-t-[16px] rounded-t-[24px] lg:p-[8px]"
          : "lg:rounded-t-[16px] rounded-t-[24px] lg:rounded-b-none rounded-b-[24px] lg:p-[8px]";
      else
        return this.count > 0
          ? "md:rounded-b-none md:rounded-t-[16px] rounded-t-[24px] md:p-[8px]"
          : "md:rounded-t-[16px] rounded-t-[24px] md:rounded-b-none rounded-b-[24px] md:p-[8px]";
    },
  },
  methods: {
    getDataOnList() {
      this.$inertia.get("/search", this.filterStore.getFiltersValues(), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
        only: ["hotels", "rooms", "is_rooms_filter", "page_description"],        
        onStart: () => {
          this.$page.props.isLoadind = true;
        },
        onFinish: () => {
          this.$page.props.isLoadind = false;
        },
      });
    },
    getDataOnMap() {
      this.$inertia.get("/search_map", this.filterStore.getFiltersValues(), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
        only: ["hotels", "rooms", "is_rooms_filter", "page_description", "map_center"],        
        onStart: () => {
          this.$page.props.isLoadind = true;
        },
        onFinish: () => {
          this.$page.props.isLoadind = false;
          this.$eventBus.emit("data-received");
        },
      });
    },
    search() {
      let data = this.filterStore.getFiltersValues();
      data.search = this.searchValue;
      
      if (this.searchState) clearTimeout(this.searchState);

      if (!this.searchValue) {
        this.count = 0;
        this.result = [];
        return null;
      }

      this.searchState = setTimeout(() => {
        this.$inertia.get(this.url ?? this.$page.url.split("?")[0], data, {
          preserveState: true,
          preserveScroll: true,
          only: ["search_result"],
          onStart: () => {
            this.count = 0;
            this.result = [];
          },
          onSuccess: () => {
            this.result = sortBy(this.$page.props.search_result, "sort");
            this.result.forEach((el) => {
              this.count += el?.data?.length ?? 0;
            });
          },
        });
      }, 50);
    },
    openLinkBlank(link) {
      if (typeof window !== "undefined") window.open(link, "_blank");
    },
  },
};
</script>
