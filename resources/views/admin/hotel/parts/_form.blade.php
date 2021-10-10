<div class="form-group">
    <label for="name">Наименование</label>
    <input type="text" name="name" id="name" value="{{ old('name') ?? @$hotel->name ?? '' }}" class="form-control "
           required/>
</div>
<div class="form-group">
    @if(isset($hotel) && !is_null($hotel))
        <input type="hidden" name="hotel" value="{{ $hotel->id }}"/>
    @endif
    <label for="slug">Слаг</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug') ?? @$hotel->slug ?? '' }}" class="form-control"/>
</div>
<div class="form-group">
    <label for="email">Email для бронирования</label>
    <input type="email" name="email" id="email" value="{{ old('email') ?? @$hotel->email ?? '' }}" class="form-control"/>
</div>
<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="hidden" name="hide_phone" value="0">
        <input type="checkbox" @if(old('hide_phone') == 1 || @$hotel->hide_phone) checked @endif class="custom-control-input" id="hide_phone" name="hide_phone" value="1">
        <label class="custom-control-label" for="hide_phone">Показывать телефон</label>
    </div>
</div>
<div class="form-group">
    <label for="phone">Телефон</label>
    <input type="tel" name="phone" id="phone" value="{{ old('phone') ?? @$hotel->phone ?? '' }}"
           class="form-control phone" required/>
</div>
<div class="form-group">
    <label for="description">Описание</label>
    <textarea name="description" id="description"
              class="form-control editor ">{{ old('description') ?? @$hotel->description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_title">Тайтл</label>
    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') ?? @$hotel->meta_title ?? '' }}" class="form-control "/>
</div>
<div class="form-group">
    <label for="meta_description">Мета описание</label>
    <textarea name="meta_description" id="meta_description"
              class="form-control  ">{{ old('meta_description') ?? @$hotel->meta_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_keywords">Canonical</label>
    <input name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') ?? @$hotel->meta_keywords ?? '' }}"
              class="form-control  " />
</div>
<div class="form-group">
    <label class="h5 w-100">Детально об отлеле</label>
    @foreach($attributes AS $attribute)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="attr_{{ $loop->index }}" value="{{ $attribute->id }}"
                   name="attributes[{{ $attribute->id }}]"
                   @if((isset($hotel) && @$hotel->attrs()->count() > 0 && $hotel->attrs->contains($attribute)) || old('attributes.'.$attribute->id, 0) == $attribute->id)
                   checked
                    @endif
            >
            <label class="form-check-label" for="attr_{{ $loop->index }}">{{ $attribute->name }}</label>
        </div>
    @endforeach
</div>
<div class="form-group">
    <div class="form-check form-check-inline">
        <input type="hidden" name="is_popular" value="0">
        <input class="form-check-input" type="checkbox" id="is_popular" value="1" name="is_popular"
               @if(@$hotel->is_popular || old('is_popular', 0) == 1)
               checked
                @endif
        >
        <label class="form-check-label" for="is_popular">Популярный отель</label>
    </div>
</div>

@if(count($hotelTypes) > 0)
    <div class="form-group">
        <label for="type">Тип размещения</label>
        <select name="type_id" id="type" class="form-control">
            @foreach($hotelTypes AS $hotelType)
                <option value="{{ $hotelType->id }}"
                        @if ((isset($hotel) && $hotel->type && $hotel->type->id === $hotelType->id) || (old('type_id') === $hotelType->id))
                        selected
                        @endif>{{$hotelType->name}}</option>
            @endforeach
        </select>
    </div>
@endif
<div class="form-group">
    <label for="address">Адрес</label>
    <input type="text" id="address" class="form-control" name="address"
           value="{{ old('address') ?? @$hotel->address->value ?? '' }}">
</div>
<div class="form-group">
    <label for="address_comment">Комментарий к адресу, будет добавлен через запятую</label>
    <input type="text" id="address_comment" class="form-control" name="address_comment"
           value="{{ old('address_comment') ?? @$hotel->address->comment ?? '' }}">
</div>

<div class="form-group">
    <label for="route_title">Заголовок как добратся</label>
    <input type="text" class="form-control" id="route_title" name="route_title"
           value="{{ old('route_title') ?? @$hotel->route_title ?? '' }}">
</div>

<div class="form-group">
    <label for="route">Содержимое как добратся</label>
    <textarea name="route" id="route" class="form-control editor">{{ old('route') ?? @$hotel->route ?? '' }}</textarea>
</div>
<div class="dropdown-divider"></div>
@if (!isset($hotel) || is_null($hotel))
    @for ($i = 1; $i < 4; $i++)
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">Название и дистанция</span>
                </div>
                
                <input type="text" id="metro_{{ $i }}_color" class="form-control" name="metros[{{ $i }}][color]"
                       value="{{ old('metros.'.$i.'.color') }}" placeholder="Цвет">
                       
                <input type="text" id="metro_{{ $i }}_name" class="form-control" name="metros[{{ $i }}][name]"
                       value="{{ old('metros.'.$i.'.name') }}" placeholder="Название">
                <input type="text" id="metro_{{ $i }}_distance" class="form-control" name="metros[{{ $i }}][distance]"
                       value="{{ old('metros.'.$i.'.distance') }}" placeholder="Дистанция">
            </div>
        </div>
    @endfor
@else
    @php($metro_count = 0)
    @foreach ($hotel->metros AS $metro)
        @break($loop->index == 3)
        <div class="form-group">
            <label for="metro_{{ $loop->index }}_name">Метро {{ $metro->name }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">Название и дистанция</span>
                </div>
                
                <input type="text" id="metro_{{ $loop->index }}_color" class="form-control" name="metros[{{ $loop->index }}][color]"
                       value="{{ old('metros.'.$loop->index.'.color', $metro->color) }}" placeholder="Цвет">
                       
                <input type="text" id="metro_{{ $loop->index }}_name" class="form-control"
                       name="metros[{{ $loop->index }}][name]"
                       value="{{ old('metros.'.$loop->index.'.name', $metro->name) }}" placeholder="Название">
                <input type="text" id="metro_{{ $loop->index }}_distance" class="form-control"
                       name="metros[{{ $loop->index }}][distance]"
                       value="{{ old('metros.'.$loop->index.'.distance', $metro->distance) }}" placeholder="Дистанция">
            </div>
        </div>
        @php($metro_count = $loop->iteration + 1)
    @endforeach
    @for ($i = $metro_count; $i < 4; $i++)
        <div class="form-group">
            <label for="metro_{{ $i }}_name">Метро</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">Название и дистанция</span>
                </div>
                 <input type="text" id="" class="form-control" name="metros[{{ $i }}][color]"
                       value="{{ old('metros.'.$i.'.name') }}" placeholder="Название">
                       
                <input type="text" id="metro_{{ $i }}_name" class="form-control" name="metros[{{ $i }}][name]"
                       value="{{ old('metros.'.$i.'.name') }}" placeholder="Название">
                <input type="text" id="metro_{{ $i }}_distance" class="form-control" name="metros[{{ $i }}][distance]"
                       value="{{ old('metros.'.$i.'.distance') }}" placeholder="Дистанция">
            </div>
        </div>
    @endfor
@endif
<div class="dropdown-divider"></div>
<div class="h4">Описание цен</div>
<div class="col-12">
	<table class="table">
            <tbody>
            @foreach ($hotel->minimals as $min)
              <tr>
                @if ($min->value !== 0)
                  <td class="prices__main">{{ $min->name }} - от {{ $min->value }} руб.</td>
                  <td class="text">{{ $min->info }}</td>
                @else
                  <td class="prices__main">{{ $min->name }}</td>
                  <td class="text">{{ $min->info }}</td>
                @endif
              </tr>
            @endforeach
            </tbody>
          </table>
</div>
