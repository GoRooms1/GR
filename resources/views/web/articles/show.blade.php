@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="container">
        <ul itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="/"><span itemprop="name">Главная</span></a>
                <meta itemprop="position" content="1" />
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="/blog"><span itemprop="name">Статьи</span></a>
                <meta itemprop="position" content="2" />
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">{{ $article->title }}</span>
                <meta itemprop="position" content="3" />
            </li>
        </ul>
    </div>
</div>
<section class="section">
    <div class="container">
        <h1 class="section-title">{{ $article->title }}</h1>
        <div class="text-section">
            {!! html_entity_decode($article->content) !!}
        </div>
    </div>
</section>
<div itemscope itemtype="https://schema.org/Article">
    <link itemprop="mainEntityOfPage" href="https://gorooms.ru/" />
    <link itemprop="image" href="image">
    <meta itemprop="headline name" content="{{ $article->title }}">
    <meta itemprop="description" content="{{ $article->content }}">
    <meta itemprop="author" content="{{ App\Settings::option('address') }}">
    <meta itemprop="datePublished" datetime="{{ $article->created_at->format('Y-m-d') }}" content="{{ $article->created_at->format('Y-m-d') }}">
    <meta itemprop="dateModified" datetime="{{ $article->updated_at->format('Y-m-d') }}" content="{{ $article->updated_at->format('Y-m-d') }}">
    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <img itemprop="url image" src="images/logo.png" alt="{{ $article->title }}" title="{{ $article->title }}" style="display:none;" />
        </div>
        <meta itemprop="name" content="gorooms.ru">
        <meta itemprop="telephone" content="{{ App\Settings::option('phone') }}">
        <meta itemprop="address" content="Россия">
    </div>
    <p>{{ $article->title }}</p>
    <span itemprop="articleBody">{!! $article->content !!}</span>
</div>

@endsection