@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список отзывов для отеля "{{ $hotel->name }}"</div>
                    <a href="{{ route('admin.reviews.create', $hotel) }}" class="btn btn-primary btn-sm">Новый отзыв</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Имя</th>
                            <th>Город</th>
                            <th>Номер</th>
                            <th>Отзыв</th>
                            <th>Ср. Рейтинг</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hotel->reviews AS $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->name }}</td>
                                <td>{{ $review->city }}</td>
                                <td>{{ $review->room }}</td>
                                <td>{{ $review->text }}</td>
                                <td>{{ round($review->ratings->avg('value'), 1) }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.reviews.edit', ['hotel' => $hotel, 'review' => $review]) }}" class="btn btn-success">Обновить</a>
                                        <button type="button"
                                                data-action="{{ route('admin.reviews.destroy', ['hotel' => $hotel, 'review' => $review]) }}"
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
