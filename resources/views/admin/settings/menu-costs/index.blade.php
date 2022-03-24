@extends('layouts.admin')



@section('content')
  <style>
    input[type=number] {
      -moz-appearance: textfield;
    }
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
      -webkit-appearance: none;
    }
  </style>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Настройки Фильтра стоимостей</div>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.settings.menu-costs.save') }}" method="POST" class="row">
          @csrf
          @foreach ($costTypes as $type)
            <div class="col-md-1 mb-3 mt-2">{{ $type->name }}</div>
            <div class="col-md-11 mb-3">
              <div class="form-row" data-id="{{ $type->id }}">
                @foreach($type->filterCosts as $cost)
                  <div class="col-6 col-md-4 col-lg-3 mt-1 position-relative">
                    <input type="number" class="form-control" name="type[{{ $type->id }}][]"
                           value="{{ $cost->cost }}"
                           placeholder="Цена">
                    <span class="position-absolute remove h-100 d-flex px-2 text-center align-items-center"
                          style="right: 10px; top: 0; cursor: pointer"
                    >
                      <b>X</b>
                    </span>
                  </div>
                @endforeach
              </div>
            </div>

          @endforeach
          <div class="row w-100 justify-content-end">
            <div class="col-auto">
              <button type="submit" class="btn btn-success">Обновить</button>
            </div>
          </div>
        </form>

        <div class="row mt-3">
          <div class="col-12">
            <hr>
            <h3>Добавить цену</h3>
          </div>
        </div>
        <div class="row align-items-end">
          <div class="col-md-4 col-lg-3">
            <div class="form-group">
              <label for="type">Тип стоимости</label>
              <select class="form-control" name="type" id="type">
                @foreach($costTypes as $type)
                  <option value="{{ $type->id }}">
                    {{ $type->name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4 col-lg-3">
            <div class="form-group">
              <button type="button" id="add" class="btn btn-primary">Добавить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script>
    $(document).ready(function () {
      let select = $('select#type')
      let button = $('button#add')

      button.click(function () {
        let selectVal = select.val()
        let form = $('.form-row[data-id=' + selectVal +']')
        let input = '<div class="col-6 col-md-4 col-lg-3 mt-1 position-relative">' +
          '<input type="number" class="form-control" name="type[' + selectVal +'][]" value="" placeholder="Цена">'+
          '<span class="position-absolute remove h-100 d-flex px-2 text-center align-items-center" style="right: 10px; top: 0; cursor: pointer">' +
              '<b>X</b>' +
            '</span>'+
          '</div>'
        form.append(input)
        let span = $('span.remove')
        span.unbind('click')
        span.click(deleteCost)
      })

      $('span.remove').click(deleteCost)
    })

    function deleteCost () {
      console.log(this)
      let parent = $(this).parents('.position-relative').remove()
    }
  </script>
@endsection
