@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Новый отзыв для отеля "{{ $hotel->name }}"</div>
        <form class="row" action="{{ route('admin.reviews.store', $hotel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.reviews.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.reviews.index', $hotel) }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
