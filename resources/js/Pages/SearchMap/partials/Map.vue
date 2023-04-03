<template>
  <div @mousedown="hideSearch" @touchstart="hideSearch" :style="'width: 100%; height: ' + windowHeight + 'px;'">
    <YandexMap 
      :settings="settings" 
      :coordinates="coords" 
      :zoom="zoom"
      :bounds="bounds"
      :controls="[]"      
    >
      <YandexClusterer
        :options="{
          preset: 'islands#blackClusterIcons',
          gridSize: 128,
          minClusterSize: 2
        }"
        @geo-objects-updated="
        e => setBounds(e)
        //Если объектов мало (1-2), после установки границ (bounds), карта зумится очень близко
        "      
      >
        <YandexMarker v-for="hotel in hotels" 
          :coordinates="[hotel.address.geo_lat, hotel.address.geo_lon]" 
          :marker-id="hotel.id"
          :options="{
            balloonShadow: false,            
            balloonPanelMaxMapArea: 0,
            // balloonLayout: MyBalloonLayout(),            
            // iconLayout: iconTemplate(),
            // iconShape: {
            //       type: 'Rectangle',                
            //       coordinates: calculateOffset(hotel)
            //   }
          }" 
          :properties="{minCost: getMinCost(hotel), }"            
        >
          <template #component>            
            <hotel-card :hotel="hotel" />            
          </template>   
        </YandexMarker>
      </YandexClusterer>      
    </YandexMap>
  </div>
</template>

<style>
/* .popover {   
  max-width: 430px;  
} */
.popover .close {
  position: absolute;
  right: -8px;
  top: -16px;
  padding: 6px;
}
</style>

<script>
import _ from 'lodash'
import { YandexMap, YandexMarker, YandexClusterer } from 'vue-yandex-maps'
import { usePage } from "@inertiajs/inertia-vue3"
import HotelCard from "./HotelCard.vue"

export default {
  components: {
    HotelCard,
    YandexMap,
    YandexMarker,
    YandexClusterer,
  },
  props: {
    rooms: [Object],
    hotels: [Object], 
  },
  created() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
  },  
  mounted() {
    document.body.classList.add("fixed");    
  },
  unmounted() {
    document.body.classList.remove("fixed");
  },
  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },
  data() {
    return {
      windowHeight: 600,
      windowWidth: 600,
      zoom: 12,
      coords: [55.757572, 37.825793],
      bounds: [[55.757572, 37.825793], [55.757572, 37.825793]],         
      settings: {
        apiKey: '48a53e1e-0baf-46d3-a56a-6e77254c3f8b',
        lang: 'ru_RU',
        coordorder: 'latlong',
        debug: false,
        version: '2.1'
      },      
    }    
  },
  computed: {   
  },
  methods: {
    handleResize() {
      this.windowHeight = window.innerHeight;
      this.windowWidth = window.innerWidth;
    },
    getMinCost(hotel) {
      return _.min(_.filter(_.map(hotel.min_costs, 'value'), function(o) { return o > 0; } ));
    },
    calculateOffset(hotel) {
      let label = this.getMinCost(hotel) + '';
      let width = _.round(86 + (7.4 * label.length ));
      return [
        [-width, -36], [0, 0]
      ]
    },    
    setBounds(geoObjects) {
      if (geoObjects == null) 
        this.bounds = [this.coords, this.coords];
      else
        this.bounds = geoObjects.getBounds();
    },    
    iconTemplate() {
      //Как получить templateLayoutFactory из vue-yandex-maps и сделал свой темплэйт маркера ???
      return ymaps.templateLayoutFactory.createClass(
        '<div class="relative w-fit">'
        + '<button class="flex items-stretch overflow-hidden absolute right-[100%] bottom-[100%]">'
        + '<div class="py-[6px] px-[12px] bg-white text-[16px] font-bold rounded-l-[8px] whitespace-nowrap">'
        +  '{{ properties.minCost }} ₽'
        + '</div>'
        + '<div class="flex bg-gray-500 py-[8px] px-[12px] rounded-r-[8px]">'
        +  '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">'
        +    '<path fill-rule="evenodd" clip-rule="evenodd" d="M15 4.5C15 4.78 15.22 5 15.5 5C15.78 5 16 4.78 16 4.5V3H17.5C17.78 3 18 2.78 18 2.5C18 2.22 17.78 2 17.5 2H16V0.5C16 0.22 15.78 0 15.5 0C15.22 0 15 0.22 15 0.5V2H13.5C13.22 2 13 2.22 13 2.5C13 2.78 13.22 3 13.5 3H15V4.5ZM6.08 13.38L6.29 14H3.04C2.08 12.94 1.5 11.54 1.5 10C1.5 6.69003 4.19 4.03003 7.5 4.03003C10.81 4.03003 13.5 6.72003 13.5 10.03C13.5 11.57 12.91 12.97 11.96 14.03H7.34L7.03 13.09L8.45 12.62C8.72 12.53 8.86 12.25 8.77 11.99C8.68 11.72 8.4 11.58 8.14 11.67L6.72 12.14L6.4 11.19L8.77 10.4C9.41 10.19 9.92 9.75003 10.22 9.15003C10.52 8.55003 10.57 7.87003 10.36 7.24003C10.15 6.60003 9.71 6.09003 9.11 5.79003C8.51 5.49003 7.83 5.44003 7.2 5.65003L4.35 6.60003C4.08 6.69003 3.94 6.97003 4.03 7.23003L5.14 10.55L4.67 10.71C4.4 10.8 4.26 11.08 4.35 11.34C4.42 11.55 4.61 11.68 4.82 11.68C4.87 11.68 4.93 11.67 4.98 11.65L5.45 11.49L5.77 12.44L5.3 12.6C5.03 12.69 4.89 12.97 4.98 13.23C5.05 13.44 5.24 13.57 5.45 13.57C5.5 13.57 5.56 13.56 5.61 13.54L6.08 13.38ZM9.32 8.67003C9.5 8.31003 9.53 7.90003 9.4 7.52003C9.27 7.14003 9.01 6.83003 8.65 6.65003C8.29 6.47003 7.89 6.44003 7.51 6.57003L5.14 7.36003L6.09 10.21L8.46 9.42003C8.84 9.29003 9.15 9.03003 9.33 8.67003H9.32ZM15 17C15 17.55 14.55 18 14 18H1C0.45 18 0 17.55 0 17C0 16.45 0.45 16 1 16H14C14.55 16 15 16.45 15 17Z" fill="white"></path>'
        +  '</svg>'
        + '</div>'
        + '</button>'
        + '</div>'
      );
    },
    MyBalloonLayout() {
      //Как получить templateLayoutFactory из vue-yandex-maps и сделал свой темплэйт балуна ???
      return ymaps.templateLayoutFactory.createClass(
        '<div class="popover top fixed md:absolute block z-20 px-4 md:px-0" style="max-width: 430px;">' +
        '<button class="close bg-white rounded-[8px]"><img src="/img/close.svg"></button>' +
        '<div class="arrow absolute"></div>' +
        '<div class="popover-inner ">' +
        '$[[options.contentLayout]]' +        
        '</div>' +
        '</div>', {        
        build: function () {
            this.constructor.superclass.build.call(this);
            this._$element = this.getParentElement().querySelector('.popover');
            this.applyElementOffset();
            this._$element.querySelector('.close')
                .addEventListener('click', (e) => this.onCloseClick(e));
        },

        clear: function () {
          this._$element.querySelector('.close')
            .removeEventListener('click', (e) => this.onCloseClick(e));                        

          this.constructor.superclass.clear.call(this);
        },

        onSublayoutSizeChange: function () {
          this.constructor.superclass.onSublayoutSizeChange.apply(this, arguments);

          if(!this._isElement(this._$element)) {
              return;
          }

          this.applyElementOffset();

          this.events.fire('shapechange');
        },

        applyElementOffset: function () {
          //Тут хардкод, позиция примерная. Т.к. при открытии балуна в нем еще нет реактивного контента - вычислить ширину/высоту блока не получается              
          //На десктопе открывать в месте маркера  
          if (window.innerWidth >= 768) {
            this._$element.style.left = '-257px';
            this._$element.style.top = '-278px';            
            this._$element.style.maxWidth = '430px';
          }
          //На мобильных устройствах position fixed по центру экрана. Как отцентрировать по вертикале?
          else {
            let width = (window.innerWidth - 32);
            this._$element.style.left = "16px";
            this._$element.style.top = (window.innerHeight/4) + 'px';            
            this._$element.style.maxWidth =  width + 'px';
          }                                            
        },

        onCloseClick: function (e) {
            e.preventDefault();
            this.events.fire('userclose');
        },

        getShape: function () {
          if(!this._isElement(this._$element)) {
              return this.constructor.superclass.getShape.call(this);
          }

          let position = {
            top: this._$element.offsetTop,
            left: this._$element.offsetLeft
          };

          let offset = [[position.left, position.top - 50], [ position.left + 514, position.top + 650]];
          if (window.innerWidth < 768) {
            offset = [[position.left, position.top], [ position.left, position.top]];
          }

          return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle(offset));
        },

        _isElement: function (element) {
            return element && element.querySelector('.arrow');
        }
      });
    },
    hideSearch() {      
      usePage().props.value.modals.search = false;
    },
  },

};
</script>
