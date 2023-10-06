<template>
  <AppHead :title="page.title" />
  <div class="container mx-auto">
    <div class="py-4 lg:my-16 px-2 lg:px-6">
      <div v-html="page.header"></div>
      <div class="mb-4 flex flex-col lg:flex-row">
        <div
          v-html="page.content"
          class="flex flex-col lg:flex-row lg:w-1/2 text-sm leading-4 mb-8"
        ></div>
        <div class="flex lg:pl-12 justify-center lg:w-1/2">
          <div class="flex flex-col lg:flex-row items-center mr-6">
            <div class="text-blue-400 xl:text-6xl text-5xl font-semibold mr-2">
              {{ $page.props.count.cities }}
            </div>
            <div>городов</div>
          </div>
          <div class="flex flex-col lg:flex-row items-center mr-6">
            <div class="text-blue-400 xl:text-6xl text-5xl font-semibold mr-2">
              {{ $page.props.count.hotels }}
            </div>
            <div>отелей</div>
          </div>
          <div class="flex flex-col lg:flex-row items-center">
            <div class="text-blue-400 xl:text-6xl text-5xl font-semibold mr-2">
              {{ $page.props.count.rooms }}
            </div>
            <div>номеров</div>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap lg:flex -mx-3 pt-1">
        <div
          class="w-full px-3 mb-4"
          v-bind:class="isMapVisible ? '' : 'lg:w-3/12 md:w-1/2'"
        >
          <div class="w-full bg-white rounded-3xl p-4">
            <h3 class="font-semibold text-base mb-4">Контакты</h3>
            <div class="text-sm leading-4">
              <a
                :href="'tel:' + formatPhoneLink($page.props.contacts.phone2)"
                class="flex items-center mb-2"
              >
                <svg
                  width="20"
                  height="16"
                  viewBox="0 0 20 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M15.9996 12.7909V10.9845C16.007 10.6891 15.9053 10.4014 15.7139 10.176C15.1743 9.5404 13.3236 9.13387 12.59 9.29C12.0182 9.41173 11.6181 9.98587 11.227 10.3763C9.71642 9.519 8.46572 8.2708 7.6068 6.7632C7.99793 6.37286 8.57325 5.97357 8.69522 5.40285C8.85142 4.67185 8.44542 2.83299 7.81421 2.29123C7.59219 2.10067 7.30831 1.99718 7.0155 2.00006H5.2054C4.51572 2.00071 3.94192 2.6193 4.00471 3.31279C4 9.29 8.66669 14 14.6843 13.9953C15.3815 14.0582 16.0024 13.4815 15.9996 12.7909Z"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
                <span class="pl-2">
                  <b>
                    {{ $page.props.contacts.phone2 }}
                  </b>
                </span>
              </a>
              <a
                :href="$page.props.contacts.telegram"
                class="flex items-center mb-2"
              >
                <svg
                  width="20"
                  height="16"
                  viewBox="0 0 20 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M18 8C18 12.4183 14.4183 16 10 16C5.58172 16 2 12.4183 2 8C2 3.58172 5.58172 0 10 0C14.4183 0 18 3.58172 18 8ZM10.2867 5.90595C9.50856 6.2296 7.95342 6.89946 5.62126 7.91555C5.24255 8.06615 5.04417 8.21348 5.02611 8.35754C4.99559 8.601 5.30048 8.69687 5.71565 8.82742C5.77212 8.84517 5.83064 8.86357 5.89062 8.88307C6.29909 9.01585 6.84855 9.17118 7.13419 9.17735C7.3933 9.18295 7.68248 9.07613 8.00176 8.85689C10.1808 7.386 11.3056 6.64254 11.3762 6.62651C11.426 6.6152 11.4951 6.60099 11.5418 6.64256C11.5886 6.68414 11.584 6.76288 11.5791 6.784C11.5489 6.91276 10.3521 8.02538 9.73276 8.60118C9.53968 8.78068 9.40272 8.90801 9.37472 8.93709C9.312 9.00223 9.24808 9.06385 9.18665 9.12307C8.80718 9.48888 8.52261 9.76321 9.20241 10.2112C9.52909 10.4265 9.7905 10.6045 10.0513 10.7821C10.3361 10.976 10.6202 11.1695 10.9877 11.4104C11.0814 11.4718 11.1708 11.5356 11.2579 11.5977C11.5894 11.834 11.8872 12.0463 12.2551 12.0124C12.4688 11.9928 12.6896 11.7917 12.8018 11.1922C13.0668 9.77543 13.5878 6.70564 13.7081 5.44065C13.7187 5.32982 13.7054 5.18798 13.6948 5.12572C13.6841 5.06345 13.6618 4.97474 13.5809 4.90907C13.4851 4.83129 13.3371 4.81489 13.2709 4.81606C12.97 4.82136 12.5084 4.98188 10.2867 5.90595Z"
                    fill="#6170FF"
                  ></path>
                </svg>
                <span class="pl-2 underline"> GoRooms </span>
              </a>
              <a
                :href="'mailto:' + $page.props.contacts.notify"
                class="flex items-center mb-2"
              >
                <svg
                  width="20"
                  height="16"
                  viewBox="0 0 20 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M7.42847 8.00004C7.42847 9.42018 8.57973 10.5714 9.99989 10.5714C11.42 10.5714 12.5713 9.42018 12.5713 8.00004C12.5713 6.57986 11.42 5.42859 9.99989 5.42859C8.57973 5.42859 7.42847 6.57986 7.42847 8.00004Z"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M12.5714 8V8.85713C12.5714 9.80393 13.3389 10.5714 14.2857 10.5714C14.8939 10.5714 15.4281 10.2547 15.7324 9.7772C15.9019 9.5114 16 9.19573 16 8.85713V8C16 4.68629 13.3137 2 10 2C6.68629 2 4 4.68629 4 8C4 11.3137 6.68629 14 10 14C11.2748 14 12.4567 13.6025 13.4286 12.9245"
                    stroke="#6170FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
                <span class="pl-2 underline">
                  {{ $page.props.contacts.notify }}
                </span>
              </a>
              <a href="#" class="flex items-center mb-2">
                <svg
                  width="20"
                  height="16"
                  viewBox="0 0 20 16"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.4372 14.3568C13.3835 12.8545 15.6829 10.3665 15.6829 7.34147C15.6829 4.11531 13.0676 1.5 9.84146 1.5C6.61531 1.5 4 4.11531 4 7.34147C4 10.3665 6.29941 12.8545 9.24571 14.3568C9.62007 14.5477 10.0629 14.5477 10.4372 14.3568Z"
                    stroke="#6171FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                  <path
                    d="M12.032 7.34131C12.032 8.55115 11.0513 9.53186 9.84143 9.53186C8.63159 9.53186 7.65088 8.55115 7.65088 7.34131C7.65088 6.1315 8.63159 5.15076 9.84143 5.15076C11.0513 5.15076 12.032 6.1315 12.032 7.34131Z"
                    stroke="#6171FF"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
                <span class="pl-2">
                  {{ $page.props.contacts.address }}
                </span>
              </a>
            </div>
            <Button
              @click="toggleMapVisibility()"
              v-bind:classes="
                isMapVisible ? 'mb-4 w-full lg:w-3/12' : 'mt-3 w-full'
              "
            >
              {{ showMapBtnText }}
            </Button>
            <div v-if="isMapVisible">
              <div id="map" class="w-full py-3" style="height: 500px"></div>
            </div>
          </div>
        </div>
        <div
          class="w-full px-3 mb-4"
          v-bind:class="isMapVisible ? 'lg:w-1/2 ' : 'lg:w-3/12 md:w-1/2'"
        >
          <div class="w-full bg-white rounded-3xl p-4">
            <h3 class="font-semibold text-base mb-4">Реквизиты</h3>
            <div class="text-sm leading-4">
              <div class="mb-3">
                {{ $page.props.contacts.org_name }}
              </div>
              <div class="mb-3">
                ОГРН: {{ $page.props.contacts.ogrn }}<br />
                ИНН: {{ $page.props.contacts.inn }}<br />
                КПП: {{ $page.props.contacts.kpp }}
              </div>
              <div class="">
                Наименование банка:<br />
                {{ $page.props.contacts.bank_name }}<br />
                Р/c: {{ $page.props.contacts.bank_acc }}<br />
                К/c: {{ $page.props.contacts.bank_сorr_acc }}<br />
                БИК: {{ $page.props.contacts.bank_bik }}<br />
                ИНН: {{ $page.props.contacts.bank_inn }}<br />
                КПП: {{ $page.props.contacts.bank_kpp }}
              </div>
            </div>
          </div>
        </div>
        <div class="w-full lg:w-6/12 px-3 md:w-full">
          <FeedbackForm />
        </div>
      </div>
      <div v-html="page.footer"></div>
    </div>
  </div>
</template>

<script lang="ts">
import AppHead from "@/components/ui/AppHead.vue";
import Layout from "@/Layouts/Layout.vue";
import FeedbackForm from "./partials/FeedbackForm.vue";
import Button from "@/components/ui/Button.vue";
import { loadYandexMap } from "@/Services/loadYandexMap.js";

let myMap = null;
export default {
  components: {
    AppHead,
    Layout,
    FeedbackForm,
    Button,
  },
  created() {},
  props: {
    page: Object,
  },
  data: () => ({
    coords: [55.757572, 37.825793],
    isMapVisible: false,
    showMapBtnText: "Посмотреть на карте",
  }),
  mounted() {
    this.loadMapLazy();
  },
  methods: {
    loadMapLazy() {
      let mapInitDelay = 3000;
      if (typeof window !== "undefined") {
        if (window.innerWidth < 768) mapInitDelay = 5100;
      }
      loadYandexMap(this.$page.props.yandex_api_key, mapInitDelay, () => {});
    },
    loadMapImmediate() {      
      loadYandexMap(this.$page.props.yandex_api_key, 10, this.initMap);
    },
    formatPhoneLink(phone) {
      return phone.replace(/[^0-9+]/g, "");
    },
    toggleMapVisibility() {
      this.isMapVisible = !this.isMapVisible;
      if (this.isMapVisible) {
        this.showMapBtnText = "Скрыть карту";
        this.loadMapImmediate();
      } else {
        this.showMapBtnText = "Посмотреть на карте";
      }
    },
    initMap() {
      myMap = new ymaps.Map("map", {
        center: this.coords,
        zoom: 15,        
      });

      let orgGeoObject = new ymaps.Placemark(
        this.coords,
        {
          balloonContent: 'Россия, Москва, Напольный проезд, 10',
          iconCaption: 'GoRooms'
        },
        {
          preset: "islands#icon",
        }
      );
      
      myMap.geoObjects.add(orgGeoObject);
    },
  },
};
</script>
