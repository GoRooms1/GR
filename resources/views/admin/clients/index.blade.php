@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список клиентов</div>         
        </div>
      </div>      
      <div class="card-body">
        <form action="{{ route('admin.clients.index') }}" method="get">
          <div class="row">
            <div class="col-8 col-md-6 col-lg-4">
              <input type="text" name="search_name" value="{{request()->input('search_name')}}" placeholder="Имя" class="form-control mb-2">
            </div>
            <div class="col-8 col-md-6 col-lg-4">
              <input type="text" name="search_phone" value="{{request()->input('search_phone')}}" placeholder="Телефон" class="form-control mb-2">
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">Найти</button>
            </div>
          </div>
        </form>
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Имя</th>
              <th>E-mail</th>
              <th>Телефон</th>
              <th>Пол</th>
              <th>Почта подтверждена</th>
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
                  @switch($user->gender) 
                    @case('m') 
                      {{ 'муж.' }}
                      @break 
                    @case('f')
                      {{ 'жен.' }} 
                      @break
                  @endswitch
                </td>
                <td>{{ $user->email_verified_at !== null ? 'Да' : 'Нет'}}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>        
      </div>
      <div class="row justify-content-center">
        <div class="col-auto">
          {{ $users->appends([
            'search_name' => request()->input('search_name'),
            'search_phone' => request()->input('search_phone'),
            ])->links()
          }}
        </div>
      </div>     
    </div>    
  </div>
@stop