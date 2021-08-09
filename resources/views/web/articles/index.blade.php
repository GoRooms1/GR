@extends('layouts.app')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul itemscope itemtype="https://schema.org/BreadcrumbList">
                <li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="/"><span itemprop="name">Главная</span></a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name"> Статьи</span>
                <meta itemprop="position" content="2"/>
                </li>
            </ul>
        </div>
    </div>
    <section class="section">
        <div class="container">
            <h1 class="section-title">Статьи</h1>
            <div class="row">
                @foreach ($articles as $article)
                    @include('web.articles.parts._article')
                @endforeach
            </div>
            {{ $articles->links('web.parts.pagination') }}
        </div>
    </section>
@endsection
