@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование описания страницы "{{ $description->title }}"</div>
        <form class="row" action="{{ route('admin.descriptions-page.update', $description) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.descriptions-page.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.descriptions-page.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
