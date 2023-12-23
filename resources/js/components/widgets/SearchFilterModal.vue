<template>
  <div    
    class="items-center justify-center fixed top-0 left-0 z-40 bg-[#D2DAF0B3] w-full h-[100vh] overflow-hidden backdrop-blur-[2.5px] flex"
  >
    <div
      class="flex flex-grow flex-col lg:gap-[8px] gap-[32px] max-w-[890px] w-full pb-[15px] md:overflow-hidden max-[768px]:pb-[40px] pt-[40px] overflow-x-hidden scrollbar overflow-y-auto md:px-[20px] px-0 h-[100%] relative"
    >
      <button
        @click="close(true)"
        class="absolute right-0 max-[768px]:right-[10px] top-[15px] max-[768px]:top-0 w-[32px] h-[32px] md:bg-white bg-transparent rounded-[8px] flex items-center justify-center"
      >
        <img src="/img/close.svg" alt="close"/>     
      </button>
      <div class="max-w-[832px] w-full mx-auto px-[16px]">
        <div class="lg:block flex flex-col relative">
          <Search for-modal />
          <div class="flex justify-between ordering">
            <div
              class="lg:p-[8px] p-[24px] bg-[#EAEFFD] rounded-b-[16px] lg:rounded-t-none lg:w-[fit-content] w-full rounded-t-[16px] items-center gap-[8px] flex-wrap justify-center flex"
            >
              <filter-attr-toggle
                title="Low Cost"
                type="small"
                initial-value="true"
                :model-value="$page.props?.filters?.rooms?.low_cost ?? null"
                @update:modelValue="
                  (event) =>
                    filterValueHandler('rooms', false, 'low_cost', event)
                "
              />
              <filter-attr-toggle
                title="От 1 часа"
                type="small"
                :initial-value="68"
                :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 68)"
                @update:modelValue="
                  (event) => filterValueHandler('rooms', true, 'attr_68', event)
                "
              />
              <filter-attr-toggle
                title="Горящие"
                type="small"
                initial-value="true"
                :model-value="$page.props?.filters?.rooms?.is_hot ?? null"
                @update:modelValue="
                  (event) =>
                    filterValueHandler('rooms', false, 'is_hot', event)
                "
              />
              <filter-attr-toggle title="Кешбэк" type="small" disabled />
              <filter-attr-toggle
                title="Арт дизайн"
                type="small"
                :initial-value="52"
                :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 52)"
                @update:modelValue="
                  (event) => filterValueHandler('rooms', true, 'attr_52', event)
                "
              />
              <filter-attr-toggle
                title="Джакузи"
                type="small"
                :initial-value="65"
                :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == 65)"
                @update:modelValue="
                  (event) => filterValueHandler('rooms', true, 'attr_65', event)
                "
              />
            </div>
          </div>
          <div
            ref="tags"
            class="md:p-[8px] p-0 pt-[8px] flex items-center gap-[8px] flex-wrap lg:mb-0 mb-[32px]"
          >
            <city-filter-tag
              v-if="$page.props?.filters?.hotels?.city"
              :title="$page.props?.filters?.hotels?.city"
              :cities="$page.props?.city_tag_list ?? []"        
            />
            <filter-tag
              v-for="tag in ($page.props?.filter_tags ?? [])" v-bind:key="tag.key + '_' + tag.value"
              :title="tag.title"
              :filter-model="tag.modelType"
              :filter-key="tag.key"
              :is-attribute="tag.isAttribute"
              :filter-value="tag.value"
              :removable="true"
              @tag-closed="(event) => closeTag(event)"
            />
          </div>
        </div>
      </div>

      <div
        class="max-w-[832px] mx-auto w-full px-[16px] max-[768px]:mb-[40px] md:h-full"
      >
        <div
          ref="filterContent"
          @click="filterContentResize"
          class="scrollbar overflow-y-auto max-h-auto bg-transparent"
          :class="innerWidth < 860 ? 'w-full' : 'w-[820px]'"
          :style="
            innerWidth > 768 ? 'max-height: ' + (innerHeight - 250 - tagsHeight) + 'px;' : ''
          "
        >
          <div
            class="bg-[#EAEFFD] rounded-t-[16px] max-w-[800px] w-full md:rounded-b-none rounded-b-[16px]"
          >
            <p
              class="px-[16px] py-[15px] text-[16px] leading-[19px] font-semibold"
            >
              Фильтры
            </p>
            <div
              class="grid md:grid-cols-4 grid-cols-2 gap-[16px] p-[16px] bg-[#EAEFFD] shadow-sm"
            >
              <div class="">
                <p class="text-[14px] leading-[16px] mb-[8px]">Тип заведения</p>
                <filter-select
                  :options-array="$page.props.hotel_types ?? []"
                  placeholder="Все"
                  :model-value="$page.props?.filters?.hotels?.type ?? null"
                  @update:modelValue="
                    (event) =>
                      filterValueHandler('hotels', false, 'type', event)
                  "
                />
                <div class="hidden md:flex w-full">
                  <filter-attr-toggle
                    title="Горящие предложения"
                    img="/img/flash.svg"
                    toggle-img="/img/flash2.svg"
                    type="vertical"
                    initial-value="true"
                    :model-value="$page.props?.filters?.rooms?.is_hot ?? null"
                    @update:modelValue="
                      (event) =>
                        filterValueHandler('rooms', false, 'is_hot', event)
                    "                    
                  />
                </div>
              </div>
              <div class="">
                <p class="text-[14px] leading-[16px] mb-[8px]">Рейтинг</p>
                <rating-select />
                <div class="hidden md:flex w-full">
                  <filter-attr-toggle
                    title="Кешбэк"
                    img="/img/cashback.svg"
                    toggle-img="/img/cashback2.svg"
                    type="vertical"
                    disabled
                  />
                </div>
              </div>
              <div>
                <p class="text-[14px] leading-[16px] mb-[8px]">Расположение</p>
                <div class="grid gap-[16px]">
                  <city-select
                    searchable
                    placeholder="Город"
                    :model-value="$page.props?.filters?.hotels?.city ?? null"
                    :options-array="$page.props.cities ?? []"
                    :position="
                      filterContentScroll == true
                        ? 'relative'
                        : 'relative md:static'
                    "
                    @update:modelValue="
                      (event) =>
                        filterValueHandler('hotels', false, 'city', event)
                    "
                  />

                  <city-area-select
                    placeholder="Округ"
                    :model-value="$page.props?.filters?.hotels?.area ?? null"
                    searchable
                    :options-array="$page.props.city_areas ?? []"
                    :position="
                      filterContentScroll == true
                        ? 'relative'
                        : 'relative md:static'
                    "
                    @update:modelValue="
                      (event) =>
                        filterValueHandler('hotels', false, 'area', event)
                    "
                  />

                  <city-area-select
                    placeholder="Район"
                    :model-value="$page.props?.filters?.hotels?.district ?? null"
                    searchable
                    :options-array="$page.props.city_districts ?? []"
                    :position="
                      filterContentScroll == true
                        ? 'relative'
                        : 'relative md:static'
                    "
                    @update:modelValue="
                      (event) =>
                        filterValueHandler(
                          'hotels',
                          false,
                          'district',
                          event
                        )
                    "
                  />

                  <metro-select
                    type="form"
                    searchable
                    placeholder="Станция метро"
                    :model-value="$page.props?.filters?.hotels?.metro ?? null"
                    :options-array="$page.props.metros ?? []"
                    :position="
                      filterContentScroll == true
                        ? 'relative'
                        : 'relative md:static'
                    "
                    @update:modelValue="
                      (event) =>
                        filterValueHandler('hotels', false, 'metro', event)
                    "
                  />
                </div>
              </div>
              <div
                class="md:col-start-4 md:row-start-1 col-start-1 row-start-2"
              >
                <p class="text-[14px] leading-[16px] mb-[8px]">Период</p>
                <period-cost-select
                  :options="$page.props.cost_types"
                  :model-value="$page.props?.filters?.rooms?.period_cost ?? null"
                  @update:modelValue="
                    (event) =>
                      filterValueHandler('rooms', false, 'period_cost', event)
                  "
                />
              </div>
              <div class="col-span-2 md:hidden grid gap-[16px]">
                <filter-attr-toggle
                  title="Программа кешбэк"
                  img="/img/cashback.svg"
                  toggle-img="/img/cashback2.svg"
                  type="small"
                  disabled
                />
                <filter-attr-toggle
                  title="Горящие предложения"
                  img="/img/flash.svg"
                  toggle-img="/img/flash2.svg"
                  type="small"
                  initial-value="true"
                  :model-value="$page.props?.filters?.rooms?.is_hot ?? null"
                  @update:modelValue="
                    (event) =>
                      filterValueHandler('rooms', false, 'is_hot', event)
                    "
                />
              </div>
            </div>
            <filter-collapse title="Детально об отеле">
              <div v-if="$page.props?.is_moderator === true">
                <span class="inline-block md:pt-[16px] pt-0 md:px-[16px] px-[24px] text-[16px] leading-[19px]">Модерация</span>
                <div class="flex flex-wrap md:p-[8px] p-[16px] m-[8px]">
                  <filter-attr-toggle
                    title="На модерации"
                    type="small"
                    initial-value="true"
                    :model-value="$page.props?.filters?.hotel?.moderate ?? null"
                    @update:modelValue="
                      (event) => filterValueHandler('hotels', false, 'moderate', event)
                    "
                  />
                </div>
              </div>
              <div v-for="category in $page.props.attribute_categories">
                <div
                  v-if="
                    $page.props.attributes.filter(
                      (el) =>
                        el.category == 'hotel' &&
                        el.attribute_category_id == category.id
                    ).length > 0
                  "
                >
                  <span
                    class="inline-block md:pt-[16px] pt-0 md:px-[16px] px-[24px] text-[16px] leading-[19px]"
                    >{{ category.name }}</span
                  >
                  <div class="flex flex-wrap md:p-[8px] p-[16px]">
                    <div
                      v-for="attribute in $page.props.attributes.filter(
                        (el) =>
                          el.category == 'hotel' &&
                          el.attribute_category_id == category.id
                      )"
                      :key="attribute"
                      class="m-[8px]"
                    >
                      <filter-attr-toggle
                        :title="attribute.name"
                        type="small"
                        :initial-value="attribute.id"
                        :model-value="($page.props?.filters?.hotels?.attrs ?? []).find(e => e == attribute.id)"
                        @update:modelValue="
                          (event) =>
                            filterValueHandler(
                              'hotels',
                              true,
                              'attr_' + attribute.id,
                              event
                            )
                        "
                      />
                    </div>
                  </div>
                </div>
              </div>
            </filter-collapse>

            <filter-collapse title="Детально о номере">
              <div v-for="category in $page.props.attribute_categories">
                <div
                  v-if="
                    $page.props.attributes.filter(
                      (el) =>
                        el.category == 'room' &&
                        el.attribute_category_id == category.id
                    ).length > 0
                  "
                >
                  <span
                    class="inline-block md:pt-[16px] pt-0 md:px-[16px] px-[24px] text-[16px] leading-[19px]"
                    >{{ category.name }}</span
                  >
                  <div class="flex flex-wrap md:p-[8px] p-[16px]">
                    <div
                      v-for="attribute in $page.props.attributes.filter(
                        (el) =>
                          el.category == 'room' &&
                          el.attribute_category_id == category.id
                      )"
                      class="m-[8px]"
                    >
                      <filter-attr-toggle
                        :title="attribute.name"
                        type="small"
                        :initial-value="attribute.id"
                        :model-value="($page.props?.filters?.rooms?.attrs ?? []).find(e => e == attribute.id)"
                        @update:modelValue="
                          (event) =>
                            filterValueHandler(
                              'rooms',
                              true,
                              'attr_' + attribute.id,
                              event
                            )
                        "
                      />
                    </div>
                  </div>
                </div>
              </div>
            </filter-collapse>
          </div>
        </div>
        <div
          class="bg-transparent md:h-[80px] h-auto w-full flex items-center justify-center"
        >
          <div
            class="md:w-full w-[calc(100%-48px)] h-full px-[16px] md:py-0 py-[16px] bg-white rounded-b-[24px] flex md:flex-row flex-col items-center justify-between gap-[16px] md:max-w-none max-w-[400px]"
          >
            <div
              class="flex items-center justify-between md:gap-[54px] gap-[10px] md:w-initial w-full"
            >
              <span class="text-[14px] leading-[16px] font-semibold"
                >{{ foundMessage }}</span
              >
              <button
                @click="clearFilters()"
                class="text-[14px] leading-[16px] underline"
              >
                Очистить фильтры
              </button>
            </div>
            <div
              class="flex items-center gap-[8px] md:justify-end justify-between md:w-initial w-full flex-wrap"
            >
              <button
                @click="getDataOnMap()"
                class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150"
              >
                <img src="/img/map2.svg" alt="map" width="24" height="24"/>
                <span class="text-white">На карте</span>
              </button>
              <button
                @click="getDataOnList()"
                class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150"
              >
                <img src="/img/listpointers2.svg" alt="list" width="24" height="24"/>
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
import SearchPanel from "@/components/widgets/SearchPanel.vue";
import { numWord } from "@/Services/numWord.js";
import {_updateFilterValue, _getFiltersData, _getData, getFoundMessage} from "@/Services/filterUtils.js";
import FilterSelect from "@/components/ui/FilterSelect.vue";
import Button from "@/components/ui/Button.vue";
import CitySelect from "@/components/ui/CitySelect.vue";
import CityAreaSelect from "@/components/ui/CityAreaSelect.vue";
import CityDistrictSelect from "@/components/ui/CityDistrictSelect.vue";
import MetroSelect from "@/components/ui/MetroSelect.vue";
import RatingSelect from "@/components/ui/RatingSelect.vue";
import PeriodCostSelect from "@/components/ui/PeriodCostSelect.vue";
import FilterAttrToggle from "@/components/ui/FilterAttrToggle.vue";
import FilterTag from "@/components/ui/FilterTag.vue";
import FilterCollapse from "@/components/ui/FilterCollapse.vue";
import Search from "./Search.vue";
import CityFilterTag from "@/components/ui/CityFilterTag.vue";

export default {
  components: {
    SearchPanel,
    FilterSelect,
    Button,
    CitySelect,
    CityAreaSelect,
    MetroSelect,
    PeriodCostSelect,
    FilterAttrToggle,
    FilterTag,
    FilterCollapse,
    RatingSelect,
    Search,
    CityFilterTag,
  }, 
  data() {
    return {     
      foundMessage: "",
      initialUrl: this.$page.url, 
      initialFilters: {},
      initialTags: [],  
      innerWidth: 0,
      innerHeight: 0,
      tagsHeight: 48,
      filterContentScroll: false,
    };
  },
  mounted() {   
    if (typeof window !== "undefined") {
        window.addEventListener("resize", this.handleResize);
        this.initialUrl = window.location.href;
      }

      this.initialFilters = JSON.parse(JSON.stringify(this.$page.props.filters));
      this.initialTags = JSON.parse(JSON.stringify(this.$page.props.filter_tags));
        
      this.updateFilters(["total", "metros", "city_areas", "city_districts"]);
      this.handleResize();
  },
  unmounted() {
    window.removeEventListener("resize", this.handleResize);
  },
  methods: {
    close(resoreState = false) {      
      if (resoreState === true) {
        if (typeof window !== "undefined") window.history.pushState({}, this.$page.title, this.initialUrl);
        this.$page.props.filters = JSON.parse(JSON.stringify(this.initialFilters));
        this.$page.props.filter_tags = JSON.parse(JSON.stringify(this.initialTags));
      }

      if (typeof window !== "undefined") {
        window.removeEventListener("resize", this.handleResize);        
      }
      
      if (this.$page.props?.filters?.as != 'map')
        document.body.classList.remove("fixed");
      
      this.$page.props.modals.filters = false;    
    },    
    updateFoundMessage() {
      let total = this.$page.props?.total ?? 0;
      let type = this.$page.props.filters?.room_filter === true ? 
        'rooms' : this.$page.props.filters?.hotels?.type == 3 ? 'appartments' : 'hotels';

      this.foundMessage = getFoundMessage(total, type);
    },
    handleResize() {      
      if (this.$page.props?.modals?.filters === true && typeof window !== "undefined") {
        this.innerHeight = window.innerHeight;
        this.innerWidth = window.innerWidth;
        this.tagsHeight = this.$refs.tags.clientHeight;
        this.filterContentResize();
      }
    },
    filterContentResize() {
      if (this.$refs.filterContent)
        this.filterContentScroll =
          this.$refs.filterContent.clientHeight <
          this.$refs.filterContent.scrollHeight;
    },
    getDataOnList() {
      let data = _getFiltersData.call(this);
      _getData.call(this, '/search', data);
      this.$page.props.modals.search = true;
      this.close();
    },
    getDataOnMap() { 
      let data = _getFiltersData.call(this);
      data.as = 'map';
      _getData.call(this, '/search', data, () => {this.$eventBus.emit("data-received")});
      this.close();
    },
    updateFilters(props, data = null) {
      data = data !== null ? data : _getFiltersData.call(this, true);
      this.$inertia.get(this.url ?? this.$page.url.split("?")[0], data, {     
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: props ?? [],
        onFinish: () => {       
          this.updateFoundMessage();
          this.handleResize();          
        },
      });
    },  
    clearFilters() {
      let data = {};

      if (this.$page.props?.filters?.hotels?.city) {
        data.hotels = {};
        data.hotels.city = this.$page.props?.filters?.hotels?.city;
      }
        
      this.updateFilters(["total", "filters", "filter_tags"], data);
    },
    filterValueHandler(model, isAttr = false, key, value) {
      _updateFilterValue.call(this, model, isAttr, key, value);

      let props = ["total", "filters", 'filter_tags', 'city_tag_list'];
      if (key == "city") {
        this.$page.props.filters.hotels.area = null;
        this.$page.props.filters.hotels.district = null;
        this.$page.props.filters.hotels.metro = null;        
        props.push("metros", "city_areas", "city_districts");
      }

      if (key == "area") {
        this.$page.props.filters.hotels.district = null;  
        props.push("metros", "city_districts");
      }

      if (key == "district") {
        props.push("metros");        
      }

      this.updateFilters(props);
    },
    closeTag(obj) {
      this.filterValueHandler(obj.modelType, obj.isAttribute, obj.key, null);
    },
  },  
};
</script>

<style>
.ordering {
  order: 3;
}
</style>