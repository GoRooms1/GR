@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование страницы "{{ $page->title }}"</div>
        <form class="row" action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.pages.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
