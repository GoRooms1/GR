@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание страницы</div>
        <form class="row" action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.pages.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
