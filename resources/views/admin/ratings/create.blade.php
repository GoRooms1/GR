@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание категории</div>
        <form class="row" action="{{ route('admin.ratings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.ratings.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.ratings.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
