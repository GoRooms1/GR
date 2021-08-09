@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список страниц</div>
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">Новая страница</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Наименование</th>
                            <th>Ссылка</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages AS $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>
                                    <a href="{{ route('pages.show', $page) }}">{{ $page->title }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('pages.show', $page) }}">{{ $page->slug }}</a>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-success">Изменить</a>
                                        <button type="button" data-action="{{ route('admin.pages.destroy', $page) }}" class="btn btn-danger js-delete">Удалить</button>
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
