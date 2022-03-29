// При изменении формы мальенькой то применяется большая

let cost = {}

$(function () {

  let dataSearch = {
    attributes: [],
    city: null,
    area: null,
    district: null,
    metro: null,
    hot: false
  }

  let mini_search = $('input#search-mini')

  $(mini_search).keyup(function () {
    let val = $(this).val()

    $('form#js-advanced-search input#advanced-search').val(val)
  })

  // нахождение стандартных значений, что бы при закрытии фильтра их востанавливать
  $('form#js-advanced-search .advanced-search-details-item input[type="checkbox"]').each(function () {
    if ($(this).prop('checked')) {
      console.log($(this))
      dataSearch.attributes.push({
        id: $(this).val(),
        name: $(this).parent('li').find('label').text()
      })
    }
  })

  dataSearch.city = $('form#js-advanced-search #advanced-search-location-city').val()
  dataSearch.area = $('form#js-advanced-search #advanced-search-location-city_area').val()
  dataSearch.district = $('form#js-advanced-search #advanced-search-location-district').val()
  dataSearch.metro = $('form#js-advanced-search #advanced-search-location-metro').val()
  dataSearch.hot = $('#advanced-search-filter-fire').prop('checked')


  $('form#js-advanced-search input#advanced-search').change(function () {
    let val = $(this).val()

    $('#search-mini').val(val)

  })

  // Обновление тегов по выбранным данным
  let span = $('#js-advanced-search .search-tags span')
  span.find('a').click(removeTag)

  $('.advanced-search-details-item input[type="checkbox"]').change(function () {
    if($(this).prop('checked')) {
      let parent = $(this).parent('li')
      let label = $(parent).find('label')
      let name = $(label).text()
      let attrDiv = $('.copy-attr').clone()
      $(attrDiv).removeClass('copy-attr')
        .removeClass('d-none')
        .addClass('d-flex')
        .attr('data-type-tag', 'attributes')
        .attr('data-info', $(this).val())
        .prepend(name)

      $('#js-advanced-search .search-tags').append(attrDiv)
      span.unbind('click')
      span = $('#js-advanced-search .search-tags span')
      span.find('a').click(removeTag)
      attrDiv.css('display', 'flex');
    }
    else {
      let span = $('#js-advanced-search .search-tags span[data-type-tag="attributes"][data-info="' + $(this).val() + '"]')
      span.remove()
    }
  })

  $('#advanced-search-location-city').on('select2:select', function (e) {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="city"]')
    if (e.params) {
      spanEl.text('г.' + e.params.data.text)
      spanEl.attr('data-info', e.params.data.text)
      span.unbind('click')
      span = $('#js-advanced-search .search-tags span')
      span.find('a').click(removeTag)
    }
  })

  $('#advanced-search-location-city_area').on('select2:select', function (e) {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="area"]')
    if (e.params) {
      console.log(e.params.data.text)
      spanEl.html('')
      spanEl.html("округ " + e.params.data.text + '<a href="#">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</a>')
      spanEl.attr('data-info', $(this).text())
      spanEl.show()
      spanEl.css('display', 'flex');
    } else {
      spanEl.hide()
    }
    span.unbind('click')
    span = $('#js-advanced-search .search-tags span')
    span.find('a').click(removeTag)
  })
  $('#advanced-search-location-city_area').on('change.select2', function (e) {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="area"]')
    if (e.params) {
      console.log(e.params.data.text)
      spanEl.html('')
      spanEl.html("округ " + e.params.data.text + '<a href="#">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</a>')
      spanEl.attr('data-info', $(this).text())
      spanEl.show()
      spanEl.css('display', 'flex');
    } else {
      spanEl.hide()
    }
    span.unbind('click')
    span = $('#js-advanced-search .search-tags span')
    span.find('a').click(removeTag)
  })

  $('#advanced-search-location-district').on('select2:select', function (e) {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="district"]')
    if (e.params) {
      console.log(e.params.data.text)
      spanEl.html('')
      spanEl.html("р-н " + e.params.data.text + '<a href="#">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</a>')
      spanEl.attr('data-info', $(this).text())
      spanEl.show()
      spanEl.css('display', 'flex');
    } else {
      spanEl.hide()
    }
    span.unbind('click')
    span = $('#js-advanced-search .search-tags span')
    span.find('a').click(removeTag)
  })
  $('#advanced-search-location-district').on('change.select2', function (e) {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="district"]')
    if (e.params) {
      console.log(e.params.data.text)
      spanEl.html('')
      spanEl.html("р-н " + e.params.data.text + '<a href="#">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</a>')
      spanEl.attr('data-info', $(this).text())
      spanEl.show()
      spanEl.css('display', 'flex');
    } else {
      spanEl.hide()
    }

    span.unbind('click')
    span = $('#js-advanced-search .search-tags span')
    span.find('a').click(removeTag)
  })

  $('#advanced-search-location-metro').on('select2:select', function (e) {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="metro"]')
    if (e.params) {
      console.log(e.params.data.text)
      spanEl.html('')
      spanEl.html("метро " + e.params.data.text + '<a href="#">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</a>')
      spanEl.attr('data-info', $(this).text())
      spanEl.show()
      spanEl.css('display', 'flex');
    } else {
      spanEl.hide()
    }
    span.unbind('click')
    span = $('#js-advanced-search .search-tags span')
    span.find('a').click(removeTag)
  })
  $('#advanced-search-location-metro').on('change.select2', function (e) {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="metro"]')
    if (e.params) {
      console.log(e.params.data.text)
      spanEl.html('')
      spanEl.html("метро " + e.params.data.text + '<a href="#">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</a>')
      spanEl.attr('data-info', $(this).text())
      spanEl.show()
      spanEl.css('display', 'flex');
    } else {
      spanEl.hide()
    }

    span.unbind('click')
    span = $('#js-advanced-search .search-tags span')
    span.find('a').click(removeTag)
  })

  $('#advanced-search-filter-fire').change(function () {
    let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="hot"]')
    if ($(this).prop('checked')) {
      spanEl.show()

      span.unbind('click')
      span = $('#js-advanced-search .search-tags span')
      span.find('a').click(removeTag)
      spanEl.css('display', 'flex');
    } else {
      spanEl.hide()
    }
  })

  $('.search-tags span[data-type-tag=cost] a').click(function () {
    $('.advanced-search-prices-in.advanced-search-prices-in-item').addClass('disabled')
    $('.advanced-search-prices-item').addClass('disabled')
    $('[name=cost]').prop('checked',false).attr("disabled", true)

    $('input[name=search-price]:checked').prop('checked',false)
    $('.search-tags span[data-type-tag=cost]').hide()

    let event = new Event('change');
    let form = document.getElementById('js-advanced-search')
    form.dispatchEvent(event)
  })

  // $('[name=cost]:checked + label').text().trim()
  $('[name=cost]').change(function () {
    setCostTag(false)
  })

//  Возврат значений обратно при свораяивании поиска
  $('form#js-advanced-search #js-advanced-search-close-btn').click(function () {


    search_reset()

    $('form#js-advanced-search .advanced-search-details-item input[type="checkbox"]').each(function () {
      if (dataSearch.attributes.map(el => el.id).includes($(this).val())) {

        let attr = dataSearch.attributes.find(el => el.id === $(this).val())

        $(this).prop('checked', true)
        let attrDiv = $('.copy-attr').clone()
        $(attrDiv).removeClass('copy-attr')
          .removeClass('d-none')
          .addClass('d-flex')
          .attr('data-type-tag', 'attributes')
          .attr('data-info', attr.id)
          .prepend(attr.name)

        $('#js-advanced-search .search-tags').append(attrDiv)
        span.unbind('click')
        span = $('#js-advanced-search .search-tags span')
        span.find('a').click(removeTag)
      }
    })

    if (cost.name) {
      cost.type.prop('checked', true)
      cost.name.removeClass('disabled')
      cost.cost.prop('checked', true)
    }

    setCostTag(true)

    if ($('#advanced-search-location-city').val() !== dataSearch.city) {
      let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="city"]')
      spanEl.text('г.' + dataSearch.city)
      spanEl.attr('data-info', dataSearch.city)
      span.unbind('click')
      span = $('#js-advanced-search .search-tags span')
      span.find('a').click(removeTag)
      $('#advanced-search-location-city').val(dataSearch.city).trigger('change.select2')
    }

    if ($('#advanced-search-location-city_area').val() !== dataSearch.area) {
      let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="area"]')
      $('#advanced-search-location-city_area').val(dataSearch.area).trigger('change.select2')
      if (dataSearch.area === null) {
        spanEl.hide()
      } else {
        spanEl.html('округ ' + dataSearch.area + '<a href="#">' +
          '<i class="fa-solid fa-xmark"></i>' +
          '</a>')
        spanEl.attr('data-info', dataSearch.area)
        span.unbind('click')
        span = $('#js-advanced-search .search-tags span')
        span.find('a').click(removeTag)
        spanEl.show()
        spanEl.css('display', 'flex');
      }
    }

    if ($('#advanced-search-location-district').val() !== dataSearch.district) {
      let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="district"]')
      $('#advanced-search-location-district').val(dataSearch.district).trigger('change.select2')
      if (dataSearch.district === null) {
        spanEl.hide()
      } else {
        spanEl.html('р-н ' + dataSearch.district + '<a href="#">' +
          '<i class="fa-solid fa-xmark"></i>' +
          '</a>')
        spanEl.attr('data-info', dataSearch.district)
        span.unbind('click')
        span = $('#js-advanced-search .search-tags span')
        span.find('a').click(removeTag)
        spanEl.show()
        spanEl.css('display', 'flex');
      }
    }

    if ($('#advanced-search-location-metro').val() !== dataSearch.metro) {
      let spanEl = $('#js-advanced-search .search-tags span[data-type-tag="metro"]')
      $('#advanced-search-location-metro').val(dataSearch.metro).trigger('change.select2')
      if (dataSearch.metro == null) {
        spanEl.hide()
      } else {
        spanEl.html('метро ' + dataSearch.metro + '<a href="#">' +
          '<i class="fa-solid fa-xmark"></i>' +
          '</a>')
        spanEl.attr('data-info', dataSearch.metro)
        span.unbind('click')
        span = $('#js-advanced-search .search-tags span')
        span.find('a').click(removeTag)
        spanEl.show()
        spanEl.css('display', 'flex');
      }
    }


    setTimeout(() => {
      $('form#js-advanced-search button[type=submit]').text('Показать')
    }, 1000)
  })

})
$(document).ready(function () {
  setCostTag(true)
  resizeRating()
  $('#js-advanced-search-open-btn').click(function () {
    setTimeout(function () {
      resizeRating()
    }, 100)
  })
  $(window).resize(function () {
    resizeRating()
  })


})

function resizeRating () {
  let w = $('.rating-block').width();

  if ($(window).width() <= 990) {
    $('.advanced-search-filter .left .search-filter-fire').width(w)
  } else {
    $('.advanced-search-filter .left .search-filter-fire').css('width', 'auto')
  }
}

function removeTag (e) {
  let event = new Event('change');
  let form = document.getElementById('js-advanced-search')

  e.preventDefault()
  let span = $(this).parent('span')[0]

  let type = span.dataset.typeTag
  let info = span.dataset.info

  switch (type) {
    case 'area':
      console.log('area')
      $('#advanced-search-location-city_area').val(null).trigger('change.select2')
      $(span).hide()
      break
    case 'district':
      console.log('district')
      $('#advanced-search-location-district').val(null).trigger('change.select2')
      $(span).hide()
      break
    case 'metro':
      console.log('metro')
      $('#advanced-search-location-metro').val(null).trigger('change.select2')
      $(span).hide()
      break
    case 'attributes':
      console.log('attributes')
      let el = $('.advanced-search-details-item input[value="' + info +'"]')[0]
      if (el) {
        $(el).prop( "checked", false )
        $(span).remove()
      }
      break
    case 'hot':
      console.log('hot')
      $('#advanced-search-filter-fire').prop('checked', false)
      $(span).hide()
  }

  form.dispatchEvent(event);

}

function setCostTag(save = false) {
  setTimeout(function () {
    console.log(1)
    let span = $('.search-tags span[data-type-tag=cost] span')
    let name = $('.advanced-search-prices-in.advanced-search-prices-in-item')
      .not('.disabled')
      .find('.advanced-search-prices-in-label').text()
    console.log(span)
    if ($('[name=cost]:checked').length > 0 && $('input[name=search-price]:checked').length > 0) {
      console.log($('input[name=search-price]:checked').length > 0)
      span.text(name + ' ' + $('[name=cost]:checked + label').text().trim())
      $('.search-tags span[data-type-tag=cost]').show()
      if (save) {
        cost.name = $('.advanced-search-prices-in.advanced-search-prices-in-item')
          .not('.disabled')
        cost.type = $('input[name=search-price]:checked')
        cost.cost = $('[name=cost]:checked')

        $('#tag-cost-filter span').text(name + ' ' + $('[name=cost]:checked + label').text().trim())
        $('#tag-cost-filter').show()
      }
    } else {
      if (save) {
        cost = {}
      }
      console.log(0)
      span.text('')
      $('.search-tags span[data-type-tag=cost]').hide()
    }
  }, 200)
}