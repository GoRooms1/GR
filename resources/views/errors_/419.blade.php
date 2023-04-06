@extends('layouts.app')

@push('wrapper-class', 'error-page-wrapper')

@section('content')
    <div class="error-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="error-title">419</h1>
                </div>
                <div class="col-lg-6 error-info-wrapper">
                    <div class="error-info">
                        <div class="h2 error-info-title">Страница истекла</div>
                        <p>Время жизни страницы истекло, попробуйте вернётся обратно, обновить страницу и повторить отправить запрос</p>
                        <p>Вернуться <a href="{{ url()->previous() }}" class="error-info-link">назад!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
