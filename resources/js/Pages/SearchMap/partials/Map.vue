<template>
  <div id="search-map"></div> 
</template>

<script>
import _ from 'lodash'
let searchMap = null;
let geoObjects = null;
export default {
  props: {
    rooms: [Object],
    hotels: [Object], 
  },
  mounted() {
    ymaps.ready(this.initMap);
    eventBus.on('data-received', e => this.drawObjects());
  },
  data() {
    return {
      zoom: 12,
    }    
  },
  methods: {
    initMap() {
      searchMap = new ymaps.Map("search-map", {
        center: [this.hotels[0]?.address?.geo_lat ?? 55.757572, this.hotels[0]?.address?.geo_lon ?? 37.825793],        
        zoom: this.zoom,
        controls: ["zoomControl"],
      });

      geoObjects = new ymaps.GeoObjectCollection({}, {
        preset: "islands#icon",
        draggable: false,
      });

      this.drawObjects();
    },
    drawObjects() {
      if (searchMap && geoObjects) {
        geoObjects.removeAll();

        //add Hotels
        this.hotels.forEach(hotel => {
          let placemark = new ymaps.Placemark([hotel.address.geo_lat, hotel.address.geo_lon], {
              balloonContent: hotel.name,            
            }
          );
          geoObjects.add(placemark);
        });

        //TODO add Rooms
        
        if (geoObjects.getLength() > 0) {          
          searchMap.geoObjects.add(geoObjects);      
          searchMap.setBounds(geoObjects.getBounds(), {checkZoomRange:true})
          .then(() => { 
            if(searchMap.getZoom() > this.zoom) searchMap.setZoom(this.zoom);
          });
        }          
      }      
    },    
    redrawMap() {
      _.debounce(() => {
        console.log("redraw");
        searchMap?.container?.fitToViewport();
      }, 200)();
    },
  },

};
</script>
