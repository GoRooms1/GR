<template>
  <div class="mx-[1.625rem] relative z-10 flex flex-col items-center">
    <div
      class="w-full p-6 bg-[#EAEFFD] rounded-3xl grid grid-cols-2 grid-rows-7 max-[330px]:grid-cols-1 max-[330px]:grid-rows-14 gap-4"
    >
      <city-select-intro
        searchable
        placeholder="Город"        
        :options-array="$page.props.cities ?? []"
        :model-value="filterStore.getFilterValue('hotels', 'city')"
        @update:modelValue="(event) => filterValueHandler('hotels', false, 'city', event)"
      />
      <metro-select-intro
        searchable
        placeholder="Станция метро"        
        :options-array="$page.props.metros ?? []"
        :model-value="filterStore.getFilterValue('hotels', 'metro')"
        @update:modelValue="(event) => filterValueHandler('hotels', false, 'metro', event)"
      />

      <filter-attr-toggle
        title="Low Cost"
        img="img/low-cost.svg"
        toggle-img="img/low-cost2.svg"
        type="horizontal"
        initial-value="true"
        :model-value="filterStore.getFilterValue('rooms', 'low_cost')"
        @update:modelValue="(event) => filterValueHandler('rooms', false, 'low_cost', event)"
      />
      <filter-attr-toggle
        title="От 1 часа"
        img="img/hour.svg"
        toggle-img="img/hour2.svg"
        type="horizontal"
        :initial-value="68"
        :model-value="filterStore.getFilterValue('rooms', 'attr_68')"
        @update:modelValue="(event) => filterValueHandler('rooms', true, 'attr_68', event)"
      />
      <filter-attr-toggle
        title="Горящие"
        img="img/flash.svg"
        toggle-img="img/flash2.svg"
        type="horizontal"
        initial-value="true"        
        disabled
      />
      <filter-attr-toggle
        title="Кешбэк"
        img="img/cashback.svg"
        toggle-img="img/cashback2.svg"
        type="horizontal"
        disabled
      />
      <filter-attr-toggle
        title="Арт дизайн"
        img="img/art.svg"
        toggle-img="img/art2.svg"
        type="horizontal"
        :initial-value="52"
        :model-value="filterStore.getFilterValue('rooms', 'attr_52')"
        @update:modelValue="(event) => filterValueHandler('rooms', true, 'attr_52', event)"
      />
      <filter-attr-toggle
        title="Джакузи"
        img="img/jacuzzi.svg"
        toggle-img="img/jacuzzi2.svg"
        type="horizontal"
        :initial-value="65"
        :model-value="filterStore.getFilterValue('rooms', 'attr_65')"
        @update:modelValue="(event) => filterValueHandler('rooms', true, 'attr_65', event)"
      />
    </div>
    <div
      class="md:w-full w-[calc(100%-48px)] h-full px-[16px] md:py-0 pb-[16px] pt-[10px] bg-white rounded-b-[24px] flex md:flex-row flex-col items-center justify-between gap-[16px] md:max-w-none max-w-[400px]"
    >
      <div
        class="flex items-center justify-center md:gap-[54px] gap-[10px] md:w-initial w-full"
      >
        <span class="text-sm leading-[16px]"
          >Найдено {{ foundMessage }}</span
        >
      </div>
      <div
        class="flex items-center gap-[16px] md:justify-end justify-between md:w-initial w-full flex-wrap"
      >
        <Button @click="getDataOnMap()">
          <img src="/img/map2.svg" alt="map"/>
          <span class="text-white">На карте</span>
        </Button>
        <Button @click="getDataOnList()">
          <img src="/img/listpointers2.svg" alt="list" width="24" height="24"/>
          <span class="text-white">Списком</span>
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import { usePage } from "@inertiajs/vue3";
import { filterStore } from "@/Store/filterStore.js";
import { numWord } from "@/Services/numWord.js";
import _ from "lodash";
import Button from "@/components/ui/Button.vue";
import CitySelectIntro from "@/components/ui/CitySelectIntro.vue";
import MetroSelectIntro from "@/components/ui/MetroSelectIntro.vue";
import FilterAttrToggle from "@/components/ui/FilterAttrToggle.vue";

export default {
  components: {
    Button,
    CitySelectIntro,
    MetroSelectIntro,
    FilterAttrToggle,
  },
  props: {},
  mounted() {    
    this.$eventBus.on("filters-inited", (e) => this.updateFilters(["total", "metros"]));
    let initPromise = new Promise((resolve, reject) => {
      resolve(
        this.filterStore.init(usePage().url, this.$page.props.location)
      );
    });

    initPromise
      .then((inited) => {
        this.$eventBus.emit("filters-inited");
        console.log("filters inited");
      });          
  },
  unmounted() {
    this.$eventBus.off("filters-inited");    
  },
  data() {
    return {
      filterStore,
    };
  },
  computed: {
    foundMessage() {
      let objectWords;
      if (this.filterStore.getFiltersValues().isRoomsFilter == true)
        objectWords = ["номер", "номера", "номеров"];
      else objectWords = ["отель", "отеля", "отелей"];
      return (
        usePage().props.total +
        " " +
        numWord(usePage().props.total, objectWords)
      );
    },
  },
  methods: {
    getDataOnList() {
      this.$inertia.get("/search", this.filterStore.getFiltersValues(), {
        replace: true,
        preserveState: true,
        preserveScroll: true,
        only: ["hotels", "rooms"],
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
        only: ["hotels", "rooms", "map_center"],
        //onSuccess: () => {},
        onStart: () => {
          usePage().props.isLoadind = true;
        },
        onFinish: () => {
          usePage().props.isLoadind = false;
          this.$eventBus.emit("data-received");
        },
      });
    },
    updateFilters(only) {
      let data = this.filterStore.getFiltersValues();
      this.$inertia.get("/", data, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: only ?? [],
      });
    },
    filterValueHandler(model, isAttr = false, key, value) {
      let propsToUpdate = ["total"];
      if (key == "city") {
        this.filterStore.removeFilter("hotels", "city_area");
        this.filterStore.removeFilter("hotels", "city_district");
        this.filterStore.removeFilter("hotels", "metro");
        propsToUpdate = _.union(propsToUpdate, [
          "total",
          "metros",          
        ]);
      }      

      if (value == null) {
        this.filterStore.removeFilter(model, key);
      } else {
        this.filterStore.updateFilter(model, isAttr, key, value);
      }

      this.updateFilters(propsToUpdate);
    },    
  },  
};
</script>
