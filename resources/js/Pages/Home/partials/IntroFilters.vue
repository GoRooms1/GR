<template>
  <div class="mx-[1.625rem] relative z-10 flex flex-col items-center">
    <div
      class="w-full p-6 bg-[#EAEFFD] rounded-3xl grid grid-cols-2 grid-rows-7 max-[330px]:grid-cols-1 max-[330px]:grid-rows-14 gap-4"
    >
      <city-select-intro
        searchable
        placeholder="Город"
        v-model="city"
        :options-array="$page.props.cities ?? []"
      />
      <metro-select-intro
        searchable
        placeholder="Станция метро"
        v-model="metro"
        :options-array="$page.props.metros ?? []"
      />

      <filter-attr-toggle
        title="Low Cost"
        img="img/low-cost.svg"
        toggle-img="img/low-cost2.svg"
        type="horizontal"
        initial-value="true"
        v-model="low_cost"
      />
      <filter-attr-toggle
        title="От 1 часа"
        img="img/hour.svg"
        toggle-img="img/hour2.svg"
        type="horizontal"
        :initial-value="68"
        :model-value="filterStore.getFilterValue('rooms', 'attr_68')"
        @update:modelValue="(event) => attributeHandler('rooms', event, 68)"
      />
      <filter-attr-toggle
        title="Горящие предложения"
        img="img/flash.svg"
        toggle-img="img/flash2.svg"
        type="horizontal"
        initial-value="true"
        v-model="is_hot"
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
        @update:modelValue="(event) => attributeHandler('rooms', event, 52)"
      />
      <filter-attr-toggle
        title="Джакузи"
        img="img/jacuzzi.svg"
        toggle-img="img/jacuzzi2.svg"
        type="horizontal"
        :initial-value="65"
        :model-value="filterStore.getFilterValue('rooms', 'attr_65')"
        @update:modelValue="(event) => attributeHandler('rooms', event, 65)"
      />
    </div>
    <div
      class="md:w-full w-[calc(100%-48px)] h-full px-[16px] md:py-0 pb-[16px] pt-[10px] bg-white rounded-b-[24px] flex md:flex-row flex-col items-center justify-between gap-[16px] md:max-w-none max-w-[400px]"
    >
      <div
        class="flex items-center justify-center md:gap-[54px] gap-[10px] md:w-initial w-full"
      >
        <span class="text-[0.875rem] leading-[16px]"
          >Найдено {{ foundMessage }}</span
        >
      </div>
      <div
        class="flex items-center gap-[16px] md:justify-end justify-between md:w-initial w-full flex-wrap"
      >
        <Button @click="getDataOnMap()">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M15 3V19"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M9 5V21"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M3 3L9 5L15 3L21 5V21L15 19L9 21L3 19V3Z"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
          </svg>
          <span class="text-white">На карте</span>
        </Button>
        <Button @click="getDataOnList()">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.85718 7H21"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M6.85718 12.143H21"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M6.85718 17.2857H21"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M3 7V7.01284"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M3 12.143V12.1558"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
            <path
              d="M3 17.2857V17.2985"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></path>
          </svg>
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

let filterGetSetObj = function (model, key) {
  return {
    get() {
      return this.filterStore.getFilterValue(model, key);
    },
    set(val) {
      if (val) this.filterStore.updateFilter(model, false, key, val);
      if (val === null) this.filterStore.removeFilter(model, key);
    },
  };
};

export default {
  components: {
    Button,
    CitySelectIntro,
    MetroSelectIntro,
    FilterAttrToggle,
  },
  props: {},
  created() {
    this.filterStore.init(usePage().url, this.$page.props.location);
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
    attributes() {
      return _.cloneDeep(
        _.filter(
          this.filterStore.filters,
          (el) => !nonAtrributes.includes(el.key)
        )
      );
    },
    city: filterGetSetObj("hotels", "city"),
    metro: filterGetSetObj("hotels", "metro"),
    is_hot: filterGetSetObj("rooms", "is_hot"),
    low_cost: filterGetSetObj("rooms", "low_cost"),
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
        only: ["hotels", "rooms"],
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
    attributeHandler(modelType, filterValue, attrID) {
      if (filterValue == null)
        this.filterStore.removeFilter(modelType, "attr_" + attrID);
      else
        this.filterStore.addFilter(modelType, true, "attr_" + attrID, attrID);

      this.updateFilters(["total"]);
    },
  },
  watch: {
    city: {
      handler(newVal, oldVal) {
        if (oldVal != newVal) {
          this.metro = null;
          this.updateFilters(["total", "metros"]);
        }
      },
    },
    metro: function (newVal, oldVal) {
      if (oldVal != newVal && newVal != null) {
        this.updateFilters(["total"]);
      }

      if (oldVal != null && newVal == null) {
        this.updateFilters(["total", "metros"]);
      }
    },
    is_hot: function (newVal, oldVal) {
      if (oldVal != newVal) {
        this.updateFilters(["total"]);
      }
    },
    low_cost: function (newVal, oldVal) {
      if (oldVal != newVal) {
        this.updateFilters(["total"]);
      }
    },
  },
};
</script>
