@extends('layouts.app')

@push('header')
    {!! $page->header !!}
@endpush

@push('footer')
    {!! $page->footer !!}
@endpush

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemid="http://schema.org/breadcrumb" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a id="breadcrumbs" itemscope itemtype="http://schema.org/Thing" itemprop="item" href="/"><span itemprop="name">Главная</span></a>
                    <meta itemprop="position" content="1"/>
                </li>
                @if ($page->title)
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">{{ $page->title }}</span>
                <meta itemprop="position" content="2"/>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <section class="section">
        <div class="container">
            <h1 class="section-title">{{ $page->title }}</h1>
            <div class="text-section">
                {!! str_replace('--csrf', csrf_field(), html_entity_decode($page->content)) !!}
            </div>
        </div>
    </section>
@endsection
