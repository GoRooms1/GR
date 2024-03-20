@extends('layouts.admin')
<?php
        /** @var \App\Models\Hotel $hotel */
?>
@section('content')
    <div class="container">
        <div class="h2 display-4 text-center">{{ $hotel->name }}</div>
        <div class="row">
            <div class="col-7">
                @if($hotel->rooms()->count())
                    <div class="h4">Номера отеля</div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Изображение</th>
                                <th>Название</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($hotel->rooms as $room)
                                <tr>
                                    <td><img src="{{ asset($room->getFirstMediaUrl('images', 'card')) }}" class="img-fluid img-thumbnail"
                                             style="max-width: 100px"></td>
                                    <td>{{ $room->name }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-success">Изменить</a>
                                            <button type="button" data-action="{{ route('admin.rooms.destroy', $room) }}"
                                                    class="btn btn-danger js-delete">Удалить
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="col-5">
                <img class="img-fluid" src="{{ asset($hotel->getFirstMediaUrl('images', 'card')) }}" alt="">
                <div class="pt-3">
                    <div class="h4">Категории</div>
                    @if($hotel->categories()->count())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Наименование</th>
                                    <th>Описание</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($hotel->categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.categories.edit', ['hotel' => $hotel, 'category' => $category]) }}" class="btn btn-primary">Изменить</a>
                                                <button data-action="{{ route('admin.categories.destroy', ['hotel' => $hotel, 'category' => $category]) }}" class="btn btn-danger js-delete">Удалить</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        Категорий нет
                    @endif
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.categories.create', $hotel) }}" class="btn btn-primary">Создать категорию</a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="pt-5">
                    <div class="h4">Рейтинг</div>
                    @foreach(\Domain\Review\Models::orderBy('sort')->get() AS $category)
                        <dl class="d-flex justify-content-between border-bottom">
                            <dt><strong>{{ $category->name }} :</strong></dt>
                            <dd>{{ round($hotel->ratings()->where('category_id', $category->id)->avg('value'), 1) }}</dd>
                        </dl>
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <div class="btn-group">
                    <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-warning">Редактировать</a>
                    <a href="{{ route('admin.rooms.create', $hotel) }}" class="btn btn-primary">Добавить номер</a>
                    <a href="{{ route('admin.categories.create', $hotel) }}" class="btn btn-primary">Добавить категорию</a>
                    <a href="{{ route('admin.reviews.index', $hotel) }}" class="btn btn-info">Список отзывов</a>
                    <button type="button" data-action="{{ route('admin.hotels.destroy', $hotel) }}" class="btn btn-danger js-delete">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop
