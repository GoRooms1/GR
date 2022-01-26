@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="row mb-2">
      <div class="col-auto">
        <a href="{{ route('admin.attribute_categories.index') }}" class="btn btn-primary">Назад</a>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список атрибутов для категории {{ $c->name }}</div>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-auto">
            <a href="{{ route('admin.attribute_categories.show', $c) }}?hotel=1"
               class="btn btn-primary {{ Request::exists('hotel') ? 'disabled' : null }}"
            >
              Для отелей
            </a>
          </div>
          <div class="col-auto">
            <a href="{{ route('admin.attribute_categories.show', $c) }}?room=1"
               class="btn btn-primary {{ Request::exists('room') ? 'disabled' : null }}"
            >
              Для номеров
            </a>
          </div>

          <div class="col-auto">
            <a href="{{ route('admin.attribute_categories.show', $c) }}"
               class="btn btn-primary {{ !Request::exists('room') && !Request::exists('hotel') ? 'disabled' : null }}"
            >
              Для всех
            </a>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Наименование</th>
              <th>Для</th>
              <th>Описание</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attributes AS $attr)
              <tr>
                <td>{{ $attr->id }}</td>
                <td>{{ $attr->name }}</td>
                <td>{{ \App\Models\Attribute::MODELS_TRANSLATE[$attr->model] }}</td>
                <td>{{ $attr->description }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.attributes.edit', $attr) }}" class="btn btn-success">Изменить</a>
                    <button type="button" data-action="{{ route('admin.attributes.destroy', $attr) }}" class="btn btn-danger js-delete">Удалить</button>
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@stop
