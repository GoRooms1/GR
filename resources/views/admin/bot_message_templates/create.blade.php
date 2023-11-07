@extends('layouts.admin')

@section('content')
    <div class="container">       
        <div class="h2">Создание шаблона</div>
        <form class="row" action="{{ route('admin.bot_message_templates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-8">
                @include('admin.bot_message_templates.parts._form')
                <button class="btn btn-success" type="submit">Создать</button>
                <a href="{{ route('admin.bot_message_templates.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">    
                @include('admin.parts._images-single', [])  
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror              
            </div>
        </form>
    </div>
@stop
