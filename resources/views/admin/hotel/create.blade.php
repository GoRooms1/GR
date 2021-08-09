@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание отеля</div>
        <form class="row" action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.hotel.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
                @include('admin.parts._images', ['images' => false])
            </div>
        </form>
    </div>
@stop
