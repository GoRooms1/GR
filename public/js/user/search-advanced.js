// При изменении формы мальенькой то применяется большая


$(function () {
  let mini_search = $('input#search-mini')

  $(mini_search).keyup(function () {
    let val = $(this).val()

    $('form#js-advanced-search input#advanced-search').val(val)
  })

  $('form#js-advanced-search input#advanced-search').change(function () {
    let val = $(this).val()

    $('#search-mini').val(val)

  })

  // let tags = {
  //   city: null,
  //   area: null,
  //   district: null,
  //   metro: null,
  //   attributes: []
  // }

  let event = new Event('change');
  let form = document.getElementById('js-advanced-search')

  let span = $('#js-advanced-search .search-tags span')

  span.find('a').click(function (e) {
    e.preventDefault()
    let span = $(this).parent('span')[0]

    let type = span.dataset.typeTag
    let info = span.dataset.info

    switch (type) {
      case 'area':
        console.log('area')
        $('#advanced-search-location-city_area').val(null).trigger('change.select2')
        break
      case 'district':
        console.log('district')
        $('#advanced-search-location-district').val(null).trigger('change.select2')
        break
      case 'metro':
        console.log('metro')
        $('#advanced-search-location-metro').val(null).trigger('change.select2')
        break
      case 'attributes':
        console.log('attributes')
        let el = $('.advanced-search-details-item input[value="' + info +'"]')[0]
        if (el) {
          $(el).prop( "checked", false )
        }
        break
      case 'hot':
        console.log('hot')
        $('#advanced-search-filter-fire').prop('checked', false)
    }

    form.dispatchEvent(event);
    span.remove()
  })

  // tags['city'] = $('#js-advanced-search .search-tags span[data-type-tag="city"]')[0].dataset.info
  //
  // let area = $('#js-advanced-search .search-tags span[data-type-tag="area"]')[0]
  // if (area) {
  //   tags['area'] = area.dataset.info
  // }
  //
  // let district = $('#js-advanced-search .search-tags span[data-type-tag="district"]')[0]
  // if (district) {
  //   tags['district'] = district.dataset.info
  // }
  //
  // let metro = $('#js-advanced-search .search-tags span[data-type-tag="metro"]')[0]
  // if (metro) {
  //   tags['metro'] = metro.dataset.info
  // }
  //
  // let attrs = $('#js-advanced-search .search-tags span[data-type-tag="attributes"]')
  // if (attrs.length > 0) {
  //   tags['attributes'] = attrs.map((i, el) => {
  //     return Number(el.dataset.info)
  //   })
  // }
  //
  // console.log(tags)

  // $('form#search-form').submit(function (e) {
  //   e.preventDefault();
  //
  //   $('form#js-advanced-search').submit();
  // })
})