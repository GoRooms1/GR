@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Изменение отеля "{{ $hotel->name }}"</div>
        <form class="row" action="{{ route('admin.hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.hotel.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.hotels.show', $hotel) }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
                @include('admin.parts._images', ['images' => $hotel->getMedia('images'), 'autoload' => true, 'model' => 'Hotel', 'model_id' => $hotel->id])
            </div>
        </form>
    </div>
@stop
