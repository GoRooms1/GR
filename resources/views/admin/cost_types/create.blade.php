@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание типа цен</div>
        <form class="row" action="{{ route('admin.cost_types.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.cost_types.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.cost_types.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
            </div>
        </form>
    </div>
@stop
