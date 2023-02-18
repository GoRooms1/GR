import { reactive } from 'vue'

export const geolocationStore = reactive({
  //State
  geolocation: [],
  city: 'Москва',

  //Getters and Actions
  locate() {    
    if (!this.city) {
      ymaps.ready(async () => {
        await ymaps.geolocation.get({          
          provider: 'auto',          
          autoReverseGeocode: true
        })
        .then(result => {
          let loc = result.geoObjects.get(0).properties;         
          this.geolocation = loc.get('metaDataProperty')?.GeocoderMetaData?.Address?.Components;
          this.city = this.geolocation?.find(el => el.kind == 'locality')?.name;
        });
      });
    }   
  }  

})