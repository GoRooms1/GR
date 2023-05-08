import { reactive } from "vue";
import { useStorage } from "@vueuse/core";

export const geolocationStore = reactive({
  //State
  defaultCity: "Москва",
  defaultCoordinates: [55.75399400, 37.62209300],
  //city: null,
  city: useStorage('city', null),  
  coordiantes: useStorage('coordinates', [55.75399400, 37.62209300]),

  //Getters and Actions
  async locate() {
    if (this.city == null) {
      try {
        let ymapsReady = ymaps
          .ready()
          .then((value) => {           
            return ymaps.geolocation.get({
              provider: "auto",
              autoReverseGeocode: true,
            });
          })
          .then((result) => {
            //Get address
            let address = result.geoObjects.get(0).properties
              .get("metaDataProperty")?.GeocoderMetaData?.Address?.Components;
            
            let city = address?.find(
              (el) => el.kind == "locality"
            )?.name;
            
            //Get Cordinates
            let coords = result.geoObjects.get(0).geometry.getCoordinates();
            
            if (coords)
              this.coordiantes = [coords[0], coords[1]];
            else
              this.coordiantes = this.defaultCoordinates;                     
            
            console.log('geolocation', city, this.coordiantes.toString());

            return city;
          });

        let result = await ymapsReady;
        this.city = result;
        return result;
      } catch (error) {
        console.log("Ymaps error");
        this.city = this.defaultCity;
        this.coordiantes = this.defaultCoordinates;        
        return this.defaultCity;
      }
    }    

    return this.city;
  },
});
