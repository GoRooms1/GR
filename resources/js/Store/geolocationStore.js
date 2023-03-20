import { reactive } from "vue";
import { useStorage } from "@vueuse/core";

export const geolocationStore = reactive({
  //State
  geolocation: [],
  //city: useStorage('city', null),
  city: "Москва",
  defaultCity: "Москва",

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
            let loc = result.geoObjects.get(0).properties;
            this.geolocation =
              loc.get(
                "metaDataProperty"
              )?.GeocoderMetaData?.Address?.Components;
            let city = this.geolocation?.find(
              (el) => el.kind == "locality"
            )?.name;
            return city;
          });

        let result = await ymapsReady;
        this.city = result;
        return result;
      } catch (error) {
        console.log("Ymaps error");
        this.city = this.defaultCity;
        return this.defaultCity;
      }
    }

    return this.city;
  },
});
