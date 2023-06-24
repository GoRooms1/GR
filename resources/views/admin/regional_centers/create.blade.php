@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h2">Создание регионального центра</div>
        <form class="row" action="{{ route('admin.regional_centers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.regional_centers.parts._form')
                <button class="btn btn-success">Создать</button>
                <a href="{{ route('admin.regional_centers.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
            </div>
        </form>
    </div>
@stop
