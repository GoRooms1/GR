@extends('layouts.app')

@push('wrapper-class', 'error-page-wrapper')

@section('content')
    <div class="error-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="error-title">503</h1>
                </div>
                <div class="col-lg-6 error-info-wrapper">
                    <div class="error-info">
                        <div  class="h2 error-info-title">Сервис не доступен!</div>
                        <p>{{ __($exception->getMessage() ?: 'Service Unavailable') }}</p>
                        <p>Перейдите на <a href="/" class="error-info-link">главную страницу!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
