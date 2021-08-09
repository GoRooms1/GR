@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование категории "{{ $rating->name }}"</div>
        <form class="row" action="{{ route('admin.ratings.update', $rating) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-8">
                @include('admin.ratings.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.ratings.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
