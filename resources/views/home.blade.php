@extends('layouts.app')

@section('content')
    @include('web.parts.sections._search')
    {{-- Популярные отели --}}
    <section class="home-section home-section-pt-lg">
        <div class="container">
            <div class="h2 section-title">
                {!! html_entity_decode(Settings::header('seo_/')) !!}
            </div>
            <div class="row row-sm">
                @foreach ($hotels as $hotel)
                    @include('hotel._popular')
                @endforeach
            </div>
        </div>
    </section>
    {{-- /Популярные отели --}}
    {{-- Горячее предложение --}}
    <section class="home-section">
        <div class="container container-more">
            <div class="h2 section-title orange"><img src="{{ asset('img/ico-fire-orange.svg') }}" alt="" width="22" height="30">Горящие
                предложения</div>
            <div>
                @foreach($rooms AS $room)
                    @include('room._hot')
                @endforeach
            </div>
            <a href="{{ route('rooms.hot') }}" class="more-btn btn btn-orange btn-fire">Все предложения</a>
        </div>
    </section>
    {{-- /Горячее предложение --}}
    {{-- Статьи --}}
    <section class="home-section blog">
        <div class="container container-more">
            <div class="h2 section-title section-title-mb-lg">Статьи</div>
            <div class="row">
                @foreach($articles AS $article)
                    @include('web.articles.parts._article')
                @endforeach
            </div>
            <a href="{{ route('articles.index') }}" class="more-btn btn btn-blue">Все статьи</a>
        </div>
    </section>
    {{-- /Статьи --}}

    <section class="about">
        <div class="container">
            <article class="about-content">
                <div class="text-section about-text">
                    {!! html_entity_decode(Settings::option('seo_/')) !!}
                </div>
            </article>
        </div>
    </section>
@endsection
