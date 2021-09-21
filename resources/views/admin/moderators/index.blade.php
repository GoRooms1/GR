@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список модераторов</div>
          <a href="{{ route('admin.moderators.create') }}" class="btn btn-primary btn-sm">Новый модератора</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Имя</th>
              <th>E-mail</th>
              <th>Телефон</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.moderators.edit', $user) }}" class="btn btn-primary">Изменить</a>
                    <button data-action="{{ route('admin.moderators.destroy', $user) }}" class="btn btn-danger js-delete">Удалить</button>
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