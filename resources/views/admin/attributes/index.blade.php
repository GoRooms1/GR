@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список атрибутов</div>
          <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary btn-sm">Новый атрибут</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.attributes.index') }}" id="filter" method="GET">
          <div class="row mb-2">
            <div class="col-auto">
              <button
                id="for-hotel"
                class="btn btn-primary {{ Request::exists('hotel') ? 'disabled' : null }}"
              >
                Для отелей
              </button>
            </div>
            <div class="col-auto">
              <button
                id="for-room"
                class="btn btn-primary {{ Request::exists('room') ? 'disabled' : null }}"
              >
                Для номеров
              </button>
            </div>
            <div class="col-auto">
              <button
                id="for-all"
                class="btn btn-primary {{ !Request::exists('room') && !Request::exists('hotel') ? 'disabled' : null }}"
              >
                Для всех
              </button>
            </div>
            <div class="col-auto mr-auto">
              <select name="category" class="form-control" id="category">
                <option value="">Категория</option>
                @foreach($categories as $c)
                  <option value="{{ $c->id }}" {{ Request::exists('category') ? (int)Request::get('category') === $c->id ? 'selected' : '' : '' }}>{{ $c->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-auto ml-auto">
              <a
                href="{{ route('admin.attributes.index') }}"
                class="btn btn-primary"
              >
                Сборс фильтра
              </a>
            </div>
          </div>
        </form>
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Наименование</th>
              <th>Категория</th>
              <th>Для</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($attributes AS $attribute)
              <tr>
                <td>{{ $attribute->id }}</td>
                <td>{{ $attribute->name }}</td>
                <td>{{ $attribute->relationCategory->name }}</td>
                <td>{{ \App\Models\Attribute::MODELS_TRANSLATE[$attribute->model] }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.attributes.edit', $attribute) }}" class="btn btn-success">Изменить</a>
                    <button type="button" data-action="{{ route('admin.attributes.destroy', $attribute) }}"
                            class="btn btn-danger js-delete">Удалить
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <th colspan="5" class="text-center">Нет атрибутов</th>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('select[name=category]').change(function () {
        let id = $(this).val();
        let forAttr = "{{ Request::exists('hotel') ? 'hotel' : (Request::exists('room') ? 'room' : 'null') }}"
        if (forAttr !== 'null') {
          let input = $("<input>").attr("type", "hidden").attr("name", forAttr).val(1);
          $('#filter').append(input)
        }
        $('#filter').submit();
      })

      $('#for-hotel').click(() => {
        let input = $("<input>").attr("type", "hidden").attr("name", 'hotel').val(1);
        $('#filter').append(input)
        $('#filter').submit();
      })
      $('#for-room').click(() => {
        let input = $("<input>").attr("type", "hidden").attr("name", 'room').val(1);
        $('#filter').append(input)
        $('#filter').submit();
      })
      $('#for-all').click(() => {
        $('#filter').submit();
      })
    })
  </script>
@endsection
