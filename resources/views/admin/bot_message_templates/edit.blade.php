@extends('layouts.admin')

@section('content')
    <div class="container">        
        <div class="h2">Редактирование шаблона</div>
        <form class="row" action="{{ route('admin.bot_message_templates.update', $botMessageTemplate) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-8">
                @include('admin.bot_message_templates.parts._form')
                <button class="btn btn-success">Сохранить</button>
                <a href="{{ route('admin.bot_message_templates.index') }}" class="btn btn-warning">Отмена</a>
            </div>
            <div class="col-4">    
                @include('admin.parts._images-single', ['image' => $botMessageTemplate->getFirstMedia('images')])  
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror              
            </div>
        </form>
        @include('admin.bot_message_templates.parts._actions')
    </div>
@stop
