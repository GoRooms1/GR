@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="h2">Создание Категории атрибута</div>
    <form class="row" action="{{ route('admin.attribute_categories.store') }}" method="POST">
      @csrf
      <div class="col-8">
        @include('admin.attribute_categories.parts._form')
        <button class="btn btn-success">Создать</button>
        <a href="{{ route('admin.attribute_categories.index') }}" class="btn btn-warning">Отмена</a>
      </div>
    </form>
  </div>
@stop
