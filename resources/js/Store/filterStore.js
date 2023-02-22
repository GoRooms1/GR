import { reactive, watch } from 'vue'
import { useStorage } from '@vueuse/core'
import qs from 'qs'
import axios from 'axios'
import { geolocationStore } from './geolocationStore.js' 

export const filterStore = reactive({
  //State
  notRemovableFilters: [
    'city',
  ],
  locationParams: {
    cities: [],
    metros: [],
  },
  params: {},   
  filters: useStorage('filters', []),
  timestamp: Date.now(),
  found: 0,
  stopWatching: false,  

  //Getters and Actions
  async init(isClear) {    
    if (isClear == true)
    {
      geolocationStore.city = null;  
      this.clearFilters();        
    }
    //add city filter
    let city = await geolocationStore.locate();      
    this.updateFilter('hotels', false, 'city', city, city);

    this.timestamp = Date.now();                          
    this.updateResultsCount();        
    this.updateLocationParams(); 
    this.watchFiltersChange();
  },

  clearFilters() {
    this.filters = this.filters.filter(el => el.key == 'city');    
  },
  
  getFilterId(modelType, isAttribute, filterKey, filterValue) {
    return modelType + (isAttribute ? '.attr_' + filterValue : '.' + filterKey);
  },

  getFilterValue(modelType, isAttribute, filterKey, filterValue) {     
    let id = this.getFilterId(modelType, isAttribute, filterKey, filterValue);
    return this.filters.find(el => el.id == id)?.value ?? null;
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
        if (filterKey == 'city')
            this.filters.unshift(filterObj);
        else
            this.filters.push(filterObj);
    }          
  },

  removeFilter(modelType, isAttribute, filterKey, filterValue) {
    let id = this.getFilterId(modelType, isAttribute, filterKey, filterValue);
    if (this.filters.find(el => el.id == id)) {
        this.filters = this.filters.filter(el => el.id != id);       
    }       
  },

  updateFilter(modelType, isAttribute, filterKey, filterValue, filterTitle) {
    this.stopWatching = true;
    this.removeFilter(modelType, isAttribute, filterKey, filterValue);
    this.stopWatching = false;
    this.addFilter(modelType, isAttribute, filterKey, filterValue, filterTitle);
  },

  getFiltersValues() {
    let data = {
        hotels: {
            attributes: []
        },
        rooms: {
            attributes: []
        },
        isRoomsFilter: false,
    };

    this.filters.forEach(el => {
        if (el.isAttribute)
            data[el.modelType].attributes.push(el.value);
        else
            data[el.modelType][el.key] = el.value;
        
        if (el.modelType == 'rooms')
            data.isRoomsFilter = true;
    }, data);
    
    return data;
  },

  updateLocationParams() {
    this.getCities();
    this.getMetros();
  },

  getCities() {
    axios.get(route('api.filter.cities'), {      
      headers: {
        'Content-Type' : 'application/json;charset=utf-8',
      }
    })
    .then(resp => {
      console.log(resp.data);
      this.locationParams.cities = resp.data?.data ?? this.locationParams.cities;
    })
    .catch(function (error) {
      console.log(error.toJSON());                
    });
  },

  getMetros() {
    axios.get(route('api.filter.metros'),{
        params: {
          city: this.getFilterValue('hotels', false, 'city') ?? null
        },            
      } 
    )
    .then(resp => {
      console.log(resp.data);
      this.locationParams.metros = resp.data?.data ?? this.locationParams.metros;
    })
    .catch(function (error) {
      console.log(error.toJSON());                
    });
  },

  updateResultsCount() {
    let data = this.getFiltersValues();
    let requestTimestamp = Date.now();    
    axios.get(route('api.filter.count'), {
       params: data,
       paramsSerializer: params => {
        return qs.stringify(params)
      }
    })
    .then(resp => {
      if (this.timestamp <= requestTimestamp)
          this.found = resp.data.found ?? 0;        
    })
    .catch(function (error) {
        console.log(error.toJSON());                
    });
  },

  watchFiltersChange() {    
    watch( () => this.filters, (newData, oldData) => {       
        if (!this.stopWatching) {
            this.timestamp = Date.now();                          
            this.updateResultsCount(); 
        }               
     }, 
     {
        deep: true
     });     
  },
  

})