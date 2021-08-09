@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Обновление типа цен </div>
        <form class="row" action="{{ route('admin.cost_types.update', $costType) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.cost_types.parts._form')
                <button class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.cost_types.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
            </div>
        </form>
    </div>
@stop
