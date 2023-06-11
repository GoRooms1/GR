//filterUtils.js
/* All this functions needs to call it with this context of Vue component
* Example
* _getFiltersData.call(this, true)
*/

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
  this.$nextTick(() => {
    this.$inertia.get(url, data, {
      replace: true,
      preserveState: true,
      preserveScroll: true,
      only: ["hotels", "rooms", "page_description", "map_center", "filters", "filter_tags", "objects_type"],
      onStart: () => {
        this.$page.props.isLoadind = true;
      },
      onFinish: () => {
        this.$page.props.isLoadind = false;
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

export { _updateFilterValue, _getFiltersData, _getData }