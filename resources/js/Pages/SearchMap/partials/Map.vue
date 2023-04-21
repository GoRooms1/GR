<template>  
  <div @mousedown="hideSearch" @touchstart="hideSearch" id="search-map"></div> 
  
  <div class="hidden">    
    <div ref="hotel_rooms"> 
      <div class="rooms-list relative mx-auto px-4" :class="selectedRooms.length > 1 ? 'overflow-y-auto scrollbar' : ''">
        <div v-for="room in selectedRooms" class="room py-2">
            <room-card :room="room" />
          </div>				
		  </div>
    </div>   
  </div>  
</template>

<script>
import Swiper, { Navigation, Pagination, Scrollbar } from 'swiper'
import _ from 'lodash'
import { usePage } from "@inertiajs/inertia-vue3"
import { filterStore } from "@/Store/filterStore.js"
import RoomCard from "./RoomCard.vue"

let searchMap = null;
let geoObjectsClusterer = null;
let geoObjects = [];
let iconTemplate = null;
let MyBalloonLayout = null;
let MyBalloonContentLayout = null;
let roomsListHeight = 0;

export default {
  components: {    
    RoomCard,
  },
  props: {
    rooms: [Object],
    hotels: [Object],
  },
  mounted() {
    document.body.classList.add("fixed"); 
    ymaps.ready(this.initMap);
    eventBus.on('data-received', e => this.drawObjects());
  },
  unmounted() {
    document.body.classList.remove("fixed");
  },
  data() {
    return {
      filterStore,
      zoom: 12,
      hotelMarkers: [],      
      selectedRooms: [],
    }    
  },
  methods: {
    initMap() {
      searchMap = new ymaps.Map("search-map", {
        center: [55.757572, 37.825793],        
        zoom: this.zoom,
        controls: [],
      });

      //Init PlaceMark template
      iconTemplate = ymaps.templateLayoutFactory.createClass(
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
      
      //Init Clasterer
      geoObjectsClusterer = new ymaps.Clusterer({
        preset: 'islands#blackClusterIcons',
        gridSize: 128,
        minClusterSize: 2                   
      }),
      
      //Init Balloon template
      MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
        '<div class="popover top block z-10" style="max-width: 450px; min-width: 450px;">' +
        '<button class="close bg-white rounded-[8px] absolute p-[6px]" style="top: -40px; right: 0;"><img src="/img/close.svg"></button>' +
        '<div class="arrow absolute"></div>' +
        '<div class="popover-inner">' +
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
            MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);

            if(!this._isElement(this._$element)) {
                return;
            }

            this.applyElementOffset();
            this.events.fire('shapechange');
        },

        applyElementOffset: function () {          
          let breakpoint = 1024;
          let width = window.innerWidth > breakpoint ? breakpoint : window.innerWidth;
          let height = roomsListHeight;

          if (window.innerWidth >= breakpoint) {
            this._$element.style.left = -(this._$element.clientWidth / 2) + 'px';
            this._$element.style.top = -(this._$element.clientWidth / 2) + 'px';            
            this._$element.style.maxWidth = width + 'px';
            this._$element.style.minWidth = width + 'px';
            this._$element.style.position = "absolute";
            this._$element.style.padding = "0 0 0 0";
          }            
          else {
            width = window.innerWidth;
            this._$element.style.left = "0";
            this._$element.style.top = (window.innerHeight / 2 - height / 2 + 40) + 'px';            
            this._$element.style.maxWidth = width + 'px';
            this._$element.style.minWidth = width + 'px';
            this._$element.style.position = "fixed";
            this._$element.style.padding = "0 12px 0 12px";
          }
        },

        onCloseClick: function (e) {
            e.preventDefault();
            this.events.fire('userclose');
        },

        getShape: function () {
            if(!this._isElement(this._$element)) {
                return MyBalloonLayout.superclass.getShape.call(this);
            }

            var position = {
              top: this._$element.offsetTop,
              left: this._$element.offsetLeft
            };
           
            let height = roomsListHeight;
            let breakpoint = 1024;
            
            let offset = [[position.left, position.top - 60], [ position.left + this._$element.clientWidth, position.top + height + 80]];            
            if (window.innerWidth < breakpoint) {                      
              offset = [[0, 0], [0,0]];
            }

            return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle(offset));
        },

        _isElement: function (element) {
            return element && element.querySelector('.arrow');
        }
      }),
      
      //Init balloon content template
      MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(            
        '<div class="popover-content">$[properties.balloonContent]</div>'
      ),

      this.drawObjects();
    },
    drawObjects() {
      if (!searchMap) return;
       
      geoObjectsClusterer.removeAll();
      geoObjects = [];

      this.hotelMarkers = this.hotels;
      
      //Add Hotels marks
      this.hotelMarkers.forEach(hotel => {
        if (!hotel?.address?.geo_lat || !hotel?.address?.geo_lon) return;
        
        let minCost = hotel.min_cost_value;
        let blockWidth = _.round(86 + (7.4 * (minCost + '').length ));        

        let placemark = new ymaps.Placemark(
          [hotel.address.geo_lat, hotel.address.geo_lon], 
          {            
            minCost: minCost,                     
          },
          {
            balloonShadow: false,
            balloonLayout: MyBalloonLayout,
            balloonContentLayout: MyBalloonContentLayout,
            balloonPanelMaxMapArea: 0,
            iconLayout: iconTemplate,
            iconShape: {
              type: 'Rectangle',                
              coordinates: [
                  [-blockWidth, -36], [0, 0]
              ]
            }
          }
        );          
        
        placemark.events.add(['click'],  e => {
          let data = this.filterStore.getFiltersValues();
          data.hotel_id = hotel.id;
          this.$inertia.get(route("search.map"), data, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
            only: ['rooms'],
            onStart: () => {
              usePage().props.value.isLoadind = true;            
            },
            onFinish: () => {
              usePage().props.value.isLoadind = false;
            },
            onSuccess: () => {
              this.selectedRooms = this.rooms;             
              this.$nextTick(() => {                            
                e.get('target').properties.set('balloonContent', this.$refs.hotel_rooms.innerHTML);                
                
                //Rooms List
                let roomsCount = this.selectedRooms.length;                
                if (roomsCount > 0) {
                  let roomsListEl = document.querySelector('.popover').querySelector('.rooms-list');
                  let roomEl = document.querySelector('.popover').querySelector('.room');
                  let slidesPerView = window.innerHeight - 220 > roomEl.clientHeight * 2 ? (roomsCount > 1 ? 2 : 1) : 1;
                  roomsListHeight = roomEl.clientHeight * slidesPerView;
                  roomsListEl.style.height = roomsListHeight + 'px';

                  //Room swiper
                  let roomSwiperEls = document.querySelector('.popover').querySelectorAll('.swiper-image2');
                  roomSwiperEls.forEach(el => {
                    new Swiper(el, {
                      slidesPerView: 1,
                      slidesPerGroup: 1,
                      modules: [Navigation, Pagination],
                      pagination: {
                        el: el.querySelector('.swiper-pagination'),
                        renderBullet: function (index, className) {
                          return (
                            '<span class="' +
                            className +
                            ' swiper-pagination-bullet !opacity-100 w-[32px] rounded-[1px] h-[2px] mx-[2px] border-none p-0 ">' +
                            "</span>"
                          );
                        },
                        clickable: true,
                      },
                      navigation: {
                        nextEl: el.querySelector('.swiper-image-next'),
                        prevEl: el.querySelector('.swiper-image-prev'),
                      },
                      breakpoints: {
                        1024: {
                          noSwipingClass: "swiper-slide"
                        }
                      }
                    });
                  });

                  //Booking
                  let bookingBtns = document.querySelector('.popover').querySelectorAll('.room-booking');
                  bookingBtns.forEach(btn => {
                    btn.addEventListener('click', this.openBooking);
                  })
                }
              });
            }
          });              
        });

        //init balloon content
        placemark.balloon.events.add(['close'],  e => {
          this.selectedRooms = [];
        });
        
        geoObjects.push(placemark);
      });           
      
      if (geoObjects.length > 0) {         
        geoObjectsClusterer.add(geoObjects);
        searchMap.geoObjects.add(geoObjectsClusterer);      
        searchMap.setBounds(geoObjectsClusterer.getBounds(), {checkZoomRange:true})
        .then(() => { 
          if(searchMap.getZoom() > this.zoom) searchMap.setZoom(this.zoom);
        });
      }  
    },
    closeBalloon() {
      searchMap.balloon.close();
    },
    hideSearch() {      
      usePage().props.value.modals.search = false;
    },    
    openBooking(event) {      
      let btn = event.currentTarget;
      let room_id = btn.dataset.roomId;
      let bookingRoom = _.find(this.selectedRooms, room => room.id == room_id);      
      eventBus.emit('booking-open', bookingRoom);
    },    
  },

};
</script>
