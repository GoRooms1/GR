// In your Javascript (external .js resource or <script> tag)
$(function () {
  // Поиск городов, изначально есть город
  let city = $('#advanced-search-location-city')
  if (city) {
    city.select2({
      placeholder: 'Город',
      allowClear: false,
      width: '100%',
      language: "ru",
      dropdownPosition: 'below',
      ajax: {
        url: '/api/filter/cities',
        delay: 250,
        data: function (params) {
          return {
            search: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data.payload.cities, function (item) {
              return {
                text: item,
                id: item,
              }
            })
          };
        }
      }
    })
  }

  // Поиск по Округам в выбранном городе
  let city_area = $('#advanced-search-location-city_area')
  if (city_area) {
    city_area.select2({
      placeholder: 'Округ',
      allowClear: true,
      width: '100%',
      language: "ru",
      dropdownPosition: 'below',
      ajax: {
        url: '/api/filter/city-area',
        delay: 250,
        data: function (params) {
          return {
            search: params.term,
            city: city.val()
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data.payload.city_areas, function (item) {
              return {
                text: item,
                id: item,
              }
            })
          };
        }
      }
    })
  }

  // Поиск районов по выбранному городу и округу города
  let district = $('#advanced-search-location-district')
  if (district) {
    district.select2({
      placeholder: 'Район',
      allowClear: true,
      width: '100%',
      language: "ru",
      dropdownPosition: 'below',
      ajax: {
        url: '/api/filter/district',
        delay: 250,
        data: function (params) {
          return {
            search: params.term,
            city: city.val(),
            city_area: city_area.val()
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data.payload.districts, function (item) {
              return {
                text: item,
                id: item,
              }
            })
          };
        }
      }
    })
  }

  let metro = $('#advanced-search-location-metro')
  if (metro) {
    metro.select2({
      placeholder: 'Метро',
      allowClear: true,
      width: '100%',
      language: "ru",
      dropdownPosition: 'below',
      ajax: {
        url: '/api/filter/metro',
        delay: 250,
        data: function (params) {
          return {
            search: params.term,
            city: city.val(),
            city_area: city_area.val(),
            district: district.val()
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data.payload.metros, function (item) {
              return {
                text: item,
                id: item,
              }
            })
          };
        }
      }
    })
  }

  let event = new Event('change');
  let form = document.getElementById('js-advanced-search')

  // Обновляет (показать или спрятать) Округ если в короде нет округов
  getCountCityArea(city_area, $(city).val())

  // Если город изменился то обновить кол-во округов и отчистить все поля
  $(city).on('select2:select', function (e) {
    let data = e.params.data;
    $(city_area).val(null).trigger('change.select2')
    getCountCityArea(city_area, data.text)
    console.log('city: ', data.text);
    district.val(null)
    metro.val(null)
    $(metro).trigger('change.select2');
    $(district).trigger('change.select2');
    form.dispatchEvent(event);
  });
  $(city_area).on('select2:select', function (e) {
    district.val(null)
    metro.val(null)
    $(metro).trigger('change.select2');
    $(district).trigger('change.select2');
    form.dispatchEvent(event);
  });
  $(district).on('select2:select', function (e) {
    metro.val(null)
    $(metro).trigger('change.select2');
    form.dispatchEvent(event);
  });
  $(metro).on('select2:select', function (e) {
    form.dispatchEvent(event);
  })

  $(city).on('select2:clearing', function (e) {
    $(city).val(null).trigger('select2:select')
  })

  $(city_area).on('select2:clearing', function (e) {
    $(city_area).val(null).trigger('select2:select')
  })

  $(district).on('select2:clearing', function (e) {
    $(district).val(null).trigger('select2:select')
  })
  $(metro).on('select2:clearing', function (e) {
    $(metro).val(null).trigger('select2:select')
  })
});

// Скрывает поле Округ если нет округов в городе
function hiddenCityArea (city_area) {
  $(city_area).parents('.form-group').hide()
  $(city_area).prop('disabled', true);
  $(city_area).val(null)
  $(city_area).trigger('change.select2');
  // $(district).select2('disable');
}

// Показывает Округ если в городе есть округа
function showCityArea (city_area) {
  $(city_area).parents('.form-group').show()
  $(city_area).prop('disabled', false);
  // $(district).select2('enable');
}

// Взять новые кол-во округ в выбранном городе
function getCountCityArea (city_area, city) {
  axios.get('/api/filter/count-city-area', {
    params: {
      city: city
    }
  })
    .then(r => {
      if (r.data.success) {
        if (r.data.payload.count > 0) {
          showCityArea(city_area);
        } else {
          hiddenCityArea(city_area);
        }
      } else {
        hiddenCityArea(city_area);
      }
    })
    .catch(e => {
      console.warn(e)
      hiddenCityArea(city_area);
    })
}

function filter_select_clear () {
  // Поиск по Округам в выбранном городе
  let city_area = $('#advanced-search-location-city_area')
  // Поиск районов по выбранному городу и округу города
  let district = $('#advanced-search-location-district')
  let metro = $('#advanced-search-location-metro')

  $(metro).val(null).trigger('change').trigger('select2:select')
  $(district).val(null).trigger('change').trigger('select2:select')
  $(city_area).val(null).trigger('change').trigger('select2:select')


}