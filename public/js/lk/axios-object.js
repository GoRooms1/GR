let allDisabledButton;

$(document).ready(function () {
  if (typeof axios !== 'undefined' && moderate === 0) {

    $('section form').find("button[type=submit]").prop("disabled", true);
    allDisabledButton = true

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

    // Form 1
    function form1Edit () {
      if (allDisabledButton) {
        allDisabledButton = false
        form1.find('button[type=submit]').prop("disabled", false)
      }
    }
    let form1 = $('#form1')

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
        allDisabledButton = false
        form2.find('button[type=submit]').prop("disabled", false)
      }
    }
    let form2 = $('#form2')
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
        form3.find('button[type=submit]').prop("disabled", false)
      }
    }
    let form3 = $('#form3')
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
        form4.find('button[type=submit]').prop("disabled", false)
      }
    }
    let form4 = $('#form4')
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
        form5.find('button[type=submit]').prop("disabled", false)
      }
    }
    let form5 = $('#form5')
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
      // data.metros = $("select[name='metros[]']", this).length > 0 ? $("select[name='metros[]']", this).map(function () { return this.value}) : []
      if ($("input[name='metros_color[]']", this).length > 0) {
        data.metros_color = $("input[name='metros_color[]']", this).map(function () { return this.value}).get()
      } else {
        data.metros_color = []
      }
      // data.metros_colors = $("input[name='metros_color[]']", this).length > 0 ? $("input[name='metros_color[]']", this).map(function () { return this.value}) : []
      if ($("input[name='metros_time[]']", this).length > 0) {
        data.metros_time = $("input[name='metros_time[]']", this).map(function () { return this.value}).get()
      } else {
        data.metros_time = []
      }
      // data.metros_time = $("input[name='metros_time[]']", this).length > 0 ? $("input[name='metros_time[]']", this).map(function () { return this.value}) : []

      console.log(data)
      axios.post('/lk/object/update', {
        ...data
      })
        .then(r => {
          if (r.data.status === 'success') {
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
        allDisabledButton = false
        form6.find('button[type=submit]').prop("disabled", false)
      }
    }
    let form6 = $('#form6')
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
})

function disabledMetrosButtons () {
  let form5 = $('#form5')
  console.log(123)
  if (allDisabledButton) {
    allDisabledButton = false
    form5.find('button[type=submit]').prop("disabled", false)
  }
}