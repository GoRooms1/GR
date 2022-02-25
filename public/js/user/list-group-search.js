$(function () {
  let mini_list = $('#mini-list-group')
  let mini_search = $('input#search-mini')

  $(mini_search).focusout(function () {
    $(mini_list).hide()
  })

  $(mini_search).focusin(function () {
    let val = $(this).val()
    if (val !== '') {
      $(mini_list).show()
    } else {
      $(mini_list).hide()
    }
  })

  $(mini_search).keyup(function () {
    let val = $(this).val()
    console.log(val)
    if (val !== '') {
      $(mini_list).show()
      updateDataListHelper()
    } else {
      $(mini_list).hide();
    }
  })
})

function updateDataListHelper () {
  let data = [
    {
      name: "Отели",
      data: [
        {
          name: 'Тест отель',
          id: 1,
          url: '#123123test'
        },
        {
          name: 'Тест отель 2',
          id: 2,
          url: '#123123test'
        }
      ]
    },
    {
      name: "Метро",
      data: [
        {
          name: Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5),
          id: 1,
          url: '#123123test'
        },
        {
          name: Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 10),
          id: 2,
          url: '#123123test'
        },
        {
          name: Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 7),
          id: 3,
          url: '#123123test'
        },
        {
          name: 'Арбат',
          id: 4,
          url: '#123123test'
        }
      ]
    }
  ]
  let mini_list = $('#mini-list-group')
  mini_list.empty()
  let div = document.createElement("div")
  div.style.cssText = 'background: #fff; padding-top: 20px; padding-bottom: 20px';
  mini_list.append(div)
  createSpinner(div)
  setTimeout(function () {
    mini_list.empty()
    data.forEach((item) => {
      mini_list.append(
        '<p class="list-group-item list-group-item-action item-action-title">' + item.name +'</p>'
      )

      item.data.forEach(item => {
        mini_list.append(
          '<a href="' + item.url +'" class="list-group-item list-group-item-action">' + item.name +'</a>'
        )
      })
    })
  }, 1000)


}