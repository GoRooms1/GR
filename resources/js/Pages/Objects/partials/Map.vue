<template>
  <div @mousedown="hideSearch(); loadMapImmediate()" @touchstart="hideSearch(); loadMapImmediate()" id="search-map"></div>

  <div v-if="isOpen == true" class="rooms-list fixed mx-auto h-[100%] lg:h-[100vh] top-0 left-0 z-50 w-full flex flex-col justify-center items-center"
    :class="blurBackground ? 'bg-[#D2DAF0B3] backdrop-blur-[2.5px] ' : ''"
  > 
    <div class="w-full flex flex-col" style="max-width: 1024px;">
      <button @click="closeModal()" class="w-[32px] h-[32px] p-2 bg-white rounded-lg ml-auto xl:mr-[-32px]" style="margin-bottom: 1rem; margin-right: 0.2rem;">
        <img src="/img/close.svg" alt="close">
      </button>
      <div v-click-outside="clickOutside" class="mx-[0.5rem] overflow-y-auto scrollbar pr-3 lg:mx-0 flex flex-col" :style="'max-height:' + listHeight + 'px;'">
        <div v-for="room in selectedRooms">
          <room-card :room="room" class="room room-map"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vClickOutside from "click-outside-vue3";
import { loadYandexMap } from "@/Services/loadYandexMap.js";
import RoomCard from "@/components/ui/RoomCard.vue";
import {_getFiltersData} from "@/Services/filterUtils.js";

let searchMap = null;
let geoObjectsClusterer = null;
let geoObjects = [];
let iconTemplate = null;
let iconTemplateHot = null;

export default {
  directives: {
    clickOutside: vClickOutside.directive,
  },
  components: {      
    RoomCard,
  },
  props: {
    rooms: [Object],
    hotels: [Object],
  },
  mounted() {
    this.loadMapLazy();
    this.$page.props.modals.booking = false;
    document.body.classList.add("fixed");
    document.documentElement.classList.add("max-[390px]:text-[12px]");        
    this.$eventBus.on("data-received", (e) => this.drawObjects());     
  },
  unmounted() {
    document.body.classList.remove("fixed");
    document.documentElement.classList.remove("max-[390px]:text-[12px]");
    this.$eventBus.off("data-received");   
  },
  data() {
    return {          
      zoom: 10,
      hotelMarkers: [],
      selectedRooms: [],
      isOpen: false,
      listHeight: 768,
      blurBackground: false,
    };
  },
  methods: {
    loadMapLazy() {      
      loadYandexMap(this.$page.props.yandex_api_key, 10, this.initMap)
    },
    loadMapImmediate() {
      if (typeof ymaps !== "undefined") return;
      loadYandexMap(this.$page.props.yandex_api_key, 10, this.initMap);
    },   
    initMap() {
      console.log('init map');
      let center = [];
      if (this.$page.props?.map_center?.geo_lat && this.$page.props?.map_center?.geo_lon) {
        center[0] = this.$page.props.map_center.geo_lat;
        center[1] = this.$page.props.map_center.geo_lon;
      }      
      else {
        center[0] = this.$page.props?.location?.geo_lat ?? 55.75399400;
        center[1] = this.$page.props?.location?.geo_lon ?? 37.62209300;
      }
      
      searchMap = new ymaps.Map("search-map", {
        center: center,
        zoom: this.zoom,
        controls: [],
      });

      //Init PlaceMark template
      iconTemplate = ymaps.templateLayoutFactory.createClass(
        '<div class="relative w-fit">' +
          '<button class="flex items-stretch overflow-hidden absolute right-[100%] bottom-[100%]">' +
          '<div class="py-[6px] px-[12px] bg-white text-[16px] font-bold rounded-l-[8px] whitespace-nowrap">' +
          " {{ properties.minCost }} ₽ " +
          '</div>' +
          '<div class="flex bg-gray-500 py-[8px] px-[12px] rounded-r-[8px]">' +
          '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">' +
          '<path fill-rule="evenodd" clip-rule="evenodd" d="M15 4.5C15 4.78 15.22 5 15.5 5C15.78 5 16 4.78 16 4.5V3H17.5C17.78 3 18 2.78 18 2.5C18 2.22 17.78 2 17.5 2H16V0.5C16 0.22 15.78 0 15.5 0C15.22 0 15 0.22 15 0.5V2H13.5C13.22 2 13 2.22 13 2.5C13 2.78 13.22 3 13.5 3H15V4.5ZM6.08 13.38L6.29 14H3.04C2.08 12.94 1.5 11.54 1.5 10C1.5 6.69003 4.19 4.03003 7.5 4.03003C10.81 4.03003 13.5 6.72003 13.5 10.03C13.5 11.57 12.91 12.97 11.96 14.03H7.34L7.03 13.09L8.45 12.62C8.72 12.53 8.86 12.25 8.77 11.99C8.68 11.72 8.4 11.58 8.14 11.67L6.72 12.14L6.4 11.19L8.77 10.4C9.41 10.19 9.92 9.75003 10.22 9.15003C10.52 8.55003 10.57 7.87003 10.36 7.24003C10.15 6.60003 9.71 6.09003 9.11 5.79003C8.51 5.49003 7.83 5.44003 7.2 5.65003L4.35 6.60003C4.08 6.69003 3.94 6.97003 4.03 7.23003L5.14 10.55L4.67 10.71C4.4 10.8 4.26 11.08 4.35 11.34C4.42 11.55 4.61 11.68 4.82 11.68C4.87 11.68 4.93 11.67 4.98 11.65L5.45 11.49L5.77 12.44L5.3 12.6C5.03 12.69 4.89 12.97 4.98 13.23C5.05 13.44 5.24 13.57 5.45 13.57C5.5 13.57 5.56 13.56 5.61 13.54L6.08 13.38ZM9.32 8.67003C9.5 8.31003 9.53 7.90003 9.4 7.52003C9.27 7.14003 9.01 6.83003 8.65 6.65003C8.29 6.47003 7.89 6.44003 7.51 6.57003L5.14 7.36003L6.09 10.21L8.46 9.42003C8.84 9.29003 9.15 9.03003 9.33 8.67003H9.32ZM15 17C15 17.55 14.55 18 14 18H1C0.45 18 0 17.55 0 17C0 16.45 0.45 16 1 16H14C14.55 16 15 16.45 15 17Z" fill="white"></path>' +
          '</svg>' +
          '</div>' +
          '</button>' +
          '</div>'
      );
      
      iconTemplateHot = ymaps.templateLayoutFactory.createClass(
        '<div class="relative w-fit">' +
          '<button class="flex items-stretch overflow-hidden absolute right-[100%] bottom-[100%]">' +
          '<div class="flex items-center py-[6px] px-[12px] bg-white text-[16px] font-bold rounded-l-[8px] text-red-700 whitespace-nowrap">' +
          '<div class="mr-1">' +
          '<svg width="11" height="15" viewBox="0 0 11 15" fill="none" xmlns="http://www.w3.org/2000/svg">' +
          '<path d="M7.9437 1.45801C8.05312 1.18431 7.85153 0.886597 7.55678 0.886597H2.63921C2.45986 0.886597 2.30064 1.00135 2.24393 1.1715L0.021701 7.83818C-0.0682323 8.10801 0.132584 8.3866 0.416984 8.3866H2.63857C2.90964 8.3866 3.10854 8.64135 3.04279 8.90435L1.8704 13.5938C1.76791 14.0038 2.27044 14.2883 2.56926 13.9896L9.96095 6.59793C10.2235 6.33543 10.0375 5.8866 9.66628 5.8866H6.78762C6.49287 5.8866 6.29128 5.58888 6.40078 5.31519L7.9437 1.45801Z" fill="#E1183D"></path>' +
          '</svg>' +
          '</div>' +
          " {{ properties.minCost }} ₽ " +
          '</div>' +
          '<div class="flex bg-gray-500 py-[8px] px-[12px] rounded-r-[8px]">' +
          '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">' +
          '<path fill-rule="evenodd" clip-rule="evenodd" d="M15 4.5C15 4.78 15.22 5 15.5 5C15.78 5 16 4.78 16 4.5V3H17.5C17.78 3 18 2.78 18 2.5C18 2.22 17.78 2 17.5 2H16V0.5C16 0.22 15.78 0 15.5 0C15.22 0 15 0.22 15 0.5V2H13.5C13.22 2 13 2.22 13 2.5C13 2.78 13.22 3 13.5 3H15V4.5ZM6.08 13.38L6.29 14H3.04C2.08 12.94 1.5 11.54 1.5 10C1.5 6.69003 4.19 4.03003 7.5 4.03003C10.81 4.03003 13.5 6.72003 13.5 10.03C13.5 11.57 12.91 12.97 11.96 14.03H7.34L7.03 13.09L8.45 12.62C8.72 12.53 8.86 12.25 8.77 11.99C8.68 11.72 8.4 11.58 8.14 11.67L6.72 12.14L6.4 11.19L8.77 10.4C9.41 10.19 9.92 9.75003 10.22 9.15003C10.52 8.55003 10.57 7.87003 10.36 7.24003C10.15 6.60003 9.71 6.09003 9.11 5.79003C8.51 5.49003 7.83 5.44003 7.2 5.65003L4.35 6.60003C4.08 6.69003 3.94 6.97003 4.03 7.23003L5.14 10.55L4.67 10.71C4.4 10.8 4.26 11.08 4.35 11.34C4.42 11.55 4.61 11.68 4.82 11.68C4.87 11.68 4.93 11.67 4.98 11.65L5.45 11.49L5.77 12.44L5.3 12.6C5.03 12.69 4.89 12.97 4.98 13.23C5.05 13.44 5.24 13.57 5.45 13.57C5.5 13.57 5.56 13.56 5.61 13.54L6.08 13.38ZM9.32 8.67003C9.5 8.31003 9.53 7.90003 9.4 7.52003C9.27 7.14003 9.01 6.83003 8.65 6.65003C8.29 6.47003 7.89 6.44003 7.51 6.57003L5.14 7.36003L6.09 10.21L8.46 9.42003C8.84 9.29003 9.15 9.03003 9.33 8.67003H9.32ZM15 17C15 17.55 14.55 18 14 18H1C0.45 18 0 17.55 0 17C0 16.45 0.45 16 1 16H14C14.55 16 15 16.45 15 17Z" fill="white"></path>' +
          '</svg>' +
          '</div>' +
          '</button>' +
          '</div>'
      ); 

      //Init Clasterer
      geoObjectsClusterer = new ymaps.Clusterer({
        preset: "islands#blackClusterIcons",
        gridSize: 128,
        minClusterSize: 2,
        useMapMargin: true,
        zoomMargin: [85, 50, 90, 50],
      });
      
      this.drawObjects();      
    },
    drawObjects() {
      if (!searchMap) return;

      geoObjectsClusterer.removeAll();
      geoObjects = [];

      this.hotelMarkers = this.hotels ?? [];

      //Add Hotels marks
      this.hotelMarkers.forEach((hotel) => {
        if (!hotel?.address?.geo_lat || !hotel?.address?.geo_lon) return;

        let minCost = hotel.min_cost_value;
        let minCostDiscount = hotel.min_cost_discount_value;
        let blockWidth =  Math.round(86 + 7.4 * (minCost + "").length) + (minCostDiscount > 0 ? 12 : 0);

        //Fix same coordinates markers
        let sameCoordsHotel = this.hotelMarkers.find(el => 
          el.address.geo_lat == hotel.address.geo_lat && el.address.geo_lon == hotel.address.geo_lon && el.id != hotel.id
        );

        if (sameCoordsHotel) {          
          hotel.address.geo_lon = parseFloat(hotel.address.geo_lon) + 0.0001;
          this.hotelMarkers[this.hotelMarkers.findIndex(el => el.id == hotel.id)].address.geo_lon = hotel.address.geo_lon;
        }
       
        let placemark = new ymaps.Placemark(
          [hotel.address.geo_lat, hotel.address.geo_lon],
          {            
            minCost: minCostDiscount > 0 ? minCostDiscount : minCost,
          },
          {            
            balloonShadow: false,           
            balloonPanelMaxMapArea: 0,
            iconLayout: minCostDiscount > 0 ? iconTemplateHot : iconTemplate,           
            iconShape: {
              type: "Rectangle",
              coordinates: [
                [-blockWidth, -36],
                [0, 0],
              ],
            },
          }
        );

        placemark.events.add(["click"], (e) => {
          let data = _getFiltersData.call(this);
          data.hotel_id = hotel.id;
          data.as = 'map';
          this.$inertia.get(this.$page.props.path, data, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
            only: ["rooms"],
            onStart: () => {
              this.$page.props.is_loading = true;
            },
            onFinish: () => {
              this.$page.props.is_loading = false;
            },
            onSuccess: () => {
              this.selectedRooms = this.rooms;
              this.openModal();

              this.$nextTick(() => {
                this.handleResize();
              });                         
            },
            onError: errors => {
              this.closeModal();
            },
          });
        });

        placemark.balloon.events.add(["close"], (e) => {
          this.$page.props.modals.booking = false;
          this.isOpen = false;
          this.selectedRooms = [];          
        });

        geoObjects.push(placemark);
      });

      if (geoObjects.length > 0) {
        geoObjectsClusterer.add(geoObjects);
        searchMap.geoObjects.add(geoObjectsClusterer);
      }

      if (this.$page.props?.map_center?.geo_lat && this.$page.props?.map_center?.geo_lon) {         
          searchMap.setCenter([this.$page.props?.map_center?.geo_lat, this.$page.props?.map_center?.geo_lon], 10);
      }      
      else {        
        if (geoObjects.length > 0) {
          searchMap
          .setBounds(geoObjectsClusterer.getBounds(), { checkZoomRange: true})
          .then(() => {
            if (searchMap.getZoom() > 13) searchMap.setZoom(10);
          });
        }             
      }
    },
    openModal() {
      this.isOpen = true;
    },
    closeModal() {      
      if (this.$page.props.modals.booking !== true && this.isOpen === true) {
        searchMap.balloon.close();        
        this.selectedRooms = [];
        this.isOpen = false;
      }      
    },
    clickOutside() {
      if (this.blurBackground === false) this.closeModal();
    },
    hideSearch() {
      this.$page.props.modals.search = false;
    }, 
    handleResize() {
      if (typeof window !== "undefined") {
        let windowHeight = window.innerHeight;
        let windowWidth = window.innerWidth;
        let roomEl = document
          .querySelector('.rooms-list')
          .querySelector('.room');
        
        if (roomEl) {
          let elHeight = roomEl.clientHeight;
          this.listHeight = windowWidth > 1024 ? (elHeight + 16) * 2 : elHeight;

          let headerHeigth = document.getElementsByTagName('header')[0]?.clientHeight ?? 0;
          let footerHeight = document.getElementsByTagName('footer')[0]?.clientHeight ?? 0;
          let usefullHeight = windowHeight - headerHeigth - footerHeight - 52;

          if (usefullHeight <= this.listHeight) this.listHeight = elHeight;        

          if (usefullHeight <= this.listHeight) 
            this.blurBackground = true;
          else
            this.blurBackground = false;
          
          if( (windowHeight - 52) <= this.listHeight) this.listHeight = windowHeight - 52;
        }                
      }
    },  
  },
};
</script>
