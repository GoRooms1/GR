@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование номера "{{ $room->name }}" для отеля "{{ $room->hotel->name }}"</div>
        <form class="row" action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="col-8">
                <input type="hidden" name="hotel_id" value="{{ $room->hotel->id }}">
                @include('admin.room.parts._form', ['hotel' => $room->hotel])
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
                @include('admin.parts._images', ['images' => $room->images, 'autoload' => true, 'model' => 'Room', 'model_id' => $room->id])
            </div>
        </form>
    </div>
@stop
