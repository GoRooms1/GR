let allDisabledButton;

$(document).ready(function () {
  let form1 = $('#form1')
  let form2 = $('#form2')
  let form3 = $('#form3')
  let form4 = $('#form4')
  let form5 = $('#form5')
  let form6 = $('#form6')
  if (typeof axios !== 'undefined' && moderate === 0) {

    $('section form').find("button[type=submit]").prop("disabled", true);
    allDisabledButton = true
    focusInput = false

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

    // Form 1
    function form1Edit () {
      if (allDisabledButton) {
        allDisabledButton = false
        form1.find('button[type=submit]').prop("disabled", false)
        readOnlyInput (form1)
      }
    }
    form1.find('input').keypress(form1Edit)
    form1.find('input').change(form1Edit)
    form1.submit(function (event) {
      event.preventDefault();
      let data = {}
      data.phone = $("input[name='phone']", this).val();
      data.phone_2 = $("input[name='phone_2']", this).val();
      data.email = $("input[name='email']", this).val();
      data.type_update = $("input[name='type_update']", this).val();
      console.log(data)
      axios.post('/lk/object/update', {
        ...data
      })
        .then(r => {
          if (r.data.status === 'success') {
            unReadOnlyInput()
            disableButtons ()
            successMessage ()
          } else {
            errorMessage()
          }
        })
        .catch(e => {
          errorMessage()
        })
    })

    // Form 2
    function form2Edit() {
      if (allDisabledButton) {
        readOnlyInput (form2)
        allDisabledButton = false
        form2.find('button[type=submit]').prop("disabled", false)
      }
    }
    form2.find('input').keypress(form2Edit)
    form2.find('input').change(form2Edit)
    form2.submit(function (event) {
      event.preventDefault();
      let data = {}
      data.type_update = $("input[name='type_update']", this).val();
      data.comment = $("input[name='comment']", this).val()
      console.log(data)
      axios.post('/lk/object/update', {
        ...data
      })
        .then(r => {
          if (r.data.status === 'success') {
            unReadOnlyInput ()
            disableButtons ()
            successMessage ()
          } else {
            errorMessage()
          }
        })
        .catch(e => {
          errorMessage()
        })
    })

    // Form 3
    function form3Edit () {
      if (allDisabledButton) {
        allDisabledButton = false
        readOnlyInput (form3)
        form3.find('button[type=submit]').prop("disabled", false)
      }
    }
    form3.find('textarea').keypress(form3Edit)
    form3.find('textarea').change(form3Edit)
    form3.submit(function (event) {
      event.preventDefault();
      let data = {}
      data.type_update = $("input[name='type_update']", this).val();
      data.description = $("textarea[name='description']", this).val()
      console.log(data)
      axios.post('/lk/object/update', {
        ...data
      })
        .then(r => {
          if (r.data.status === 'success') {
            unReadOnlyInput ()
            disableButtons ()
            successMessage ()
          } else {
            errorMessage()
          }
        })
        .catch(e => {
          errorMessage()
        })
    })

    // Form 4
    function form4Edit () {
      if (allDisabledButton) {
        allDisabledButton = false
        readOnlyInput (form4)
        form4.find('button[type=submit]').prop("disabled", false)
      }
    }
    form4.find('textarea').keypress(form4Edit)
    form3.find('textarea').change(form4Edit)
    form4.submit(function (event) {
      event.preventDefault();
      let data = {}
      data.type_update = $("input[name='type_update']", this).val();
      data.route = $("textarea[name='route']", this).val()
      console.log(data)
      axios.post('/lk/object/update', {
        ...data
      })
        .then(r => {
          if (r.data.status === 'success') {
            disableButtons ()
            unReadOnlyInput ()
            successMessage ()
          } else {
            errorMessage()
          }
        })
        .catch(e => {
          errorMessage()
        })
    })

    // Form 5
    function form5Edit () {
      if (allDisabledButton) {
        allDisabledButton = false
        readOnlyInput (form5)
        form5.find('button[type=submit]').prop("disabled", false)
      }
    }
    form5.find('input').keypress(form5Edit)
    form5.find('input').change(form5Edit)
    form5.submit(function (event) {
      event.preventDefault();
      let data = {}
      console.log()
      data.type_update = $("input[name='type_update']", this).val() ? $("input[name='type_update']", this).val() : [] ;
      if ($("select[name='metros[]']", this).length > 0) {
        data.metros = $("select[name='metros[]']", this).map(function () { return this.value}).get()
      } else {
        data.metros = []
      }
      if ($("input[name='metros_color[]']", this).length > 0) {
        data.metros_color = $("input[name='metros_color[]']", this).map(function () { return this.value}).get()
      } else {
        data.metros_color = []
      }
      if ($("input[name='metros_time[]']", this).length > 0) {
        data.metros_time = $("input[name='metros_time[]']", this).map(function () { return this.value}).get()
      } else {
        data.metros_time = []
      }

      console.log(data)
      axios.post('/lk/object/update', {
        ...data
      })
        .then(r => {
          if (r.data.status === 'success') {
            unReadOnlyInput ()
            disableButtons ()
            successMessage ()
          } else {
            errorMessage()
          }
        })
        .catch(e => {
          console.log(e)
          errorMessage()
        })
    })

    // Form 6
    function form6Edit () {
      if (allDisabledButton) {
        readOnlyInput (form6)
        allDisabledButton = false
        form6.find('button[type=submit]').prop("disabled", false)
      }

      if (typeof changeCheckboxCallback === 'function') {
        changeCheckboxCallback.call(this)
      }
    }
    form6.find('input').keypress(form6Edit)
    form6.find('input').change(form6Edit)
    form6.submit(function (event) {
      event.preventDefault();
      let data = {}
      let serialize = $(this).serializeArray()
      data.type_update = $("input[name='type_update']", this).val();
      data.attr = serialize.filter(e => e.name.includes('attr')).map(function(v) {return v.name.split('[')[1].split(']')[0];} )
      console.log(data)
      axios.post('/lk/object/update', {
        ...data
      })
        .then(r => {
          if (r.data.status === 'success') {
            unReadOnlyInput ()
            disableButtons ()
            successMessage ()
          } else {
            errorMessage()
          }
        })
        .catch(e => {
          errorMessage()
        })
    })

  }

  function errorMessage () {
    Swal.fire({
      title: 'Произошла ошибка',
      text: 'При сохранении данных произошла ошибка, обратитесь к администратора',
      icon: 'error',
      confirmButtonText: 'Отмена'
    })
  }

  function successMessage () {
    Swal.fire({
      title: 'Данные сохранены',
      text: 'Новые данные сохранены и будут отправлены на модерацию. Вы можете продолжить вносить новые данные отеля',
      icon: 'success',
      confirmButtonText: 'Далее'
    })
  }

  function disableButtons () {
    $('section form').find("button[type=submit]").prop("disabled", true);
    allDisabledButton = true
  }
  function alertSwal () {
    Swal.fire({
      title: 'Необходимо сохранить изменёные данные',
      text: 'Для продолжения редактирования, необходимо сохранить ранее изменённые данные',
      icon: 'warning',
      confirmButtonText: 'Ok'
    })
  }

  function readOnlyInput(notForm) {
    form1 !== notForm ? form1.find('input').prop('readonly', true) : null
    form2 !== notForm ? form2.find('input').prop('readonly', true) : null
    form3 !== notForm ? form3.find('textarea').prop('readonly', true) : null
    form4 !== notForm ? form4.find('textarea').prop('readonly', true) : null
    form5 !== notForm ? form5.find('input').prop('readonly', true) : null
    form6 !== notForm ? form6.find('input').prop('disabled', true) : null
    form6 !== notForm ? form6.find('div.check').attr('disabled', true) : null

    listenClickToOpenAlert (notForm)
  }

  function listenClickToOpenAlert (notForm) {
    form1 !== notForm ? form1.find('input').click(alertSwal) : null
    form2 !== notForm ? form2.find('input').click(alertSwal) : null
    form3 !== notForm ? form3.find('textarea').click(alertSwal) : null
    form4 !== notForm ? form4.find('textarea').click(alertSwal) : null
    form5 !== notForm ? form5.find('input').click(alertSwal) : null
    form6 !== notForm ? form6.find('input').click(alertSwal) : null
    form6 !== notForm ? form6.find('div.check').click(alertSwal) : null
  }

  function unReadOnlyInput() {
    form1.find('input').prop('readonly', false)
    form2.find('input').prop('readonly', false)
    form3.find('textarea').prop('readonly', false)
    form4.find('textarea').prop('readonly', false)
    form5.find('input').prop('readonly', false)
    form6.find('input').prop('disabled', false)
    form6.find('.check').attr('disabled', false)

    unListenClickToOpenAlert ()
  }

  function unListenClickToOpenAlert () {
    form1.find('input').off('click');
    form2.find('input').off('click');
    form3.find('textarea').off('click');
    form4.find('textarea').off('click');
    form5.find('input').off('click');
    form6.find('input').off('click');
    form6.find('div.check').off('click')
    form6.find('div.check').bind('click', function () {

      if (!$(this).is('[disabled]')) {
        if ($(this).siblings('input[type="checkbox"]').prop('checked')) {
          $(this).siblings('input[type="checkbox"]').prop('checked', false).trigger('change');

        } else {
          $(this).siblings('input[type="checkbox"]').prop('checked', true).trigger('change');

        }
      }
    })
  }
})

function disabledMetrosButtons () {
  let form5 = $('#form5')
  console.log(123)
  if (allDisabledButton) {
    allDisabledButton = false
    form5.find('button[type=submit]').prop("disabled", false)
  }
}