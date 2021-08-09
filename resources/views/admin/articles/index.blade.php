@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список статей</div>
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">Новая статья</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Картинка</th>
                            <th>Наименование</th>
                            <th>Краткое описание</th>
                            <th>Ссылка</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($articles AS $article)
                            <tr>
                                <td>{{ $article->id }}</td>
                                <td><img src="{{ asset($article->image->path) }}?w=100&h=100&fit=crop&fm=webp" alt="" class="img-fluid" style="max-width: 100px"></td>
                                <td>
                                    <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                                </td>
                                <td>{{ $article->notice }}</td>
                                <td>
                                    <a href="{{ route('articles.show', $article) }}">{{ $article->slug }}</a>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-success">Изменить</a>
                                        <button type="button" data-action="{{ route('admin.articles.destroy', $article) }}" class="btn btn-danger js-delete">Удалить</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
