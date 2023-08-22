@extends('layouts.admin')

@section('content')
    <div class="container">        
        <div class="h2">Редактирование баннера</div>
        <form class="row" action="{{ route('admin.ad_banners.update', $ad_banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.ad_banners.parts._form')
                <button class="btn btn-success">Сохранить</button>
                <a href="{{ route('admin.ad_banners.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">
                @include('admin.parts._images', ['images' => $ad_banner->getMedia('images'), 'autoload' => true, 'model' => 'AdBanner', 'model_id' => $ad_banner->id])
            </div>
        </form>        
    </div>
@stop
