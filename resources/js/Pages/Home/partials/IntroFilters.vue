<template>
  <div class="mx-[1.625rem] relative z-10 flex flex-col items-center">
    <div
      class="w-full p-6 bg-[#EAEFFD] rounded-3xl grid grid-cols-2 grid-rows-7 max-[330px]:grid-cols-1 max-[330px]:grid-rows-14 gap-4"
    >
      <city-select-intro
        searchable
        placeholder="Город"        
        :options-array="$page.props.cities ?? []"
        :model-value="$page.props?.filters?.hotels?.city ?? null"
        @update:modelValue="(event) => filterValueHandler('hotels', false, 'city', event)"
      />
      <metro-select-intro
        searchable
        placeholder="Станция метро"        
        :options-array="$page.props.metros ?? []"
        :model-value="$page.props?.filters?.hotels?.metro ?? null"
        @update:modelValue="(event) => filterValueHandler('hotels', false, 'metro', event)"
      />

      <filter-attr-toggle
        title="Low Cost"
        img="img/low-cost.svg"
        toggle-img="img/low-cost2.svg"
        type="horizontal"
        initial-value="true"
        :model-value="$page.props?.filters?.rooms?.low_cost ?? null"
        @update:modelValue="(event) => filterValueHandler('rooms', false, 'low_cost', event)"
      />
      <filter-attr-toggle
        title="От 1 часа"
        img="img/hour.svg"
        toggle-img="img/hour2.svg"
        type="horizontal"
        :initial-value="68"
        :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 68)"
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
        :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 52)"
        @update:modelValue="(event) => filterValueHandler('rooms', true, 'attr_52', event)"
      />
      <filter-attr-toggle
        title="Джакузи"
        img="img/jacuzzi.svg"
        toggle-img="img/jacuzzi2.svg"
        type="horizontal"
        :initial-value="65"
        :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 65)"
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
          >{{ foundMessage }}</span
        >
      </div>
      <div
        class="flex items-center gap-[16px] md:justify-end justify-between md:w-initial w-full flex-wrap"
      >
        <Button @click="getDataOnMap()">
          <img src="/img/map2.svg" alt="map" width="24" height="24"/>
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
import { numWord } from "@/Services/numWord.js";
import Button from "@/components/ui/Button.vue";
import CitySelectIntro from "@/components/ui/CitySelectIntro.vue";
import MetroSelectIntro from "@/components/ui/MetroSelectIntro.vue";
import FilterAttrToggle from "@/components/ui/FilterAttrToggle.vue";
import {_updateFilterValue, _getFiltersData, _getData} from "@/Services/filterUtils.js";

export default {
  components: {
    Button,
    CitySelectIntro,
    MetroSelectIntro,
    FilterAttrToggle,
  }, 
  mounted() {
    this.updateFoundMessage();
  },  
  data() {
    return {      
      foundMessage: "",
    };
  },  
  methods: {
    updateFoundMessage() {
      let total = this.$page.props?.total ?? 0;

      if (total === 0) {
        this.foundMessage = "По вашему запросу ничего не нашлось";
        return;
      }

      let objectWords = ["отель", "отеля", "отелей"];
      if (this.$page.props.filters?.room_filter === true) objectWords = ["номер", "номера", "номеров"];
      this.foundMessage = numWord(total, ["Найден", "Найдено", "Найдено"]) + " " + total + " " + numWord(total, objectWords);
    },
    getDataOnList() {
      let data = _getFiltersData.call(this);
      _getData.call(this, '/search', data);      
    },
    getDataOnMap() { 
      let data = _getFiltersData.call(this);
      _getData.call(this, '/search_map', data, () => {this.$eventBus.emit("data-received")});      
    },
    updateFilters(props) {
      let data = _getFiltersData.call(this);
      this.$inertia.get("/", data, {     
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: props ?? [],
        onFinish: () => {       
          this.updateFoundMessage();          
        },
      });
    },
    filterValueHandler(model, isAttr = false, key, value) {
      _updateFilterValue.call(this, model, isAttr, key, value);

      let props = ["total", "filters", 'filter_tags'];
      if (key == "city") {        
        this.$page.props.filters.hotels.metro = null;
        props.push("metros");
      }

      this.updateFilters(props);
    },    
  },  
};
</script>
