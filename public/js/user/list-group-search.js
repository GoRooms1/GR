$(function () {
  let mini_list = $('#mini-list-group')
  let big_list = $('#big-list-group')
  let mini_search = $('input#search-mini')
  let big_search = $('input#advanced-search')

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
      $(mini_list).fadeIn()
      $(big_list).fadeIn()
    } else {
      $(mini_list).fadeOut()
      $(big_list).fadeOut()
    }
  })

  $(big_search).focusin(function () {
    let val = $(this).val()
    if (val !== '') {
      $(big_list).fadeIn()
    } else {
      $(big_list).fadeOut()
    }
  })

  $(mini_search).on('input propertychange', function () {
    let val = $(this).val()
    console.log(val)
    if (val !== '') {
      $(mini_list).fadeIn()
      updateDataListHelper()
    } else {
      $(mini_list).fadeOut();
    }
  })

  $(big_search).on('input propertychange', function () {
    let val = $(this).val()
    console.log(val)
    if (val !== '') {
      $(big_list).fadeIn()
      updateDataListHelperBigSearch()
    } else {
      $(big_list).fadeOut();
    }
  })

  addListenerClickListGroupItemAdd()
})

function addListenerClickListGroupItemAdd ()
{
  let mini_search = $('input#search-mini')
  let big_search = $('input#advanced-search')

  $('.list-group-item-click-add').unbind('click');

  $('.list-group-item-click-add').click(function (e) {
    e.preventDefault()
    let el = $(this)
    console.log(this)
    $(mini_search).val(el.text())
    $(big_search).val(el.text())
  })
}

function updateDataListHelper () {

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
  let mini_search = $('input#search-mini')
  big_list.empty()
  mini_list.empty()
  let div = document.createElement("div")
  let div2 = document.createElement("div")
  div.style.cssText = 'background: #fff; padding-top: 20px; padding-bottom: 20px';
  big_list.append(div)
  mini_list.append(div2)
  createSpinner(div)
  createSpinner(div2)
  axios.get('/api/filter/all', {
    params: {
      q: mini_search.val()
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
              let block = ''
              if (item === 'hotels') {
                block = '<a href="/hotels/' + list_item.slug +'" class="list-group-item list-group-item-action">' + list_item.name +'</a>'
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
    .catch(e => {
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

function updateDataListHelperBigSearch () {

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
  let big_search = $('input#advanced-search')
  big_list.empty()
  mini_list.empty()
  let div = document.createElement("div")
  let div2 = document.createElement("div")
  div.style.cssText = 'background: #fff; padding-top: 20px; padding-bottom: 20px';
  big_list.append(div)
  mini_list.append(div2)
  createSpinner(div)
  createSpinner(div2)
  axios.get('/api/filter/all', {
    params: {
      q: big_search.val()
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
              let block = ''
              if (item === 'hotels') {
                block = '<a href="/hotels/' + list_item.slug +'" class="list-group-item list-group-item-action">' + list_item.name +'</a>'
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
    .catch(e => {
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