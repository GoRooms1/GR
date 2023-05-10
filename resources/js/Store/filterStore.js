import { reactive } from "vue";
import _ from "lodash";
import qs from "qs";

export const filterStore = reactive({
  //State
  filters: [],

  //Getters and Actions
  async init(url, location) {
    console.log("init filters");
    this.filters = [];
    if (url.substring(url.indexOf("?") + 1).length > 2) {
      this.parceUrlParameters(url);
    }

    if (this.getFilterValue("hotels", "city") == null) {
      let city = location?.city ?? 'Москва';
      this.updateFilter("hotels", false, "city", city);
    }

    return true;
  },

  clearFilters() {
    this.filters = this.filters.filter((el) => el.key == "city");
  },

  findFilter(modelType, filterKey) {
    return _.find(this.filters, {
      modelType: modelType,
      key: filterKey,
    });
  },
  getFilterValue(modelType, filterKey) {
    return this.findFilter(modelType, filterKey)?.value ?? null;
  },

  addFilter(modelType, isAttribute, filterKey, filterValue) {
    let filterObj = {
      modelType: modelType,
      isAttribute: isAttribute,
      key: filterKey,
      value: filterValue,
    };

    if (!this.findFilter(modelType, filterKey)) {
      if (filterKey == "city") {
        this.filters.unshift(filterObj);
      } else {
        this.filters.push(filterObj);
      }
    }
  },

  removeFilter(modelType, filterKey) {
    if (this.findFilter(modelType, filterKey)) {
      this.filters = _.reject(this.filters, {
        modelType: modelType,
        key: filterKey,
      });
    }
  },

  updateFilter(modelType, isAttribute, filterKey, filterValue = null) {
    this.removeFilter(modelType, filterKey);
    if (filterValue)
      this.addFilter(modelType, isAttribute, filterKey, filterValue);
  },

  getFiltersValues() {
    let data = {
      hotels: {
        attributes: [],
      },
      rooms: {
        attributes: [],
      },
      isRoomsFilter: false,
    };

    this.filters.forEach((el) => {
      if (el.isAttribute) data[el.modelType].attributes.push(el.value);
      else data[el.modelType][el.key] = el.value;

      if (el.modelType == "rooms") data.isRoomsFilter = true;
    }, data);

    return data;
  },

  parceUrlParameters(url) {
    url = url.substring(url.indexOf("?") + 1);
    let paramsObj = qs.parse(url);

    let models = ["hotels", "rooms"];

    models.forEach((el) => {
      let model = paramsObj[el] ?? {};
      //Model filters
      for (const [key, value] of Object.entries(model)) {
        if (`${key}` != "attributes") {
          this.addFilter(el, false, `${key}`, `${value}`);
        }
      }

      //Model attribute filters
      let modelAttributes = model?.attributes ?? [];
      if (!Array.isArray(modelAttributes)) {
        modelAttributes = new Array(modelAttributes);
      }
      modelAttributes.forEach((element) => {
        this.addFilter(el, true, "attr_" + element, element);
      });
    });
    //console.log(decodeURI(url), this.filters);
  },
});
