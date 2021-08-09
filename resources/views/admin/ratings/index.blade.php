@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список категорий</div>
                    <a href="{{ route('admin.ratings.create') }}" class="btn btn-primary btn-sm">Новая категория</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Наименование</th>
                            <th>Сортировка</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories AS $category)

                            <tr>
                                @csrf
                                @method('PUT')
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->sort }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.ratings.edit', $category) }}" class="btn btn-success">Обновить</a>
                                        <button type="button"
                                                data-action="{{ route('admin.ratings.destroy', $category) }}"
                                                class="btn btn-danger js-delete">Удалить
                                        </button>
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
