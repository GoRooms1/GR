@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="h2">Создание модератора</div>
    <form class="row" action="{{ route('admin.moderators.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="col-8">
        @include('admin.moderators._form')
        <button class="btn btn-success">Создать</button>
        <a href="{{ route('admin.moderators.index') }}" class="btn btn-warning">Отмена</a>
      </div>
      <div class="col-4">
      </div>
    </form>
  </div>
@stop
