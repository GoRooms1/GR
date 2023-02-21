import { reactive, watch } from 'vue'
import axios from 'axios'

export const filterStore = reactive({
  //State
  notRemovableFilters: [
    'city',
  ],
  locationParams: {},
  params: {},   
  filters: [],
  timestamp: Date.now(),
  found: 0,
  stopWatching: false,  

  //Getters and Actions
  init(isClear) {
    if (isClear)
    {
        this.clearFilters();        
    }
    //add default city filter
    this.addFilter('hotels', false, 'city', 'Москва', 'Москва');
    this.timestamp = Date.now();                          
    this.updateResultsCount();        
    this.updateLocationParams(); 
    this.watchFiltersChange();

    console.log(this.filters);
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
    axios.post(route('api.filter.location'),{
            city: this.getFilterValue('hotels', false, 'city') ?? null,            
        } 
    )
    .then(resp => {
        this.locationParams = resp.data ?? this.locationParams;
    })
    .catch(function (error) {
        console.log(error.toJSON());                
    });
  },

  updateResultsCount() {
    let data = this.getFiltersValues();
    let requestTimestamp = Date.now();
    axios.post(route('api.filter.count'), data)
    .then(resp => {        
        if (this.timestamp <= requestTimestamp)
            this.found = resp.data.found ?? 0;        
    })
    .catch(function (error) {
        console.log(rror.toJSON());                
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