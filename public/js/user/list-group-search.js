$(function () {

  let Timeout;
  let mini_list = $('#mini-list-group')
  let big_list = $('#big-list-group')
  let mini_search = $('input#search-mini')
  let big_search = $('input#advanced-search')

  let form = $('form#js-advanced-search')
  let url = form.attr('action');
  console.log(url)

  $(mini_search).focusout(function () {
    setTimeout(() => {
      $(mini_list).fadeOut()
      $(big_list).fadeOut()
    }, 500)
  })

  $(big_search).focusout(function () {
    setTimeout(() => {
      $(mini_list).fadeOut()
      $(big_list).fadeOut()
    }, 500)
  })

  $(mini_search).focusin(function () {
    let val = $(this).val()
    if (val !== '') {
      updateDataListHelper(url, mini_search)
      $(mini_list).fadeIn()
    } else {
      $(mini_list).fadeOut()
      $(big_list).fadeOut()
    }
  })

  $(big_search).focusin(function () {
    let val = $(this).val()
    if (val !== '') {
      updateDataListHelper(url, big_search)
      $(big_list).fadeIn()
    } else {
      $(mini_list).fadeOut()
      $(big_list).fadeOut()
    }
  })

  $(mini_search).on('input propertychange', function () {
    clearTimeout(Timeout)
    Timeout = null;

    if ($(mini_list).find('.spinner-wrapper').length < 1) {
      big_list.empty()
      mini_list.empty()

      let div = document.createElement("div")
      let div2 = document.createElement("div")
      div.style.cssText = 'background: #fff; padding-top: 20px; padding-bottom: 20px';
      div2.style.cssText = 'background: #fff; padding-top: 20px; padding-bottom: 20px';
      big_list.append(div)
      mini_list.append(div2)
      createSpinner(div)
      createSpinner(div2)
    }

    Timeout = setTimeout(() => {
      let val = $(this).val()
      console.log(val)
      if (val !== '') {
        updateDataListHelper(url, mini_search)
        $(mini_list).fadeIn()
      } else {
        $(mini_list).fadeOut();
      }
    }, 500)
  })

  $(big_search).on('input propertychange', function () {
    clearTimeout(Timeout)
    Timeout = null;

    if ($(big_list).find('.spinner-wrapper').length < 1) {
      big_list.empty()
      mini_list.empty()

      let div = document.createElement("div")
      let div2 = document.createElement("div")
      div.style.cssText = 'background: #fff; padding-top: 20px; padding-bottom: 20px';
      div2.style.cssText = 'background: #fff; padding-top: 20px; padding-bottom: 20px';
      big_list.append(div)
      mini_list.append(div2)
      createSpinner(div)
      createSpinner(div2)
    }

    Timeout = setTimeout(() => {
      let val = $(this).val()
      console.log(val)
      if (val !== '') {
        updateDataListHelper(url, big_search)
        $(big_list).fadeIn()
      } else {
        $(big_list).fadeOut();
      }
    }, 500)
  })

  addListenerClickListGroupItemAdd()
})

function addListenerClickListGroupItemAdd ()
{
  let mini_search = $('input#search-mini')
  let big_search = $('input#advanced-search')

  let listGroupItemClickAdd = $('.list-group-item-click-add')

  listGroupItemClickAdd .unbind('click');

  listGroupItemClickAdd .click(function (e) {
    e.preventDefault()
    let el = $(this)
    console.log(this)
    $(mini_search).val(el.text())
    $(big_search).val(el.text())
  })
}

function updateDataListHelper (url, search) {

  let names = {
    hotels: 'Отели',
    metros: 'Станции метро',
    street: 'Улицы',
    city: 'Города',
    area: 'Округи',
    district: 'Районы'
  }

  let mini_list = $('#mini-list-group')
  let big_list = $('#big-list-group')

  axios.get('/api/filter/all', {
    params: {
      q: search.val()
    }
  })
    .then(r => {
      let data = r.data.payload
      // console.log(data)
      big_list.empty()
      mini_list.empty()
      if (data.count < 1) {
        big_list.append(
          '<p class="list-group-item list-group-item-action item-action-title">Совпадений не найдено</p>'
        )
        mini_list.append(
          '<p class="list-group-item list-group-item-action item-action-title">Совпадений не найдено</p>'
        )
      } else {
        for (let item in data) {
          console.log(data[item])
          if (data[item].length > 0) {
            big_list.append(
              '<p class="list-group-item list-group-item-action item-action-title">' + names[item] +'</p>'
            )
            mini_list.append(
              '<p class="list-group-item list-group-item-action item-action-title">' + names[item] +'</p>'
            )
            data[item].forEach(list_item => {
              console.log(item)
              let block;
              if (item === 'hotels') {
                block = `<a href="/hotels/${list_item.slug}" class="list-group-item list-group-item-action"><span class="font-weight-bold">${list_item.name}</span> г.${list_item.address.city}</a>`
              } else if (item === 'metros') {
                block = `<a href="${url}?metro=${list_item.name}&city=${list_item.address.city}&city_area=${list_item.address.city_area}&district=${list_item.address.city_district}" class="list-group-item list-group-item-action"><span class="font-weight-bold">${list_item.name}</span> г.${list_item.address.city}</a>`
              } else if (item === 'city') {
                block = `<a href="${url}?city=${list_item.name}" class="list-group-item list-group-item-action"><span class="font-weight-bold">${list_item.name}</span></a>`
              } else if (item === 'area') {
                block = `<a href="${url}?city=${list_item.city}&city_area=${list_item.name}" class="list-group-item list-group-item-action"><span class="font-weight-bold">${list_item.name}</span> г.${list_item.city}</a>`
              } else if (item === 'district') {
                block = `<a href="${url}?city=${list_item.city}&city_area=${list_item.area}&district=${list_item.name}" class="list-group-item list-group-item-action"><span class="font-weight-bold">${list_item.name}</span> г.${list_item.city}</a>`
              } else if (item === 'street') {
                block =`<a href="${url}?city=${list_item.city}&city_area=${list_item.area}&district=${list_item.district}&street=${list_item.name}" class="list-group-item list-group-item-action"><span class="font-weight-bold">${list_item.name}</span> г.${list_item.city}</a>`
              } else {
                block = '<a href="' + list_item.id +'" class="list-group-item list-group-item-action list-group-item-click-add">' + list_item.name +'</a>'
              }

              big_list.append(
                block
              )
              mini_list.append(
                block
              )
            })
          }
        }

        addListenerClickListGroupItemAdd()
      }
    })
    .catch(() => {
      big_list.empty()
      big_list.append(
        '<p class="list-group-item list-group-item-action item-action-title">Ошибка при загрузки данных</p>'
      )

      mini_list.empty()
      mini_list.append(
        '<p class="list-group-item list-group-item-action item-action-title">Ошибка при загрузки данных</p>'
      )
    })
}