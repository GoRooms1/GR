<template>
  <div
    v-if="isOpen"
    class="items-center justify-center fixed top-0 left-0 z-40 bg-[#D2DAF0B3] w-full h-[100vh] overflow-hidden backdrop-blur-[2.5px] flex"
  >
    <div
      class="flex flex-grow flex-col lg:gap-[8px] gap-[32px] max-w-[890px] w-full pb-[15px] md:overflow-hidden max-[768px]:pb-[40px] max-[768px]:pt-[40px] pt-[15px] overflow-x-hidden scrollbar overflow-y-auto md:px-[20px] px-0 h-[100%] relative"
    >
      <button
        @click="close()"
        class="absolute right-0 max-[768px]:right-[10px] top-[15px] max-[768px]:top-0 w-[32px] h-[32px] md:bg-white bg-transparent rounded-[8px] flex items-center justify-center"
      >
        <svg
          width="16"
          height="16"
          viewBox="0 0 16 16"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M1 1L15 15"
            stroke="#6170FF"
            stroke-width="2"
            stroke-linecap="round"
          ></path>
          <path
            d="M1 15L15 1"
            stroke="#6170FF"
            stroke-width="2"
            stroke-linecap="round"
          ></path>
        </svg>
      </button>      
      <div class="max-w-[832px] w-full mx-auto px-[16px]">
        <div class="lg:block flex flex-col relative">
          <Search for-modal/>
          <div class="flex justify-between ordering">
            <div
              class="lg:p-[8px] p-[24px] bg-[#EAEFFD] rounded-b-[16px] lg:rounded-t-none lg:w-[fit-content] w-full rounded-t-[16px] items-center gap-[8px] flex-wrap justify-center flex"
            >
              <filter-attr-toggle
                title="Low Cost"
                type="small"
                initial-value="true"
                :model-value="
                  tempFilterStore.getFilterValue('rooms', 'low_cost')
                "
                @update:modelValue="
                  (event) =>
                    filterValueHandler('rooms', false, 'low_cost', event)
                "
              />
              <filter-attr-toggle
                title="От 1 часа"
                type="small"
                :initial-value="68"
                :model-value="
                  tempFilterStore.getFilterValue('rooms', 'attr_68')
                "
                @update:modelValue="
                  (event) => filterValueHandler('rooms', true, 'attr_68', event)
                "
              />
              <filter-attr-toggle
                title="Горящие"
                type="small"
                initial-value="true"
                :model-value="tempFilterStore.getFilterValue('rooms', 'is_hot')"
                @update:modelValue="
                  (event) => filterValueHandler('rooms', false, 'is_hot', event)
                "
              />
              <filter-attr-toggle title="Кешбэк" type="small" disabled />
              <filter-attr-toggle
                title="Арт дизайн"
                type="small"
                :initial-value="52"
                :model-value="
                  tempFilterStore.getFilterValue('rooms', 'attr_52')
                "
                @update:modelValue="
                  (event) => filterValueHandler('rooms', true, 'attr_52', event)
                "
              />
              <filter-attr-toggle
                title="Джакузи"
                type="small"
                :initial-value="65"
                :model-value="
                  tempFilterStore.getFilterValue('rooms', 'attr_65')
                "
                @update:modelValue="
                  (event) => filterValueHandler('rooms', true, 'attr_65', event)
                "
              />
            </div>
            <!-- <div class="lg:block hidden p-[8px] bg-[#EAEFFD] rounded-b-[16px]">
                            <button class="flex items-center gap-[16px] p-[8px]">
                                <span class="text-[14px] leading-[16px] whitespace-nowrap">Больше фильтров</span>
                                <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.83301 13.0002L5.99967 17.1669L10.1663 13.0002" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M10.167 7.16692L6.00033 3.00025L1.83366 7.16692" stroke="#6171FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div> -->
          </div>
          <div
            class="md:p-[8px] p-0 pt-[8px] flex items-center gap-[8px] flex-wrap lg:mb-0 mb-[32px]"
          >
            <filter-tag
              v-for="tag in tempFilterStore.filters ?? []"
              :filter-model="tag.modelType"
              :filter-key="tag.key"
              :is-attribute="tag.isAttribute"
              :filter-value="tag.value"
              :removable="tag.key == 'city' ? false : true"
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
            innerWidth > 768 ? 'max-height: ' + (innerHeight - 300) + 'px;' : ''
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
                  :model-value="
                    tempFilterStore.getFilterValue('hotels', 'hotel_type')
                  "
                  @update:modelValue="
                    (event) =>
                      filterValueHandler('hotels', false, 'hotel_type', event)
                  "
                />
                <div class="hidden md:flex w-full">
                  <filter-attr-toggle
                    title="Горящие предложения"
                    img="/img/flash.svg"
                    toggle-img="/img/flash2.svg"
                    type="vertical"
                    initial-value="true"
                    :model-value="
                      tempFilterStore.getFilterValue('rooms', 'is_hot')
                    "
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
                    :model-value="
                      tempFilterStore.getFilterValue('hotels', 'city')
                    "
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
                    :model-value="
                      tempFilterStore.getFilterValue('hotels', 'city_area')
                    "
                    searchable
                    :options-array="$page.props.city_areas ?? []"
                    :position="
                      filterContentScroll == true
                        ? 'relative'
                        : 'relative md:static'
                    "
                    @update:modelValue="
                      (event) =>
                        filterValueHandler('hotels', false, 'city_area', event)
                    "
                  />

                  <city-area-select
                    placeholder="Район"
                    :model-value="
                      tempFilterStore.getFilterValue('hotels', 'city_district')
                    "
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
                          'city_district',
                          event
                        )
                    "
                  />

                  <metro-select
                    type="form"
                    searchable
                    placeholder="Станция метро"
                    :model-value="
                      tempFilterStore.getFilterValue('hotels', 'metro')
                    "
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
                  :model-value="
                    tempFilterStore.getFilterValue('rooms', 'period_cost')
                  "
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
                  :model-value="
                    tempFilterStore.getFilterValue('rooms', 'is_hot')
                  "
                  @update:modelValue="
                    (event) =>
                      filterValueHandler('rooms', false, 'is_hot', event)
                  "
                />
              </div>
            </div>
            <filter-collapse title="Детально об отеле">
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
                        :model-value="
                          tempFilterStore.getFilterValue(
                            'hotels',
                            'attr_' + attribute.id
                          )
                        "
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
                        :model-value="
                          tempFilterStore.getFilterValue(
                            'rooms',
                            'attr_' + attribute.id
                          )
                        "
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
                >Найдено {{ foundMessage ?? 0 }}</span
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
                class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150"
              >
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
              </button>
              <button
                @click="getData()"
                class="flex items-center justify-center gap-[8px] xs:flex-grow-0 flex-grow bg-[#6171FF] h-[48px] px-[16px] rounded-[8px] md:hover:bg-[#3B24C6] transition duration-150"
              >
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
import { usePage } from "@inertiajs/inertia-vue3";
import { filterStore } from "@/Store/filterStore.js";
import { tempFilterStore } from "@/Store/tempFilterStore.js";
import { numWord } from "@/Services/numWord.js";
import _ from "lodash";
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
  },
  created() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
  },
  mounted() {
    let initPromise = new Promise((resolve, reject) => {
      resolve(
        this.filterStore.init(
          usePage().props.value.query_string ?? usePage().url.value
        )
      );
    });

    initPromise.then((value) => {
      this.inited = true;
      this.tempFilterStore.filters = _.cloneDeep(this.filterStore.filters);

      if (value == true) this.getData();
    });
  },
  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },
  data() {
    return {
      inited: false,
      filterStore,
      initialUrl: usePage().url.value,
      tempFilterStore,
      innerWidth: window.innerWidth,
      innerHeight: window.innerHeight,
      filterContentScroll: false,
    };
  },
  computed: {
    isOpen() {
      return usePage().props.value.modals?.filters ?? false;
    },
    foundMessage() {
      let objectWords;
      if (this.tempFilterStore.getFiltersValues().isRoomsFilter == true)
        objectWords = ["номер", "номера", "номеров"];
      else objectWords = ["отель", "отеля", "отелей"];

      return (
        usePage().props.value.total +
        " " +
        numWord(usePage().props.value.total, objectWords)
      );
    },
    filters() {
      return _.cloneDeep(this.filterStore.filters);
    },
  },
  methods: {
    close() {
      window.history.pushState({}, this.$page.title, this.initialUrl);
      usePage().props.value.modals.filters = false;
      document.body.classList.remove("fixed");
    },
    handleResize() {
      if (this.isOpen) {
        this.innerHeight = window.innerHeight;
        this.innerWidth = window.innerWidth;
        this.filterContentResize();
      }
    },
    filterContentResize() {
      if (this.$refs.filterContent)
        this.filterContentScroll =
          this.$refs.filterContent.clientHeight <
          this.$refs.filterContent.scrollHeight;
    },
    getData() {
      if (this.isOpen == true) {
        this.filterStore.filters = _.cloneDeep(this.tempFilterStore.filters);
      }

      this.$inertia.get(route("filter"), this.filterStore.getFiltersValues(), {
        preserveState: true,
        preserveScroll: true,
        onStart: () => {
          usePage().props.value.isLoadind = true;
          this.close();
        },
        onFinish: () => {
          usePage().props.value.isLoadind = false;
        },
      });
    },
    updateFilters(only) {
      let data = this.tempFilterStore.getFiltersValues();
      this.$inertia.get(route(route().current()), data, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: only ?? [],
      });
    },
    clearFilters() {
      this.tempFilterStore.clearFilters();
      this.updateFilters(["total"]);
    },
    filterValueHandler(model, isAttr = false, key, value) {
      let propsToUpdate = ["total"];
      if (key == "city") {
        this.tempFilterStore.removeFilter("hotels", "city_area");
        this.tempFilterStore.removeFilter("hotels", "city_district");
        this.tempFilterStore.removeFilter("hotels", "metro");
        propsToUpdate = _.union(propsToUpdate, [
          "total",
          "metros",
          "city_areas",
          "city_districts",
        ]);
      }

      if (key == "city_area") {
        this.tempFilterStore.removeFilter("hotels", "city_district");
        propsToUpdate = _.union(propsToUpdate, ["total", "city_districts"]);
      }

      if (value == null) {
        this.tempFilterStore.removeFilter(model, key);
      } else {
        this.tempFilterStore.updateFilter(model, isAttr, key, value);
      }

      this.updateFilters(propsToUpdate);
    },
    closeTag(obj) {
      this.filterValueHandler(obj.modelType, false, obj.key, null);
    },
  },
  watch: {
    isOpen: function (newVal, oldVal) {
      if (newVal == true && (!oldVal || oldVal == false)) {
        this.initialUrl = window.location.href;
        document.body.classList.add("fixed");
        this.tempFilterStore.filters = _.cloneDeep(this.filterStore.filters);
        this.updateFilters(["total"]);
      }
    },
    filters: {
      handler(newVal, oldVal) {
        if (
          !_.isEqual(newVal, oldVal) &&
          this.isOpen == false &&
          this.inited == true
        ) {
          this.getData();
        }
      },
      deep: true,
    },
  },
};
</script>

<style>
.ordering {
  order: 3;
}
</style>
