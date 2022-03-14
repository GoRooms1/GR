@php
  $name = Request::route()->getName();
  if ($name !== 'search.map' && $name !== 'search') {
    $route = route('search');
  } else {
    $route = URL::current();
  }
@endphp

<form action="{{ $route }}" autocomplete="off" id="js-advanced-search" class="advanced-search" method="GET">
  <div id="js-advanced-search-in" class="advanced-search-in">
    <div class="container">
      <div class="search-form-group">
        <div class="relative-input-search">
          <input type="text" id="advanced-search" name="" class="search-input"
                 placeholder="Название отеля, адрес, метро, округ, район, город"
                 value=""
                 autocomplete="off"
                 onfocus="this.removeAttribute('readonly')"
                 readonly
          >
          <div class="list-group" style="display: none;" id="big-list-group">
            <p class="list-group-item list-group-item-action item-action-title">Отели</p>
            <a href="#" class="list-group-item list-group-item-action">A second link item</a>
            <a href="#" class="list-group-item list-group-item-action">A third link item</a>
            <p class="list-group-item list-group-item-action item-action-title">Метро</p>
            <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
            <a href="#" class="list-group-item list-group-item-action">A disabled link item</a>
            <p class="list-group-item list-group-item-action item-action-title">Районы</p>
            <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
            <a href="#" class="list-group-item list-group-item-action">A disabled link item</a>
          </div>
        </div>
        {{--        <button class="btn btn-orange search-btn">Найти</button>--}}
      </div>
      <div class="search-tags">
        @if ($city)
          <span class="d-flex" data-type-tag="city" data-info="{{ $city }}">г.{{ $city }}</span>
        @endif
        @if ($area)
          <span class="d-flex" data-type-tag="area" data-info="{{ $area }}">округ {{ $area }}
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @else
            <span class="d-none" data-type-tag="area">
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @endif
        @if ($district)
          <span class="d-flex" data-type-tag="district" data-info="{{ $district }}">р-н {{ $district }}
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @else
            <span class="d-none" data-type-tag="district">
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @endif
        @if ($metro)
          <span class="d-flex" data-type-tag="metro" data-info="{{ $metro }}">метро {{ $metro }}
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @else
            <span class="d-none" data-type-tag="metro">
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @endif
        @if ($hot)
          <span class="d-flex" data-type-tag="hot" data-info="{{ $hot }}">Горящие предложения
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @else
            <span class="d-flex" style="display: none" data-type-tag="hot" data-info="{{ $hot }}">Горящие предложения
              <a href="#">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
        @endif
        @foreach($attributes as $attr)
          <span class="d-flex" data-type-tag="attributes" data-info="{{ $attr->id }}">{{ $attr->name }}
            <a href="#">
              <i class="fa-solid fa-xmark"></i>
            </a>
          </span>
        @endforeach

        <span class="d-none copy-attr">
          <a href="#">
            <i class="fa-solid fa-xmark"></i>
          </a>
        </span>

      </div>
      <div class="search-dates">
      </div>
      <div class="row">
        <div class="col-xl-4 advanced-search-location-wrapper">
          <div class="advanced-search-location">
            <p class="advanced-search-title">
              Расположение
              <button class="js-search-btn-collapse search-btn-collapse" type="button"></button>
            </p>
            <div class="filter-collapse js-search-collapse">
              {{--              CITY --}}
              <div class="form-group">
                <select
                  name="city"
                  id="advanced-search-location-city"
                  class="form-control form-control-sm"
                  data-placeholder="Город"
                >
                  <option value="{{ $city }}" selected>{{ $city }}</option>
                </select>
              </div>
              {{--              END CITY--}}

              {{--              City AREA --}}
              <div class="form-group">
                <select id="advanced-search-location-city_area"
                        name="city_area"
                        class="form-control"
                        data-placeholder="Округ"
                >
                  @if($area)
                    <option value="{{ $area }}" selected>{{ $area }}</option>
                  @endif
                </select>
              </div>

              {{--              END CITY AREA--}}
              <div class="form-group">
                <select id="advanced-search-location-district"
                        name="district"
                        class="form-control"
                        data-placeholder="Район"
                >
                  @if($district)
                    <option value="{{ $district }}" selected>{{ $district }}</option>
                  @endif
                </select>
              </div>
              <div class="form-group">
                <select id="advanced-search-location-metro"
                        name="metro"
                        class="form-control"
                        data-placeholder="Метро"
                >
                  @if($metro)
                    <option value="{{ $metro }}" selected>{{ $metro }}</option>
                  @endif
                </select>
              </div>
              <div class="form-group">
                <select name="hotel_type" id="advanced-search-location-type"
                        class="form-control"
                        data-placeholder="Тип размещения">
                  @foreach ($hotels_type as $type)
                    <option
                      value="{{ $type->id }}" {{ (int)$hotel_type === $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 advanced-search-prices-wrapper">
          <div class="advanced-search-prices">
            <p class="advanced-search-title">По цене
              <button class="js-search-btn-collapse search-btn-collapse" type="button"></button>
            </p>
            <div class="filter-collapse js-search-collapse">
              <div class="advanced-search-prices-wrap">
                <div class="advanced-search-prices-in advanced-search-prices-control">
                  <p class="advanced-search-prices-in-label">Период размещения:</p>
                  <ul class="advanced-search-prices-list">
                    <li class="advanced-search-prices-item">
                      <input id="advanced-search-prices-1" type="checkbox" class="checkbox" name="search-price"
                             value="hour" @checked('hour', $request->get('search-price'))>
                      <label for="advanced-search-prices-1" class="checkbox-label checkbox-label-orange">На
                        час</label>
                    </li>
                    <li class="advanced-search-prices-item">
                      <input id="advanced-search-prices-2" type="checkbox" class="checkbox" name="search-price"
                             value="night" @checked('night', $request->get('search-price'))>
                      <label for="advanced-search-prices-2" class="checkbox-label checkbox-label-orange">На
                        ночь</label>
                    </li>
                    <li class="advanced-search-prices-item">
                      <input id="advanced-search-prices-3" type="checkbox" class="checkbox" name="search-price"
                             value="day" @checked('day', $request->get('search-price'))>
                      <label for="advanced-search-prices-3" class="checkbox-label checkbox-label-orange">На
                        сутки</label>
                    </li>
                  </ul>
                </div>
                @foreach (['hour' => 'На час', 'night' => 'На ночь', 'day' => 'На сутки'] as $type => $title)
                  <div
                    class="advanced-search-prices-in advanced-search-prices-in-item {{ $request->get('search-price') !== $type ? 'disabled' : ''}}">
                    <p class="advanced-search-prices-in-label">{{ $title }}:</p>
                    <ul class="advanced-search-prices-list">
                      <li class="advanced-search-prices-item">
                        @php($value = $type.'.lte.'.Settings::option($type.'_cost_small'))
                        <input id="advanced-search-prices-{{ $loop->index }}-1" name="cost" type="radio"
                               class="checkbox" value="{{$value}}" @checked($value, $request->get('cost')) >
                        <label for="advanced-search-prices-{{ $loop->index }}-1"
                               class="checkbox-label checkbox-label-orange">до {{ Settings::option($type.'_cost_small') }}
                          р.</label>
                      </li>
                      <li class="advanced-search-prices-item">
                        @php($value = $type.'.between.'.Settings::option($type.'_cost_small').'-'.Settings::option($type.'_cost_medium'))
                        <input id="advanced-search-prices-{{ $loop->index }}-2" name="cost" type="radio"
                               class="checkbox" value="{{$value}}" @checked($value, $request->get('cost')) >
                        <label for="advanced-search-prices-{{ $loop->index }}-2"
                               class="checkbox-label checkbox-label-orange">{{ Settings::option($type.'_cost_small') }}
                          р.- {{ Settings::option($type.'_cost_medium') }} р</label>
                      </li>
                      <li class="advanced-search-prices-item">
                        @php($value = $type.'.between.'.Settings::option($type.'_cost_medium').'-'.Settings::option($type.'_cost_low'))
                        <input id="advanced-search-prices-{{ $loop->index }}-3" name="cost" type="radio"
                               class="checkbox" value="{{$value}}" @checked($value, $request->get('cost')) >
                        <label for="advanced-search-prices-{{ $loop->index }}-3"
                               class="checkbox-label checkbox-label-orange">{{ Settings::option($type.'_cost_medium') }}
                          р. - {{ Settings::option($type.'_cost_low') }}
                          р</label>
                      </li>
                      <li class="advanced-search-prices-item">
                        @php($value = $type.'.gte.'.Settings::option($type.'_cost_low'))
                        <input id="advanced-search-prices-{{ $loop->index }}-4" name="cost" type="radio"
                               class="checkbox" value="{{$value}}" @checked($value, $request->get('cost')) >
                        <label for="advanced-search-prices-{{ $loop->index }}-4"
                               class="checkbox-label checkbox-label-orange">от {{ Settings::option($type.'_cost_low') }}
                          р.</label>
                      </li>
                    </ul>
                  </div>
                @endforeach
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="advanced-search-filter">
        <div class="left">
          <div class="advanced-search-filter-item">
            <p for="advanced-search-filter-profitably" class="search-filter-label search-filter-label-profitably">
              Выгодно</p>
          </div>
          <div class="advanced-search-filter-item">
            <input type="checkbox" id="advanced-search-filter-fire" class="checkbox" name="hot" value="1"
                   @if($request->has('hot')) checked @endif
            />
            <label for="advanced-search-filter-fire"
                   class="search-filter-label search-filter-label-fire checkbox-label checkbox-label-light">Горящие
              предложения</label>
          </div>
        </div>
        <div class="right">
          <div class="advanced-search-filter-item rating">
            <p class="search-filter-label search-filter-label-profitably">Рейтинг отелей:</p>
            <div class="rating-block">
              <a href="#">Любой</a>
              <a href="#">6+</a>
              <a href="#">7+</a>
              <a href="#">8+</a>
              <a href="#">9+</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row advanced-search-details">
        <div class="col-lg-6 advanced-search-details-col">
          <p class="advanced-search-title">Детально об отлеле
            <button class="js-search-btn-collapse search-btn-collapse" type="button"></button>
          </p>
          <div class="filter-collapse js-search-collapse">
            <ul class="advanced-search-details-list">
              @foreach ($hotels_attributes as $attribute)
                <li class="advanced-search-details-item">
                  <input id="advanced-search-hotel-{{ $loop->index }}" type="checkbox"
                         {{--                         @if(in_array($attribute->id, $attributes, false))--}}
                         @if($attributes->contains('id', $attribute->id))
                         checked
                         @endif
                         name="attributes[hotel][]" value="{{ $attribute->id }}" class="checkbox">
                  <label for="advanced-search-hotel-{{ $loop->index }}"
                         class="checkbox-label checkbox-label-light">{{ $attribute->name }}</label>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="col-lg-6 advanced-search-details-col">
          <p class="advanced-search-title">Детально о номерах
            <button class="js-search-btn-collapse search-btn-collapse" type="button"></button>
          </p>
          <div class="filter-collapse js-search-collapse">
            <ul class="advanced-search-details-list">
              @foreach ($rooms_attributes as $attribute)
                <li class="advanced-search-details-item">
                  <input id="advanced-search-rooms-{{ $loop->index }}" type="checkbox"
                         {{--                         @if(in_array($attribute->id, $attributes['room'], false))--}}
                         @if($attributes->contains('id', $attribute->id))
                         checked
                         @endif
                         name="attributes[room][]" value="{{ $attribute->id }}" class="checkbox">
                  <label for="advanced-search-rooms-{{ $loop->index }}"
                         class="checkbox-label checkbox-label-light">{{ $attribute->name }}</label>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        @moderator
        <div class="col-lg-12 advanced-search-details-col">
          <p class="advanced-search-title">Модерация</p>
          <div class="filter-collapse js-search-collapse">
            <ul class="advanced-search-details-list">

              <li class="advanced-search-details-item">
                <input id="advanced-search-moderate" type="checkbox"
                       @if(isset($moderate))
                       {{ $moderate ? 'checked' : '' }}
                       @endif
                       name="moderate" value="true" class="checkbox">
                <label for="advanced-search-moderate"
                       class="checkbox-label checkbox-label-light">На модерации</label>
              </li>
            </ul>
          </div>
        </div>
        @endmoderator
      </div>
    </div>
  </div>
  <div class="search-bottom">
    <div class="search-bottom-in">
      <button class="advanced-search-ico-btn advanced-search-ico-btn-favorite" type="button"></button>
      <a href="{{ route('search.map') }}" class="advanced-search-ico-btn advanced-search-ico-btn-map"
         type="button"></a>
      <button onclick="event.preventDefault();search_reset();" class="advanced-search-reset-btn">Очистить поиск</button>
      <button class="btn btn-blue" type="submit">Показать</button>
    </div>
    <button id="js-advanced-search-close-btn" type="button"
            class="advanced-search-btn advanced-search-btn-close">Свернуть фильтры
    </button>
  </div>
</form>
<div id="js-search-wrapper" class="search-wrapper">
  <div id="js-search" class="search">
    <div class="container">
      <form action="{{ route('search') }}" autocomplete="off" id="search-form" class="search-form" method="GET">
        <input type="hidden" name="city" autocomplete="off" value="{{ $city }}"
               onfocus="this.removeAttribute('readonly')" readonly>
        <div class="search-form-group">
          <div class="relative-input-search">
            <input type="search"
                   id="search-mini"
                   name=""
                   class="search-input"
                   value=""
                   autocomplete="off"
                   onfocus="this.removeAttribute('readonly')"
                   readonly
                   placeholder="Название отеля, адрес, метро, округ, район, город">

            <div class="list-group" style="display: none" id="mini-list-group">
              <p class="list-group-item list-group-item-action item-action-title">Отели</p>
              <a href="#" class="list-group-item list-group-item-action">A second link item</a>
              <a href="#" class="list-group-item list-group-item-action">A third link item</a>
              <p class="list-group-item list-group-item-action item-action-title">Метро</p>
              <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
              <a href="#" class="list-group-item list-group-item-action">A disabled link item</a>
              <p class="list-group-item list-group-item-action item-action-title">Районы</p>
              <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
              <a href="#" class="list-group-item list-group-item-action">A disabled link item</a>
            </div>
          </div>
          {{--          <button class="btn btn-orange search-btn">Найти</button>--}}

        </div>
        <div class="search-tags">
          @if ($city)
            <span class="d-flex">г.{{ $city }}</span>
          @endif
          @if ($area)
            <span class="d-flex">округ {{ $area }}
              <a href="{{ \App\Widgets\Filter::remove_key('city_area') }}">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
          @endif
          @if ($district)
            <span class="d-flex">р-н {{ $district }}
              <a href="{{ \App\Widgets\Filter::remove_key('district') }}">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
          @endif
          @if ($metro)
            <span class="d-flex">метро {{ $metro }}
              <a href="{{ \App\Widgets\Filter::remove_key('metro') }}">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
          @endif
          @if ($hot)
            <span class="d-flex">Горящие предложения
              <a href="{{ \App\Widgets\Filter::remove_key('hot') }}">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
          @endif
          @foreach($attributes as $attr)
            <span class="d-flex">{{ $attr->name }}
              <a href="{{ \App\Widgets\Filter::remove_attr($attr->model === \App\Models\Room::class ? 'room' : 'hotel', $attr->id) }}">
                <i class="fa-solid fa-xmark"></i>
              </a>
            </span>
          @endforeach
        </div>
        <div class="search-bottom">
          <button id="js-advanced-search-open-btn" class="advanced-search-btn advanced-search-btn-open">
            Расширеный поиск
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
