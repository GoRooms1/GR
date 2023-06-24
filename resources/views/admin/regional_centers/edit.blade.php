@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Редактирование регионального центра</div>
        <form class="row" action="{{ route('admin.regional_centers.update', $regionalCenter) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.regional_centers.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.regional_centers.index') }}" class="btn btn-warning">Отмена</a>
            </div>
        </form>
    </div>
@stop
