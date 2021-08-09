@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование SEO текста для "{{ $page->option }}"</div>
        <form class="row" action="{{ route('admin.settings.seo.update', $page) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                <div class="form-group">
                    <label for="content">Описание</label>
                    <textarea name="value" id="content" class="form-control editor ">{{ old('content') ?? @$page->value ?? '' }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.settings.seo') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
