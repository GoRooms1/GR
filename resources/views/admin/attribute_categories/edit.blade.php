@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="h2">Редактирование Категории атрибута - {{ $c->name }}</div>
    <form class="row" action="{{ route('admin.attribute_categories.update', $c->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="col-8">
        @include('admin.attribute_categories.parts._form')
        <button class="btn btn-success">Обновить</button>
        <a href="{{ route('admin.attribute_categories.index') }}" class="btn btn-warning">Отмена</a>
      </div>
    </form>
  </div>
@stop
