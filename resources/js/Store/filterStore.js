import { reactive } from 'vue'
import { useStorage } from '@vueuse/core'
import qs from 'qs'
import { geolocationStore } from './geolocationStore.js'

export const filterStore = reactive({
  //State
  notRemovableFilters: [
    'city',
  ],  
  filters: [],
  titles: [], 

  //Getters and Actions
  async init(url, params) {    
    console.log('init filters');    
    if (url.substring(url.indexOf("?") + 1).length > 2) {
      this.parceUrlParameters(url);
    }
    else {
      this.filters = [];
    }        
    if (this.getFilter('hotels', false, 'city').value == null) {      
      let city = await geolocationStore.locate();      
      this.updateFilter('hotels', false, 'city', city, city);
    }    
  },

  addTitle(key, value) {    
    if (!this.titles.find(el => el.key == key)) {
      this.titles.push({
        key: key,
        value: value,
      });
    }
  },

  getTitle(key, value) {
    return this.titles.find(el => el.key == key)?.value ?? value;
  },
  
  getFilterId(modelType, isAttribute, filterKey, filterValue) {
    return modelType + (isAttribute ? '.attr_' + filterValue : '.' + filterKey);
  },

  getFilter(modelType, isAttribute, filterKey, filterValue) {     
    let id = this.getFilterId(modelType, isAttribute, filterKey, filterValue);
    return this.filters.find(el => el.id == id) ?? {};
  },  

  addFilter(modelType, isAttribute, filterKey, filterValue, filterTitle) { 
    let filterObj = {
        id: this.getFilterId(modelType, isAttribute, filterKey, filterValue),
        title: filterTitle ?? filterKey,
        modelType: modelType,
        isAttribute: isAttribute,
        key: filterKey,
        value: filterValue,
    };    
   
    if (!this.filters.find(el => el.id == filterObj.id)) {
        if (filterKey == 'city') {
          this.filters.unshift(filterObj);
        }            
        else {
          this.filters.push(filterObj);
        }
        return true;
    }    
    return false;
  },

  removeFilter(modelType, isAttribute, filterKey, filterValue) {
    let id = this.getFilterId(modelType, isAttribute, filterKey, filterValue);   
    if (this.filters.find(el => el.id == id)) {
        this.filters = this.filters.filter(el => el.id != id);
        return true;                           
    }
    return false;       
  },

  updateFilter(modelType, isAttribute, filterKey, filterValue, filterTitle) {    
    this.removeFilter(modelType, isAttribute, filterKey, filterValue);    
    return this.addFilter(modelType, isAttribute, filterKey, filterValue, filterTitle);
  },

  getFiltersValues(filters) {
    if (filters == null) {
      filters = this.filters;
    }

    let data = {
        hotels: {
            attributes: []
        },
        rooms: {
            attributes: []
        },
        isRoomsFilter: false,
    };

   filters.forEach(el => {
        if (el.isAttribute)
            data[el.modelType].attributes.push(el.value);
        else
            data[el.modelType][el.key] = el.value;
        
        if (el.modelType == 'rooms')
            data.isRoomsFilter = true;
    }, data);
    
    return data;
  }, 

  parceUrlParameters(url) {        
    url = url.substring(url.indexOf("?") + 1);
    let paramsObj = qs.parse(url);   

    //Hotel filters
    let hotels = paramsObj.hotels ?? {};
    for (const [key, value] of Object.entries(hotels)) {      
      if (`${key}` != 'attributes') {        
        this.addFilter('hotels', false, `${key}`, `${value}`, this.getTitle(`${key}`, `${value}`));
      }      
    }

    //Hotel attribute filters
    let hotelAttributes = hotels?.attributes ?? [];
    if (!Array.isArray(hotelAttributes)) {
      hotelAttributes = new Array(hotelAttributes);
    }    
    hotelAttributes.forEach(element => {      
      this.addFilter('hotels', true, null, element, this.getTitle(element, element));
    });

    //Room filters
    let rooms = paramsObj.rooms ?? {};
    for (const [key, value] of Object.entries(rooms)) {      
      if (`${key}` != 'attributes') {        
        this.addFilter('rooms', false, `${key}`, `${value}`, this.getTitle(`${key}`, `${value}`));
      }      
    }

    //Rooms attribute filters
    let roomAttributes = rooms?.attributes ?? [];
    if (!Array.isArray(roomAttributes)) {
      roomAttributes = new Array(roomAttributes);
    }
    roomAttributes.forEach(element => {      
      this.addFilter('rooms', true, null, element, this.getTitle(element, element));
    });    
  },

})