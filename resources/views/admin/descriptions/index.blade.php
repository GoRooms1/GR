@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список страниц</div>
                    <a href="{{ route('admin.descriptions.create') }}" class="btn btn-primary btn-sm">Новая страница</a>
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
                        @foreach($descriptions AS $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>
                                    {{ $page->title }}
                                </td>
                                <td>
                                    {{ $page->url }}
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.descriptions.edit', $page) }}" class="btn btn-success">Изменить</a>
                                        <button type="button" data-action="{{ route('admin.descriptions.destroy', $page) }}" class="btn btn-danger js-delete">Удалить</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $descriptions->links() }}
            </div>
        </div>
    </div>
@stop
