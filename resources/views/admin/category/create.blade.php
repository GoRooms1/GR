@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание категории для номеров для отеля "{{ $hotel->name }}"</div>
        <form class="row" action="{{ route('admin.categories.store', $hotel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                @include('admin.category.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.hotels.show', $hotel) }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
