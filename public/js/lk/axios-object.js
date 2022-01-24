let allDisabledButton;

$(document).ready(function () {
  if (typeof axios !== 'undefined' && moderate === 0) {

    $('section form').find("button[type=submit]").prop("disabled", true);
    allDisabledButton = true

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

    // Form 1
    let form1 = $('#form1')
    form1.find('input').keypress(() => {
      if (allDisabledButton) {
        allDisabledButton = false
        form1.find('button[type=submit]').prop("disabled", false)
      }
    })
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
    let form2 = $('#form2')
    form2.find('input').keypress(() => {
      if (allDisabledButton) {
        allDisabledButton = false
        form2.find('button[type=submit]').prop("disabled", false)
      }
    })
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
    let form3 = $('#form3')
    form3.find('textarea').keypress(() => {
      if (allDisabledButton) {
        allDisabledButton = false
        form3.find('button[type=submit]').prop("disabled", false)
      }
    })
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
    let form4 = $('#form4')
    form4.find('textarea').keypress(() => {
      if (allDisabledButton) {
        allDisabledButton = false
        form4.find('button[type=submit]').prop("disabled", false)
      }
    })
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
    let form5 = $('#form5')
    form5.find('input').keypress(() => {
      if (allDisabledButton) {
        allDisabledButton = false
        form5.find('button[type=submit]').prop("disabled", false)
      }
    })
    form5.find('input').change(() => {
      if (allDisabledButton) {
        allDisabledButton = false
        form5.find('button[type=submit]').prop("disabled", false)
      }
    })
    form5.submit(function (event) {
      event.preventDefault();
      let data = {}
      data.type_update = $("input[name='type_update']", this).val() ? $("input[name='type_update']", this).val() : [] ;
      data.metros = $("select[name='metros[]']", this).val() ? $("select[name='metros[]']", this).val() : []
      data.metros_colors = $("input[name='metros_colors[]']", this).val() ? $("input[name='metros_colors[]']", this).val() : []
      data.metros_time = $("input[name='metros_time[]']", this).val() ? $("input[name='metros_time[]']", this).val() : []
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

    // Form 6
    let form6 = $('#form6')
    form6.find('input').change(() => {
      if (allDisabledButton) {
        allDisabledButton = false
        form6.find('button[type=submit]').prop("disabled", false)
      }
    })
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