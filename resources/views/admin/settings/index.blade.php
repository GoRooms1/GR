@extends('layouts.admin')

@php($first_col = 'col-2')
@php($second_col = 'col-8')
@php($third_col = 'col-2')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Настройки</div>
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.clear-cache') }}" class="btn btn-info">Сбросить кеш</a>
                <div class="row">
                    <div class="{{ $first_col }}">
                        <div class="h5">Опция</div>
                    </div>
                    <div class="{{ $second_col }}">
                        <div class="h5">Значение</div>
                    </div>
                    <div class="{{ $third_col }}">
                        <div class="h5">Действие</div>
                    </div>
                    <div class="col-12">
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Телефон</div>
                    <div class="{{ $second_col }}"><input type="text" class="form-control phone" name="phone"
                                                          value="{{ Settings::option('phone') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Email</div>
                    <div class="{{ $second_col }}"><input type="email" class="form-control" name="email"
                                                          value="{{ Settings::option('email') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Email для сообщений</div>
                    <div class="{{ $second_col }}"><input type="email" class="form-control" name="notify"
                                                          value="{{ Settings::option('notify') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Адрес</div>
                    <div class="{{ $second_col }}"><input type="text" class="form-control" name="address"
                                                          value="{{ Settings::option('address') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Facebook</div>
                    <div class="{{ $second_col }}"><input type="text" class="form-control" name="fb"
                                                          value="{{ Settings::option('fb') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Instagram</div>
                    <div class="{{ $second_col }}"><input type="text" class="form-control" name="instagram"
                                                          value="{{ Settings::option('instagram') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">ВКонтакте</div>
                    <div class="{{ $second_col }}"><input type="text" class="form-control" name="vk"
                                                          value="{{ Settings::option('vk') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">YouTube</div>
                    <div class="{{ $second_col }}"><input type="text" class="form-control" name="youtube"
                                                          value="{{ Settings::option('youtube') }}"></div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Текст на главной</div>
                    <div class="{{ $second_col }}"><textarea class="form-control editor"
                                                             name="about">{!! html_entity_decode(Settings::option('about')) !!}</textarea>
                    </div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Город по умолчанию</div>
                    <div class="{{ $second_col }}">
                        <select name="city_default" id="city_default" class="form-control">
                            <option value="">Не выбрано</option>
                            @foreach($search_city AS $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.robot_store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Robots</div>
                    <div class="{{ $second_col }}">
                        <textarea class="form-control"
                                  style="min-height: 150px"
                                  name="content">{{ file_exists(public_path('robots.txt')) ? file_get_contents(public_path('robots.txt')) : '' }}</textarea>
                    </div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="dropdown-divider"></div>
                        <div class="h3 text-center">Цены</div>
                    </div>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row mb-3">
                    @csrf
                    <div class="{{ $first_col }}">Соотношения</div>
                    <div class="{{ $second_col }}">
                        <div class="form-row">
                            <div class="form-group col-12 col-md-4">
                                <label for="hour_cost_name">
                                    На час
                                </label>
                                <select name="hour_cost_name" id="hour_cost_name" class="form-control">
                                    @foreach(\App\Models\CostType::all() AS $cost_type)
                                        <option value="{{ $cost_type->id }}"
                                                @if(Settings::option('hour_cost_name') == $cost_type->id) selected @endif >{{ $cost_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="night_cost_name">
                                    На ночь
                                </label>
                                <select name="night_cost_name" id="night_cost_name" class="form-control">
                                    @foreach(\App\Models\CostType::all() AS $cost_type)
                                        <option value="{{ $cost_type->id }}"
                                                @if(Settings::option('night_cost_name') == $cost_type->id) selected @endif >{{ $cost_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label for="day_cost_name">
                                    На сутки
                                </label>
                                <select name="day_cost_name" id="day_cost_name" class="form-control">
                                    @foreach(\App\Models\CostType::all() AS $cost_type)
                                        <option value="{{ $cost_type->id }}"
                                                @if(Settings::option('day_cost_name') == $cost_type->id) selected @endif >{{ $cost_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $third_col }}">
                        <button class="btn btn-success">Обновить</button>
                    </div>
                </form>
                <form action="{{ route('admin.settings.store') }}" method="POST" class="row">
                    @csrf
                    @foreach (['hour' => 'На час', 'night' => 'На ночь', 'day' => 'Сутки'] as $type => $title)
                        <div class="{{ $first_col }} mb-3">{{ $title }}</div>
                        <div class="{{ $second_col }} mb-3">
                            <div class="form-row">
                                <div class="col-12 col-md-4">
                                    <input type="number" class="form-control" name="{{ $type }}_cost_small"
                                           value="{{ Settings::option($type.'_cost_small') }}"
                                           placeholder="Цена минимум">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="number" class="form-control" name="{{ $type }}_cost_medium"
                                           value="{{ Settings::option($type.'_cost_medium') }}"
                                           placeholder="Цена средне">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="number" class="form-control" name="{{ $type }}_cost_low"
                                           value="{{ Settings::option($type.'_cost_low') }}"
                                           placeholder="Цена максимум">
                                </div>
                            </div>
                        </div>
                        <div class="{{ $third_col }} mb-3">
                            @if($loop->index == 0)
                                <button class="btn btn-success">Обновить</button>
                            @endif
                        </div>

                    @endforeach
                </form>
            </div>
        </div>
    </div>
@stop
