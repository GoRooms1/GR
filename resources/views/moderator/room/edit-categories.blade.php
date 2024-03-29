@extends('moderator.layouts.app')

@section('content')
  <input type="hidden" name="category.update" value="{{ route('moderator.category.update') }}">
  <input type="hidden" name="category.create" value="{{ route('moderator.category.create') }}">

  <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
  <section class="part">
    <div class="container">
      <div class="row demonstration">
        <div class="col-12">
          <p class="text">Демонстрация категорий отеля с квотами комнат</p>
        </div>

      </div>
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center category">
            <h2 class="title">Категории номеров</h2>
{{--            <button class="category__add">--}}
{{--              <span>Добавить категорию</span>--}}
{{--              <span class="plus">+</span>--}}
{{--            </button>--}}
          </div>
          <ul class="categories">

            @foreach($hotel->categories as $category)
              <li class="categories__item" data-id="{{ $category->id }}">
                <div class="categories__first">
                  <span class="categories__name categories__hide">{{ $category->name }}</span>
                  <input type="text" class="field field_hidden field_hidden-room" placeholder="Введите категорию">
                </div>
                <div class="categories__second">
                  <span class="categories__quote categories__hide">{{ $category->value }}</span>
                  <input type="text" class="field field_hidden field_hidden-quote" placeholder="Квота">
                </div>

                <div class="categories__control">
                  <button class="categories__custom change-category" id="">
                    <img class="category-change" src="{{ asset('img/lk/pen.png') }}" alt="">
                    <img class="category-good" src="{{ asset('img/lk/check.png') }}" alt="">
                  </button>
{{--                  <button class="categories__custom categories__custom_2 categoryRemove" id="">--}}
{{--                    <img class="category-bin" src="{{ asset('img/lk/bin.png') }}" alt="">--}}
{{--                  </button>--}}
                </div>
              </li>
            @endforeach

            <li class="categories__item">
              <div class="categories__first">
                <span class="categories__name categories__hide"></span>
                <input type="text" class="field field_hidden field_hidden-room" placeholder="Введите категорию">
              </div>

              <div class="categories__second">
                <span class="categories__quote categories__hide"></span>
                <input type="text" class="field field_hidden field_hidden-quote" placeholder="Квота">
              </div>

              <div class="categories__control">
                <button class="categories__custom change-category" id="">
                  <img class="category-change" src="{{ asset('img/lk/pen.png') }}" alt="">
                  <img class="category-good" src="{{ asset('img/lk/check.png') }}" alt="">
                </button>
                <button class="categories__custom categories__custom_2 categoryRemove" id="">
                  <img class="category-bin" src="{{ asset('img/lk/bin.png') }}" alt="">
                </button>
              </div>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="part category-list">
    <div class="container">

      <div id="rooms">
        @foreach($rooms as $room)
          <div class="shadow shadow-complete" data-id="{{ $room->id }}" data-moderate="moderate" data-category-id="{{ $room->category->id ?? 'null' }}" data-attributes="{{ $room->attrs->pluck('id')->implode(',') }}">
            <input type="hidden"
                   name="url"
                   value="{{ route('moderator.room.update') }}">
            <input type="hidden"
                   name="url-delete"
                   value="{{ route('moderator.room.delete', $room->id) }}">
            <input type="hidden"
                   name="attributes-get"
                   value="{{ route('moderator.room.attr.get', $room->id) }}">
            <input type="hidden"
                   name="attributes-put"
                   value="{{ route('moderator.room.attr.put', $room->id) }}">

            <input type="hidden"
                   name="room-published"
                   value="{{ route('moderator.room.published', $room->id) }}">

            <div class="row row__head {{ !$room->moderate ? 'row__head_blue' : '' }}">
              <div class="col-6">
                {{--    Название категории    --}}
                <p class="head-text head-text_bold"> {{ $room->category->name ?? 'Категория' }}</p>
              </div>

              <div class="col-3">
                {{--        Сколько мест --}}
                <p class="head-text">Квота <span> {{ $room->category->value ?? 0 }} </span></p>
              </div>
              <div class="col-1">
                <button class="bg-transparent arrow-up border-0 text-white">
                  <i class="fa fa-arrow-up p-3"></i>
                </button>
              </div>
              <div class="col-1">
                <button class="bg-transparent arrow-down border-0 text-white">
                  <i class="fa fa-arrow-down p-3"></i>
                </button>
              </div>
              <div class="col-1 text-right">
                @if($room->moderate)
                  <button style="font-size: 30px" class="room-upload text-white">
                    <i class="fa fa-upload"></i>
                  </button>
                @endif
              </div>
{{--              <div class="col-1 text-right">--}}
{{--                --}}{{--        Удалить комнату --}}
{{--                <button class="quote__remove">--}}
{{--                  <i class="fa fa-trash"></i>--}}
{{--                </button>--}}
{{--              </div>--}}
            </div>

            {{--          Status--}}
            @if($room->moderate)
              <div class="row">
                <div class="col-12">
                  <p class="text quote__status quote__status_red">Проверка модератором</p>
                </div>
              </div>
            @else
              <div class="row">
                <div class="col-12">
                  <p class="text quote__status quote__status_blue">Опубликовано</p>
                </div>
              </div>

            @endif

            <div class="row caption-details">
              <div class="col-12">
                <div class="d-flex align-items-center">
                  <div class="select category-select">
                    <input type="hidden" name="category_id" value="{{ $room->category->id ?? '' }}">
                    <div class="select__top">
                      <span class="select__current">{{ $room->category->name ?? 'Категория' }}</span>
                    </div>
                  </div>
                  <div class="quote-text d-flex align-items-center">
                    <p class="quote-text__main">Квота</p>
                    <p class="quote-text__number">{{ $room->category->value ?? '0' }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mt-3">
                <ul class="uploud visualizacao all-slides">
                  @foreach($room->getMedia('images') as $image)
                    <li class="uploud__item"
                        data-image-id="{{ $image->id }}"
                        data-image-delete="{{ route('moderator.image.delete', '') }}"
                        data-image-moderate="{{ route('moderator.image.moderate', '') }}"
                    >
                      <div class="uploud__thumb uploud__thumb_admin"
                           style="background-image: url('{{ $image->getUrl() }}'); background-size: cover;"
                           id="upload{{$image->id}}">
                        <span class="upload_number">№ {{ $loop->index + 1 }}</span>
                        @if($image->getCustomProperty('moderate'))
                          <div class="moderate">
                            <img src="{{ asset('img/lk/arrow-top.png') }}" alt="">
                          </div>
                        @endif
                        <div class="remove-photo">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                        </div>
                      </div>
                      <p class="uploud__status {{ !$image->getCustomProperty('moderate') ? 'uploud__status_good' : '' }}">
                        {{ $image->getCustomProperty('moderate') ? 'Проверка модератором' : 'Опубликовано' }}
                      </p>
                    </li>
                  @endforeach
                </ul>
              </div>

            </div>
            <div class="row">
              <div class="col-12">
                <p class="uploud__min text">
                  (минимум 1 фотография, максимум 6)
                </p>
              </div>
            </div>
            <div class="row">
              <ul class="hours">
                @foreach($costTypes as $type)
                  @php
                    $id = $type->id;
                    $costRoom = $room->costs()->whereHas('period', function ($q) use($id) {
                      $q->where('cost_type_id', $id);
                    })->first();

                    $costPeriod = \Domain\Room\Actions\GetCurrentCostPeriodAction::run($costRoom->id);
                  @endphp
                  <li class="hour">
                    <div class="d-flex justify-content-between">
                      <p class="heading hours__heading">
                        {{ $type->name }}                      
                      </p>
                      <p class="hours__date">
                        {{Carbon\Carbon::now()->translatedFormat('d F Y')}}
                      </p>
                    </div>
                    <span class="hours__discount {{$costRoom->value > 0 ? '' : 'invisible'}}">
                      {{ $costPeriod != null ?  $costPeriod->value.' - '.$costPeriod->discount.' %' : ' ' }}
                    </span>
                    <div class="d-flex align-items-center">
                      <input type="number"
                             min="0"
                             class="field hours__field has-validate-error"
                             id="value-{{ $room->id }}-{{$type->id}}"
                             placeholder="{{ $costRoom->value ?? '' }}"
                             value="{{ $costRoom->value ?? null }}">

                      <div class="hours__hidden">
                        <span class="hours__money">{{ $costRoom->value ?? null }}</span>
                        <span class="hours__rub">руб.</span>
                      </div>

                      <span class="rub">руб.</span>

                      <div class="select hours__select has-validate-error-select">
                        <input type="hidden"
                               name="type[]"
                               data-id="{{$type->id}}"
                               value="{{ $costRoom->period->id ?? null }}">

                        <div class="select__top">
                          <span class="select__current">{{ $costRoom->period->info ?? 'Период' }}</span>
                          <img class="select__arrow"
                               src="{{ asset('img/lk/arrow.png') }}" alt="">
                        </div>
                        <ul class="select__hidden">
                          @foreach($type->periods as $period)
                            <li class="select__item" data-id="{{ $period->id }}">{{ $period->info }}</li>
                          @endforeach
                        </ul>
                      </div>
                      <span class="hours__after">
                        {{ $costRoom->period->info ?? 'Период' }}
                      </span>
                    </div>
                    <div class="align-items-center pt-4 pb-3 d-none">
                      <button class="cost_periods__open mx-auto"
                        data-cost-id="{{ $costRoom?->id }}"
                        data-room-name="{{ $room->name }}"
                        data-category-name="{{ $room->category->name }}"
                        data-period="{{ $type->name }}"
                        data-avg-value="{{ $costRoom?->avg_value > 0 ? $costRoom?->avg_value : $costRoom?->value}}"
                      >                      
                        <span class="plus">+</span>
                      </button>
                    </div>                    
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="row more-details">
              <div class="col-12">
                <p class="text {{ $room->attrs()->count() === 0 ? 'is-invalid form-control' : '' }}">Детально о номере</p>
                <p class="caption caption_mt">
                  Выберите пункты наиболее точно отражающие преимущества данного номера
                  / группы номеров. (минимум 3, максимум 9 пунктов)
                </p>
              </div>

            </div>

            <div class="row">
              <div class="col-12">
                <div class="mt-2 attributes-list">
                  @foreach($room->attrs as $a)
                    <span>{{ $a->name . (!$loop->last ? ',' : '') }}</span>
                  @endforeach
                </div>
              </div>
              <div class="col-12">
                <a class="show-all show-all_orange" data-room-id="{{ $room->id }}">Показать все</a>
              </div>
            </div>
            <div class="row row__bottom">
              <div class="col-12">
                <div class="d-flex align-items-center quote__buttons">
                  <button class="button save-room" id="saveRoom">Сохранить</button>
                  <button class="quote__read quote__read_1">
                    <img src="{{ asset('img/lk/pen.png') }}" alt="">
                  </button>
{{--                  <button class="quote__remove remove-btn">--}}
{{--                    <i class="fa fa-trash"></i>--}}
{{--                  </button>--}}

                </div>
              </div>
            </div>

          </div>
        @endforeach
      </div>

    </div>
  </section>

  @include('moderator.room.__popup_attributes', [$attribute_categories])
  @include('moderator.room.__popup_cost_periods')

@endsection

@section('header-js')
  <script src="{{ asset('js/lk/room-categories.js') }}"></script> 
@endsection

@section('js')

  <script defer="defer">
    $(document).ready(function () {
      $('.uploud').sortable({
        items: '.uploud__item',
        update: updateOrderPhotos
      });

      $('.quote__read').each(function () {
        saveFrontData.call(this, true)
      })
    });

  </script>
@endsection