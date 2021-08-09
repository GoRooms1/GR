@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование типа размещения</div>
        <form class="row" action="{{ route('admin.hotel_types.update', $hotelType) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.hotel_types.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.hotel_types.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
