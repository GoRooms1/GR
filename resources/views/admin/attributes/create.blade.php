@extends('layouts.admin')

@section('content')
    @php($created = true)
    <div class="container">
        <div class="h2">Создание атрибута</div>
        <form class="row" action="{{ route('admin.attributes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.attributes.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
            </div>
        </form>
    </div>
@stop
