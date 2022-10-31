@extends('layouts.app')
<?php
/** @var \Domain\Room\Models\Room $room */
?>
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="/"><span itemprop="name">Главная</span></a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{{ route('rooms.index') }}"><span itemprop="name">Номера</span></a>
                    <meta itemprop="position" content="2"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name">{{ $room->name }}</span>
                    <meta itemprop="position" content="3"/>
                </li>
            </ul>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xxl-6">
                    <div class="product-slider-wrapper">
                        <div class="swiper-container product-slider-big">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide product-slide-big">
                                    <img itemprop="photo" class="swiper-lazy"
                                         data-src="{{ asset($hotel->images{0}->path) }}?w=640&h=300&fit=crop&fm=webp"
                                         src="{{ $hotel->images{0}->path }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="product-slider-small-wrapper">
                            <div class="swiper-container product-slider-small"
                                 data-full="{{ asset($image->path) }}?w=640&h=300&fit=crop&fm=webp">
                                <div class="swiper-wrapper">
                                    @foreach($room->images AS $image)
                                        <div class="swiper-slide product-slide-small">
                                            <img class="swiper-lazy" data-src="{{ asset($image->path) }}"
                                                 src="{{ asset('img/pr125x85.jpg') }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-button swiper-button-next product-slider-small-button-next"></div>
                            <div class="swiper-button swiper-button-prev product-slider-small-button-prev"></div>
                        </div>
                        @include('room.parts._rating', ['link' => route('hotels.show', $room->hotel)])
                    </div>
                </div>
                <div class="col-lg-5 col-xxl-6 room-page-info">
                    <h1 class="room-name">Номер: {{ $room->name }}</h1>
                    <div class="room-page-info-in">
                        <p class="room-type">{{ $room->category?->name  }}</p>
                        <p class="room-hotel-name"><a href="{{ route('hotels.show', $room->hotel) }}">Отель
                                “{{ $room->hotel->name }}”</a></p>
                    </div>
                    <p class="room-address">
                        <button type="button" class="room-address-link js-room-address-link"></button>
                        @php
                            $has_district = false;
                            $has_area = false;
                            $url = '/address/';
                            $hotel = $room->hotel;
                        @endphp
                        @if(isset($hotel->address->city) && !is_null($hotel->address->city))
                            @php
                                $url .= \Str::slug($hotel->address->city);
                            @endphp
                            <a href="{{ $url }}">{{ $hotel->address->city }}</a>,
                        @endif
                        @if(isset($hotel->address->city_area) && !is_null($hotel->address->city_area))
                            @php
                                $has_area = true;
                                $url .= '/area-'.\Str::slug($hotel->address->city_area);
                                $areas = explode('-', $hotel->address->city_area);
                                $area = '';
                                foreach ($areas AS $area_prefix)
                                    $area .= mb_substr($area_prefix, 0, 1);
                                $area = mb_strtoupper($area).'АО';
                            @endphp
                            <a href="{{ $url }}">{{ $area }}</a>,
                        @endif
                        @if(isset($hotel->address->city_district) && !is_null($hotel->address->city_district))
                            @php
                                $has_district = true;
                                $url .= '/district-'.\Str::slug($hotel->address->city_district);
                            @endphp
                            <a href="{{ $url }}">{{ $hotel->address->city_district }} район</a>,
                        @endif
                        @if(isset($hotel->address->street) && !is_null($hotel->address->street))
                            {{ $hotel->address->street_with_type ?? $hotel->address->street }}@isset($hotel->address->house)
                                , д.{{ $hotel->address->house }}
                            @endisset
                            @isset($hotel->address->block)
                                , к.{{ $hotel->address->block }}
                            @endisset
                        @endif {{ $hotel->address->comment ? ', '.$hotel->address->comment : '' }}
                    </p>
                    <ul class="room-metro">
                        @php($hotel = $room->hotel)
                        @foreach ($hotel->metros as $metro)
                            <li class="metro">
                                <a href="/address/{{ \Str::slug($hotel->address->city) }}/metro-{{ \Str::slug($metro->name) }}"><img
                                            src="{{ asset('/img/ico-metro-'.$metro->color.'.svg') }}"
                                            alt="">{{ $metro->name }} - {{ $metro->distance }} мин <img class="svg-walk"
                                                                                                        src="{{asset('img/walk.svg')}}"
                                                                                                        alt=""></a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="room-prices">
                        @foreach($room->costs->sortBy('period.type.sort') AS $cost)
                            <li class="room-prices-item">
                                <strong class="room-prices-item-price">{{ $cost->period->type->name }}@if($cost->value !== '0')
                                        - от {{ $cost->value }} руб.
                                    @endif</strong>
                                <span class="room-prices-item-info">{{ $cost->value === '0' ? 'не предоставляется' : $cost->period->info }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="room-btns-bar">
                        <a href="" class="btn btn-orange btn-block" data-href="#book-popup" data-toggle="modal"
                           data-target="#book-popup" data-action="{{ route('booking.room', $room->id) }}"
                           onclick="showFormBookRoom('{{$room->id}}')">Забронировать</a>
                        @if ($room->phone || $room->hotel->phone)
                            <p class="show-tel-wrapper">
                                <button class="btn btn-blue btn-block js-show-tel-btn" type="button">Показать телефон
                                </button>
                                <a href="tel:{{ $room->phone ?? $room->hotel->phone }}"
                                   class="btn btn-blue btn-block tel-link js-tel-link">{{ $room->phone ?? $room->hotel->phone }}</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('web.parts.sections._details')

    <section class="section">
        <div class="container">
            <div>
                <div class="h2 section-title">О номере</div>
            </div>
            <div class="text-section">
                {!! html_entity_decode($room->description) !!}
            </div>
        </div>
    </section>
    {{--
        <section class="section section-pt-none">
            <div class="container">
                <h2 class="section-title orange">Похожие номера</h2>
                @foreach($room->hotel->rooms AS $addRoom)
                    @continue($room->id === $addRoom->id)
                    @include('hotel.parts._room', ['room' => $addRoom])
                @endforeach
                <div class="show-more">
                    <p class="show-more-counter">Загружено: 30 (150)</p>
                    <button class="show-more-btn" type="button">Загрузить еще</button>
                </div>
            </div>
        </section>{{----}}
@stop
