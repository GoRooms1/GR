@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование статьи {{ $article->title }}</div>
        <form class="row" action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.articles.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.hotels.show', $article) }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
                @include('admin.parts._images', ['images' => $article->getMedia('images')])
            </div>
        </form>
    </div>
@stop
