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

function selectTop () {
  $('.select__arrow').not($(this).find('.select__arrow')).removeClass('open')
  $(this).find('.select__arrow').toggleClass('open')
  $('.select__hidden').not($(this).siblings('.select__hidden')).slideUp(1)
  $(this).siblings('.select__hidden').slideToggle()
}

$('.select__item').bind('click', selectItem)

$(document).mouseup(function (e) {
	var container = $(".select");
	if (container.has(e.target).length === 0){
		$('.select__hidden').slideUp();
		$('.select__arrow').removeClass('open')
	}
});

$('.check').bind('click', function() {
	$(this).siblings('input[type="radio"]').prop('checked', true)
})

let check = true
$('.check').bind('click', function() {

	if ($(this).siblings('input[type="checkbox"]').prop('checked')) {
		$(this).siblings('input[type="checkbox"]').prop('checked', false)

	} else {
		$(this).siblings('input[type="checkbox"]').prop('checked', true)

	}
	// if (check == true) {
	// 	check = false
	// } else if (check == false) {
	// 	check = true
	// }
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

// $('.change-category').bind('click', function() {
// 	let a1 = $(this).parent('.categories__control').siblings('.categories__first').find('.categories__name').text()
// 	let a2 = $(this).parent('.categories__control').siblings('.categories__second').find('.categories__quote').text()
// 	if (change == true) {
// 		$(this).find('.category-change').fadeOut(1)
// 		$(this).find('.category-good').fadeIn(1)
// 		$(this).parent('.categories__control').siblings('.categories__second').find('input').val(a2)
// 		$(this).parent('.categories__control').siblings('.categories__second').find('input').fadeIn(1)
// 		$(this).parent('.categories__control').siblings('.categories__first').find('input').val(a1)
// 		$(this).parent('.categories__control').siblings('.categories__first').find('input').fadeIn(1)
// 		$(this).parent('.categories__control').siblings('.categories__first').find('span').fadeOut(1)
// 		$(this).parent('.categories__control').siblings('.categories__second').find('span').fadeOut(1)
// 		change = false
// 	} else if (change == false) {
// 		let input1 = $(this).parent('.categories__control').siblings('.categories__first').find('input').val()
// 		let input2 = $(this).parent('.categories__control').siblings('.categories__second').find('input').val()
// 		if (input1 == "" || input2 == "") {

// 		} else {
// 			$(this).find('.category-change').fadeIn(1)
// 			$(this).find('.category-good').fadeOut(1)
// 			$(this).parent('.categories__control').siblings('.categories__first').find('.categories__name').text(input1)
// 			$(this).parent('.categories__control').siblings('.categories__second').find('.categories__quote').text(input2)
// 			$(this).parent('.categories__control').siblings('.categories__second').find('input').fadeOut(1)
// 			$(this).parent('.categories__control').siblings('.categories__first').find('input').fadeOut(1)
// 			$(this).parent('.categories__control').siblings('.categories__first').find('span').fadeIn(1)
// 			$(this).parent('.categories__control').siblings('.categories__second').find('span').fadeIn(1)
// 			change = true
// 		}


// 	}

// })

$('.category__add').bind('click', function() {
	$('.categories__item:last-child').clone(true, true).addClass('open').prependTo('.categories')
	event.preventDefault();
})

// let category = true
// $('.category-change').bind('click', function() {
// 	$(this).parents('.categories__item').addClass('open')
// 	let categoryName = $(this).parents('.categories__item').find('.categories__name'),
// 	fieldHidden = $(this).parents('.categories__item').find('.field_hidden')
// 	if (category == true) {
// 		let 
// 		fieldHidden.val(categoryName.text())
// 		category == false
// 	} else if (category == false) {
// 		categoryName.text(fieldHidden.val())
// 		category == true
// 	}

// })

// $('.category-good').bind('click', function() {
// 	$(this).parents('.categories__item').removeClass('open')
// })


$('.category-change').bind('click', function() {
	let categoryText = $(this).parents('.categories__item').find('.categories__name').text(),
	categoryQuote = $(this).parents('.categories__item').find('.categories__quote').text()

	$(this).parents('.categories__item').addClass('open')
	$(this).parents('.categories__item').find('.field_hidden-room').val(categoryText)
	$(this).parents('.categories__item').find('.field_hidden-quote').val(categoryQuote)
})

$('.category-good').bind('click', function() {

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
          hotel_id: hotel_id
        })
          .then(response => {
            if (response.data.status === 'error') {
              $(item).find('.categories__name').text(oldVal)
              alert('Ошибка сохранения')
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
	
})

// Удаление категории
$('.categoryRemove').bind('click', function() {

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
})

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

// $('#saveRoom').bind('click', function() {
// 	$('.hours__field').hide()
// 	$('.hours__hidden').css('display', 'flex');
// 	$('.rub').hide()
// 	$('.hours__after').show()
// 	$('.hours__select').hide()
// 	$(this).parents('.shadow').addClass('shadow-complete')
// 	$(this).parents('.shadow').find('.row__head').css('display', 'flex');
// 	$(this).parents('.shadow').find('.caption-block').hide();
// 	$(this).parents('.shadow').find('.room-details').hide();
// 	$(this).parents('.shadow').find('.more-details').hide();
// 	$(this).parents('.shadow').find(".choice .check").hide();
// 	$(this).parents('.shadow').find(".choice .check").hide();
// 	$(this).parents('.shadow').find(".show-all").hide();
// 	$(this).parents('.shadow').find('input[type="checkbox"]').prop('disabled', true);
// 	$(this).parents('.shadow').find('.room__checkboxes').addClass('row_white');
// 	$(this).hide()
// 	$(this).parents('.shadow').find('.quote__read').show()
// 	$(this).parents('.shadow').find('.row-status').show()
// })

$('.quote__remove').bind('click', function() {
  let shadow = $(this).parents('.shadow').get(0)


//  axios
//  TODO: delete variable uploader and existFile
  let url = $(shadow).find('input[name=url-delete]').val()
  axios.delete(url)
  .then(response => {
    if (response.data.success) {
      shadow.remove()
    }
  })
  .catch(error => {
    alert('Error server side')
    console.log(error)
  })
})

$('.room__add').on('click', function () {
  let room = $('#new_room').clone();
  let rooms = $('#rooms')

  rooms.prepend(room);
  room.removeClass('d-none')

  $('.select__item').bind('click', selectItem)
  $('.select__top').bind('click', selectTop)
})

// $('.save-button').bind('click', function() {
// 	if () else {
// 		$(this).parents('.part').find('input').prop('readonly', true);
// 	}
// })
let textChange = true,
textChange2 = true
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

$('.remove-photo').bind('click', function() {
	$(this).parents('.uploud__item').remove()
})

$('.agreement-choice').bind('click', function() {
	if ($('#agreement').prop('checked')) {
		$('#registerObject').removeAttr('disabled')
	} else if (!$('#agreement').prop('checked')) {
		$('#registerObject').prop('disabled', true)
	}
})

$('.save-room').bind('click', saveRoom)

$('.quote__read').bind('click', allowedEditRoom)

$('input[type="email"]').bind('keyup', function() {
	var email = $(this).val();
	if (!validateEmail(email)) {
		
		$(this).css('border', '1px solid orange')
		
	} else if (validateEmail(email)) {
		$(this).css('border', '1px solid #2f64ad')
		
	}
})

$('input[type="phone"]').bind('keyup', function() {
	var phone = $(this).val();
	if (!validatePhone(phone)) {
		
		$(this).css('border', '1px solid orange')
		
	} else if (validatePhone(phone)) {
		$(this).css('border', '1px solid #2f64ad')
		
	}
})

function validateEmail(email) {
  var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return emailReg.test(email);
}

function validatePhone(phone){
  let regex = /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/;
  return regex.test(phone);
}

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
  Редактирование комнаты по кнопке
 */
function allowedEditRoom ()  {
  $(this).parents('.shadow').find(".show-all").removeClass('show-all_disabled')
  $(this).parents('.shadow').find('.quote__read').show()
  $(this).parents('.shadow').find('.quote__status').hide()
  $(this).parents('.shadow').removeClass('shadow-complete')
  $(this).parents('.shadow').find('.row__head').hide()
  $(this).parents('.shadow').find('.caption-block').show();
  $(this).parents('.shadow').find('.room-details').show();
  $(this).parents('.shadow').find('.more-details').show();
  $(this).parents('.shadow').find('.hours__field').prop('disabled', false)
  $(this).parents('.shadow').find('.upload__remove').show()
  $(this).parents('.shadow').find('.sortable').sortable('enable');
  $(this).parents('.shadow').find('.uploud-photo').show()
  $(this).parents('.shadow').find('.save-room').show()
  $(this).hide()
}

/*
  Сохранение комнаты, фронт
 */
function saveRoom () {
  if ($(this).parents('.shadow').find('.dz-image-preview').length !== 0) {
    saveFontDate.call(this)
    let shadow = $(this).parents('.shadow').get(0)

    let number = $(shadow).find('input[name=number]').val()
    let order = $(shadow).find('input[name=order]').val()
    let name = $(shadow).find('input[name=name]').val()
    let category = $(shadow).find('input[name=category_id]').val()
    axios.post($(shadow).find('input[name=url]').val(), {
      id: shadow.dataset.id,
      number,
      order,
      name,
      category,
      types: $(shadow).find('input[name^=type]').map(function () {
        return {
          id: this.dataset.id,
          data: $(this).val(),
          value: $('#value-' + shadow.dataset.id + '-' +this.dataset.id).val()
        }
      }).get()
    })
    .then(response => {
      if (response.data.success) {
        if (!response.data.room.moderate) {
          $(shadow).find('.row__head')
            .removeClass('row__head_blue')
          $(shadow).find('.quote__status')
            .text('Проверка модератором')
          $(shadow).find('.quote__status')
            .removeClass('quote__status_blue')
            .addClass('quote__status_red')
        }
      }
    })
      .catch(error => {
        console.log(error)
        alert('Ошибка в сохранении комнаты')
      })

  }
}

function selectItem () {
  $(this).siblings('.select__item').removeClass('active')
  $(this).addClass('active')
  let input = $(this).parent('.select__hidden').siblings('input[type="hidden"]')

  $(input).val(this.dataset.id)

  $(this).parent('.select__hidden').slideUp()
  $(this).parent('.select__hidden').siblings('.select__top').find('.select__current').text($(this).text())
  $(this).parent('.select__hidden').siblings('.select__top').find('.select__arrow').removeClass('open')
}

function saveFontDate () {
  if ($(this).parents('.shadow').find('.dz-image-preview').length !== 0) {
    let shadow = $(this).parents('.shadow')
    $(shadow).find('.remove-btn').hide()
    $(this).hide()
    $(shadow).find(".show-all").addClass('show-all_disabled')
    $(shadow).find('.quote__read').show()
    $(shadow).find('.row-status').show()
    $(shadow).addClass('shadow-complete')
    $(shadow).find('.row__head').css('display', 'flex');
    $(shadow).find('.caption-block').hide();
    $(shadow).find('.room-details').hide();
    $(shadow).find('.more-details').hide();
    $(this).parents('.shadow-complete')
      .find('.hours__field')
      .prop('disabled', true)
    $(shadow).find('.quote__status').show()
    $(shadow).find('.upload__remove').hide()
    $(shadow).find('.sortable').sortable('disable');
    $(shadow).find('.uploud-photo').hide()

    let number = $(shadow).find('input[name=number]').val()
    let order = $(shadow).find('input[name=order]').val()
    let name = $(shadow).find('input[name=name]').val()
    let category = $(shadow).find('input[name=category_id]')
      .siblings('.select__top')
      .find('.select__current')
      .text()
    category = category === 'Категория' ? '' : category

    $($(shadow).find('.head-text').get(0)).html('#' + order)
    $($(shadow).find('.head-text').get(1)).html('№' + number)
    $($(shadow).find('.head-text').get(2)).html(name)
    $($(shadow).find('.head-text').get(3)).html(category)
  }
}