@extends('layouts.admin')

@section('content')
    <div class="container">       
        <div class="h2">Создание баннера</div>
        <form class="row" action="{{ route('admin.ad_banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.ad_banners.parts._form')
                <button class="btn btn-success" type="submit">Создать</button>
                <a href="{{ route('admin.ad_banners.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
            </div>
        </form>
    </div>
@stop
