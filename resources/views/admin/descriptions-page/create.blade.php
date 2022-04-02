@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание описание страницы</div>
        <form class="row" action="{{ route('admin.descriptions-page.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.descriptions-page.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.descriptions-page.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
