@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование категории "{{ $category->name }}" отеля "{{ $hotel->name }}"</div>
        <form class="row" action="{{ route('admin.categories.update', ['hotel' => $hotel, 'category' => $category]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                @include('admin.category.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.hotels.show', $hotel) }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
