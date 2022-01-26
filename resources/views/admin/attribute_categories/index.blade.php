@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список категорий атрибутов</div>
          <a href="{{ route('admin.attribute_categories.create') }}" class="btn btn-primary btn-sm">Новая категория</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Наименование</th>
              <th>Кол-во атрибутов</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($c_attrs AS $c)
              <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->name }}</td>
                <td>{{ $c->attributes()->count() }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.attribute_categories.edit', $c) }}" class="btn btn-success">Изменить</a>
                    <button type="button" data-action="{{ route('admin.attribute_categories.destroy', $c) }}" class="btn btn-danger js-delete">Удалить</button>
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
