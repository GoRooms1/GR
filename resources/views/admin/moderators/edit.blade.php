@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="h2">Обновление модератора </div>
    <form class="row" action="{{ route('admin.moderators.update', $user) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="col-8">
        @include('admin.moderators._form')
        <button class="btn btn-success">Обновить</button>
        <a href="{{ route('admin.moderators.index') }}" class="btn btn-warning">Отмена</a>
      </div>
      <div class="col-4">
      </div>
    </form>
  </div>
@stop
