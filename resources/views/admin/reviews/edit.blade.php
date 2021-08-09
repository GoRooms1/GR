@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование отзыва для отеля "{{ $review->hotel->name }}"</div>
        <form class="row" action="{{ route('admin.reviews.update', [$hotel, $review]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-8">
                @include('admin.reviews.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.reviews.index', $hotel) }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
