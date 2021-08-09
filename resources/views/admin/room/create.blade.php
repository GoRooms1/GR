@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание номера для отеля "{{ $hotel->name }}"</div>
        <form class="row" action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                @include('admin.room.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
                @include('admin.parts._images', ['images' => false])
            </div>
        </form>
    </div>
@stop
