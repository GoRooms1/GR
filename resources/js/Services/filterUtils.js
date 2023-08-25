//filterUtils.js
/* All this functions needs to call it with this context of Vue component
* Example
* _getFiltersData.call(this, true)
*/

import { numWord } from "@/Services/numWord.js";

function _updateFilterValue(model, isAttr = false, key, value) {
  if (!isAttr) {
    this.$page.props.filters[model][key] = value;
  } else {
    if (value == null)
      this.$page.props.filters[model].attrs = this.$page.props.filters[model].attrs.filter(e => ('attr_' + e) != key);
    else
      this.$page.props.filters[model].attrs.indexOf(value) && this.$page.props.filters[model].attrs.push(value);
  }
};

function _getFiltersData(isFilter = false) {
  let data = {
    hotels: {},
    rooms: {},
  };  
  copyNotEmptyPropsFromObject(this.$page.props.filters.hotels, data.hotels);
  copyNotEmptyPropsFromObject(this.$page.props.filters.rooms, data.rooms);
  data.filter = isFilter;
  return data;
};

function _getData(url, data, onFinish, onSuccess) {
  let props = ["hotels", "rooms", "page_description", "map_center", "filters", "filter_tags", "list_type", "is_map", "default_description", "path", "city_tag_list", "ad_params"];

  this.$nextTick(() => {
    this.$inertia.get(url, data, {
      replace: true,
      preserveState: true,
      preserveScroll: true,
      only: props,
      onStart: () => {
        this.$page.props.is_loading = true;
      },
      onFinish: () => {
        this.$page.props.is_loading = false;
        if (onFinish) onFinish();
      },
      onSuccess: () => {
        if (onSuccess) onSuccess();
      },
    });
  });
};

function copyNotEmptyPropsFromObject(srcObfect, dstObject) {
  for (var key in srcObfect) {
    if (srcObfect.hasOwnProperty(key)) {
      var value = srcObfect[key];
      if (value !== null && value !== undefined && value !== '') {
        dstObject[key] = value;
      }
    }
  }
}

function getFoundMessage(total = 0, type = 'hotels') {
  if (total === 0)
    return "По вашему запросу ничего не нашлось";

  let objectWords = ["отель", "отеля", "отелей"];
  if (type === 'rooms') 
    objectWords = ["номер", "номера", "номеров"];
  else if (type === 'appartments') 
    objectWords = ["апартаменты", "апартаментов", "апартаментов"];

  return numWord(total, ["Найден", "Найдено", "Найдено"]) + " " + total + " " + numWord(total, objectWords);
}

export { _updateFilterValue, _getFiltersData, _getData, getFoundMessage }