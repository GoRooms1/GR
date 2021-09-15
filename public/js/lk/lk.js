/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

let select = true
$('.select__top').bind('click', selectTop)

$('.select__item').bind('click', selectItem)

$(document).mouseup(function (e) {
	let container = $(".select");
	if (container.has(e.target).length === 0){
		$('.select__hidden').slideUp();
		$('.select__arrow').removeClass('open')
	}
});

/*
  Действия при клике на чекбокс
 */
$('.check').bind('click', function() {
  if (!$(this).is('[disabled]'))
	  $(this).siblings('input[type="radio"]').prop('checked', true)
})

let check = true
/*
  Действия при клике на чекбокс
 */
$('.check').bind('click', function() {

  if (!$(this).is('[disabled]')) {
    if ($(this).siblings('input[type="checkbox"]').prop('checked')) {
      $(this).siblings('input[type="checkbox"]').prop('checked', false)

    } else {
      $(this).siblings('input[type="checkbox"]').prop('checked', true)

    }
  }
})

$('input[name="fond1"]').bind('change', function() {
	if ($('#everyRoom').prop('checked')) {
		$('#fondText1').fadeIn(1)
		$('#fondText2').fadeOut(1)
	} else {
		$('#fondText2').fadeIn(1)
		$('#fondText1').fadeOut(1)
	}
})

$('.close-this').bind('click', function() {
	$('.overlay').removeClass('open')
	$(this).parent('.popup').removeClass('open')
})

$('.overlay').bind('click', function() {
	$('.overlay').removeClass('open')
	$('.popup').removeClass('open')
})

$('.staff-item_staff').bind('click', function() {
	$('#popupStaff').addClass('open')
	$('.overlay').addClass('open')
})

$('.staff-item_general').bind('click', function() {
	$('#popupGeneral').addClass('open')
	$('.overlay').addClass('open')
})

$('#adressBtn').bind('click', function() {
	$('#popupAdress').addClass('open')
	$('.overlay').addClass('open')
})

$('#objectBtn').bind('click', function() {
	$('#popupObject').addClass('open')
	$('.overlay').addClass('open')
})

$('#stationBtn').bind('click', function() {
	$('#popupStation').addClass('open')
	$('.overlay').addClass('open')
})

let change = true

/*
  Клонирование категории
 */
$('.category__add').bind('click', function() {
	$('.categories__item:last-child').clone(true, true).addClass('open').prependTo('.categories')
	event.preventDefault();
})

/*
  Клик и режим редактирование категории
 */
$('.category-change').bind('click', function() {
	let categoryText = $(this).parents('.categories__item').find('.categories__name').text(),
	categoryQuote = $(this).parents('.categories__item').find('.categories__quote').text()

	$(this).parents('.categories__item').addClass('open')
	$(this).parents('.categories__item').find('.field_hidden-room').val(categoryText)
	$(this).parents('.categories__item').find('.field_hidden-quote').val(categoryQuote)
})
/*
  Как на создание категории
 */
$('.category-good').bind('click', createCategory)

/*
  Действия на удаление категории
 */
$('.categoryRemove').bind('click', removeCategory)

$('.show-all').bind('click', function() {
	if ($(this).hasClass('show-all_disabled')) {
		event.preventDefault();
	} else {
		$('#popupDetails').addClass('open')
		$('.overlay').addClass('open')
	}
	
})

$('#orderRoom').bind('click focused bloor', function() {
	$(this).parents('.shadow').find('.caption-block .caption').slideUp(1)
	$(this).parents('.shadow').find('#orderRoomText').slideDown(1)
})

$('#numberRoom').bind('click focused bloor', function() {
	$(this).parents('.shadow').find('.caption-block .caption').slideUp(1)
	$(this).parents('.shadow').find('#numberRoomText').slideDown(1)
})

$('#nameRoom').bind('click focused bloor', function() {
	$(this).parents('.shadow').find('.caption-block .caption').slideUp(1)
	$(this).parents('.shadow').find('#nameRoomText').slideDown(1)
})

$('#selectRoom').bind('click focused bloor', function() {
	$(this).parents('.shadow').find('.caption-block .caption').slideUp(1)
	$(this).parents('.shadow').find('#selectRoomText').slideDown(1)
})

/*
  Клик для удаления комнаты
 */
$('.quote__remove').bind('click', removeRoom)

/*
  Клик для создания новой комнаты
 */
$('.room__add').on('click', createRoom)

let textChange = true,
textChange2 = true

/*
  Клик для сохранения с поля в блок
 */
$('#howRideBtn').bind('click', function() {
	let text = $(this).parents('.part').find('.text').text()

	if (textChange == true) {
		$(this).parents('.part').find('.ck-editor__main p').text(text)
		$(this).text('Сохранить')
		$(this).parents('.part').find('.editor__text').hide()
		$(this).parents('.part').removeClass('ck-editor_hidden')
		textChange = false
	} else if(textChange == false) {
		let editorText =  $(this).parents('.part').find('.ck-content').html()

		
		if (editorText == "") {
			textChange = false
		} else {
			$(this).parents('.part').find('.editor__text').show()
			$(this).parents('.part').find('.editor__text').html(editorText)
			$(this).parents('.part').addClass('ck-editor_hidden')
			$(this).parents('.part').find('.ck-editor__main i')
			$(this).text('Редактировать')
			textChange = true

		}
		
	}
})

/*
  Клик для сохранения с поля в блок
 */
$('#howRideBtn2').bind('click', function() {
	let text = $(this).parents('.part').find('.text').text()

	if (textChange2 == true) {
		$(this).parents('.part').find('.ck-editor__main p').text(text)
		$(this).text('Сохранить')
		$(this).parents('.part').find('.editor__text').hide()
		$(this).parents('.part').removeClass('ck-editor_hidden')
		textChange2 = false
	} else if(textChange2 == false) {
		let editorText =  $(this).parents('.part').find('.ck-content').html()
		
		if (editorText == "") {
			textChange2 = false
		} else {
			$(this).parents('.part').find('.editor__text').show()
			$(this).parents('.part').find('.editor__text').html(editorText)
			$(this).parents('.part').addClass('ck-editor_hidden')
			$(this).parents('.part').find('.ck-editor__main i')
			$(this).parents('.part').find('.ck-content').css('padding', '0')
			$(this).text('Редактировать')
			textChange2 = true

		}
	}
})

/*
  Клик на удаление фотографии
 */
$('.remove-photo').bind('click', function() {
	$(this).parents('.uploud__item').remove()
})

/*
  Клик на выбор согласия
 */
$('.agreement-choice').bind('click', function() {
	if ($('#agreement').prop('checked')) {
		$('#registerObject').removeAttr('disabled')
	} else if (!$('#agreement').prop('checked')) {
		$('#registerObject').prop('disabled', true)
	}
})

/*
  Клик на редактирование комнаты
 */
$('.quote__read').bind('click', allowedEditRoom)

/*
  Клик на сохранение комнаты
 */
$('.save-room').bind('click', saveRoom)

/*
  При поднятии клавиши клавиатуры в поле email
 */
$('input[type="email"]').bind('keyup', function() {
	var email = $(this).val();
	if (!validateEmail(email)) {
		
		$(this).css('border', '1px solid orange')
		
	} else if (validateEmail(email)) {
		$(this).css('border', '1px solid #2f64ad')
		
	}
})

/*
  При поднятии клавиши клавиатуры в поле телдефон
 */
$('input[type="phone"]').bind('keyup', function() {
	var phone = $(this).val();
	if (!validatePhone(phone)) {
		
		$(this).css('border', '1px solid orange')
		
	} else if (validatePhone(phone)) {
		$(this).css('border', '1px solid #2f64ad')
		
	}
})

/*
  Валидация Email
 */
function validateEmail(email) {
  let emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return emailReg.test(email);
}

/*
  Валидация телефона
 */
function validatePhone(phone){
  let regex = /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/;
  return regex.test(phone);
}

/*
  Нахождение нужного файла из дропзоны
 */
function findExistImage (file, files) {
  return files.filter(x => {
    if (file.xhr) {
      let image = JSON.parse(file.xhr.response).payload.images[0]
      console.log(window.location.origin + "/" + image.path)
      return (window.location.origin + "/" + image.path) === x.path
    } else {
      console.log(1)
      return x.path === file.dataURL
    }
  }).pop()
}

/*
  Действия при клике на итем в меню
 */
function selectItem () {
  if ($(this).attr('disable') !== true) {
    $(this).siblings('.select__item').removeClass('active')
    $(this).addClass('active')
    let input = $(this).parent('.select__hidden').siblings('input[type="hidden"]')

    $(input).val(this.dataset.id)

    $(this).parent('.select__hidden').slideUp()
    $(this).parent('.select__hidden').siblings('.select__top').find('.select__current').text($(this).text())
    $(this).parent('.select__hidden').siblings('.select__top').find('.select__arrow').removeClass('open')
  }
}

/*
  Действия при удалении категории
 */
function removeCategory () {

  let item = $(this).parents('.categories__item').get(0);

  let id = item.dataset.id
  if (id) {
    let url = $('[name="category.delete"]').get(0)
    if (url) {
      url = url.value + '/' + id

      axios.delete(url)
        .then(response => {
          if (response.data.status === 'error') {
            alert('Ошибка сохранения')
          } else {
            $(item).remove()

            $('li.select__item[data-id=' + id +']').remove()

            if (typeof afterRemoveCategory === 'function') {
              afterRemoveCategory(id)
            }

            if (response.data.reload) {
              location.reload();
            }
          }
        })
        .catch(error => {
          console.error(error)
        })
    }
  } else {
    $(item).remove()
  }


  event.preventDefault();

}

/*
  Действия при создании категории
 */
function createCategory () {

  let categoryVal = $(this).parents('.categories__item').find('.field_hidden-room').val()
  let categoryValQuote = $(this).parents('.categories__item').find('.field_hidden-quote').val()

  if (categoryVal === "" || categoryValQuote === "") {

  } else {
    let item = $(this).parents('.categories__item').get(0)
    let oldVal = $(item).find('.categories__name').get(0).innerText
    console.log(oldVal)
    $(item).removeClass('open')
    $(item).find('.categories__name').text(categoryVal)
    $(item).find('.categories__quote').text(categoryValQuote)
    let id = item.dataset.id
    // Если есть id то редактировать
    if (id) {
      let url = $('[name="category.update"]').get(0)
      if (url) {
        url = url.value
        let hotel_id = $('[name="hotel_id"]').get(0).value

        axios.put(url, {
          id: id,
          name: categoryVal,
          hotel_id: hotel_id,
          value: categoryValQuote ? categoryValQuote : null
        })
          .then(response => {
            if (response.data.status === 'error') {
              $(item).find('.categories__name').text(oldVal)
              alert('Ошибка сохранения')
            } else {

              let ul = $('.category__list')
              ul.each(function(i) {
                let li = $(this).find('li')
                li.each(function () {
                  console.log($.trim($(this).text()))
                  if ($.trim($(this).text()) === oldVal) {
                    $(this).text(categoryVal)
                  }
                })
              })
              if (typeof afterUpdateCategory === 'function') {
                afterUpdateCategory({
                  name: categoryVal,
                  value: categoryValQuote,
                  id
                })
              }
            }
          })
          .catch(error => {
            console.error(error)
            $(item).find('.categories__name').text(oldVal)
            if (error.response.data.errors) {
              error.response.data.errors.name.forEach(e => {
                alert(e)
              })
            }
          })
      } else {
        alert('Ошибка сохранения')
      }

      //  Если нет то создавать
    } else {
      let url = $('[name="category.create"]').get(0)
      let hotel_id = $('[name="hotel_id"]').get(0).value
      if (url) {
        url = url.value

        axios.post(url, {
          name: categoryVal,
          value: categoryValQuote ? categoryValQuote : null,
          hotel_id: hotel_id
        })
          .then(response => {
            if (response.data.status === 'error') {
              alert('Ошибка сохранения')
              $(item).find('.categories__name').text(oldVal)
            } else if (response.data.category) {
              console.log(response.data.category)
              let category = response.data.category
              item.dataset.id = category.id

              if (typeof afterCreateCategory === 'function') {
                afterCreateCategory({
                  name: categoryVal,
                  value: categoryValQuote,
                  id,
                  room_id: response.data.room.id
                });
              }

              let ul = $('.category__list')

              ul.each(function(i) {
                let li = $($(ul).find('li').get(0)).clone()
                $(li).attr('disable', false)
                if (li.length === 0) {
                  li = document.createElement('li')
                  $(li).addClass('select__item')
                }
                $(li).appendTo($(this))
                console.log(li, this)
                $(li).attr("data-id", category.id)
                $(li).removeClass('active')
                $(li).text(category.name)
                $(li).on('click', selectItem)
              })

            }
          })
          .catch(error => {
            console.error(error)
            $(item).find('.categories__name').text(oldVal)
            if (error.response.data.errors) {
              error.response.data.errors.forEach(e => {
                alert(e)
              })
            }
          })
      } else {
        alert('Ошибка сохранения')
      }
    }
  }

}

function selectTop () {
  $('.select__arrow').not($(this).find('.select__arrow')).removeClass('open')
  $(this).find('.select__arrow').toggleClass('open')
  $('.select__hidden').not($(this).siblings('.select__hidden')).slideUp(1)
  $(this).siblings('.select__hidden').slideToggle()
}

if ($('.arrow-up').length > 0)
  $('.arrow-up').on('click', upOrderRoom)

if ($('.arrow-down').length > 0)
  $('.arrow-down').on('click', downOrderRoom)

if (typeof updateArrow === 'function') {
  updateArrow()
}