@extends('layouts.app')

@push('wrapper-class', 'error-page-wrapper')

@section('content')
    <div class="error-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="error-title">429</h1>
                </div>
                <div class="col-lg-6 error-info-wrapper">
                    <div class="error-info">
                        <div class=" h2error-info-title">Слишком много запросов!</div>
                        <p>Вами отправлено слишком много запросов, попробуйте повторить отправку поздней</p>
                        <p>Вернуться <a href="{{ url()->previous() }}" class="error-info-link">назад!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
