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
    } else {
      spanEl.hide()
    }
  })

})

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