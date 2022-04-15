@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список Обьединений</div>
          <a href="{{ route('admin.united_cities.create') }}" class="btn btn-primary btn-sm">Новое Обьединение</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Наименование</th>
              <th>Города</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($unitedCities AS $unitedCity)
              <tr>
                <td>{{ $unitedCity->id }}</td>
                <td><a href="{{ route('admin.united_cities.edit', $unitedCity) }}">{{ $unitedCity->name }}</a></td>
                <td>{{ implode(', ', $unitedCity->united()->toArray()) }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.united_cities.edit', $unitedCity) }}" class="btn btn-success">Изменить</a>
                    <button type="button" data-action="{{ route('admin.united_cities.destroy', $unitedCity) }}" class="btn btn-danger js-delete">Удалить</button>
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
