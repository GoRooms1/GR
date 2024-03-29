@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список отелей</div>
          <a href="{{ route('admin.hotels.create') }}" class="btn btn-primary btn-sm">Новый отель</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <form action="{{ route('admin.hotels.index') }}" method="get">
              <div class="row">
                <div class="col-8 col-md-6 col-lg-4">
                  <input type="text" name="q" value="{{ old('q', $q) }}" placeholder="Поиск" class="form-control mb-2">
                </div>
                <div class="col-auto">
                  <button  type="submit" class="btn btn-primary">Найти</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Изображение</th>
              <th>Наименование</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hotels AS $hotel)
              <tr>
                <td>{{ $hotel->id }}</td>
                <td>
                  <img src="{{ asset($hotel->getFirstMediaUrl('images', 'card')) }}" alt="" class="img-fluid"
                       style="max-width: 100px">
                </td>
                @if ($hotel->slug != null && $hotel->slug != '')
                <td>                  
                  <a href="{{ route('admin.hotels.show', $hotel) }}"
                     class="{{ $hotel->description === null ? 'text-danger' : '' }}">{{ $hotel->name }}</a>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-success">Изменить</a>
                    <a href="{{ route('admin.rooms.create', $hotel) }}" class="btn btn-primary">Создать номер</a>
                    <button type="button" data-action="{{ route('admin.hotels.destroy', $hotel) }}"
                            class="btn btn-danger js-delete">Удалить
                    </button>
                  </div>
                </td>
                @endif
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <div class="row justify-content-center">
          <div class="col-auto">
            {{ $hotels->appends(['q' => $q])->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
