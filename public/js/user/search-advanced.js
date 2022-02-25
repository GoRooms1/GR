// При изменении формы мальенькой то применяется большая


$(function () {
  $('#search-mini').change(function () {
    let val = $(this).val()

    $('form#js-advanced-search input#advanced-search').val(val)
  })

  $('form#js-advanced-search input#advanced-search').change(function () {
    let val = $(this).val()

    $('#search-mini').val(val)
  })

  $('form#search-form').submit(function (e) {
    e.preventDefault();

    $('form#js-advanced-search').submit();
  })
})