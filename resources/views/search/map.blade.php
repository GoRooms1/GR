@extends('layouts.app')

@section('content')
  @widget('filter')

    <div class="breadcrumbs">
      <div class="container">
        <ul itemscope itemtype="https://schema.org/BreadcrumbList">
          <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="/"> <span itemprop="name">Главная</span></a>
            <meta itemprop="position" content="1"/>
          </li>
          <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name">¬ Результаты поиска</span>
            <meta itemprop="position" content="2"/>
          </li>
        </ul>
      </div>
    </div>

  <section class="section">
    <div class="container">
      <h1 class="section-title">Заголовок тут</h1>
      <div class="map-search-wrapper">
        <div id="map" style="width: 100%; height: 600px;"></div>
      </div>
    </div>
  </section>

  <section class="section section-pt-none">
    <div class="container">
      <div class="h2 section-title orange">Популярные отели</div>
      <div class="row row-sm">
{{--        @foreach ($hotels as $hotel)--}}
{{--          @continue(is_null($hotel) || !$hotel->is_popular)--}}
{{--          @include('hotel._popular')--}}
{{--        @endforeach--}}
      </div>
    </div>

{{--    @if(!is_null(@$pageDescription))--}}
{{--      <div class="container" style="margin-top: 20px;">--}}
{{--        {!! html_entity_decode(@$pageDescription->description) !!}--}}

{{--      </div>--}}

{{--    @endif--}}
  </section>

<script>
  ymaps.ready(init);
  function init() {
    let myMap = new ymaps.Map("map", {
      center: [{{ $search_address['lat'] }}, {{ $search_address['lon'] }}],
      zoom: 9
    });
    @foreach($hotels AS $hotel)
    @if($hotel->address)
      myMap.geoObjects.add(new ymaps.Placemark([{{ $hotel->address->geo_lat }}, {{ $hotel->address->geo_lon }}], {
        balloonContentBody: '<div class="map-popup-in">\n' +
          '                        <img src="{{ asset($hotel->image->path) }}" alt="" class="map-popup-img">\n' +
          '                        <div class="map-popup-content">\n' +
          '                            <p class="map-popup-title"><a href="{{ route('hotels.show', $hotel) }}">Отель “{{ $hotel->name }}”</a></p>\n' +
          '                            <a href="{{ route('hotels.show', $hotel) }}" class="btn btn-blue map-popup-btn">Посмотреть номера</a>\n' +
          '                        </div>\n' +
          '                    </div>',
        hintContent: "Отель «{{ $hotel->name }}»"
      }));
    @endif
    @endforeach
  }
</script>

@stop