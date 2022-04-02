<div class="form-group">
  <label for="name">Наименование</label>
  <input type="text" name="name" id="name" value="{{ old('name') ?? @$hotel->name ?? '' }}" class="form-control @error('name') is-invalid @enderror"
         required/>
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  @if(isset($hotel))
    <input type="hidden" name="hotel" value="{{ $hotel->id }}"/>
  @endif
  <label for="slug">Слаг</label>
  <input type="text" name="slug" id="slug" value="{{ old('slug') ?? @$hotel->slug ?? '' }}" class="form-control @error('slug') is-invalid @enderror"/>
    @error('slug')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
  <label for="email">Email для бронирования</label>
  <input type="email" name="email" id="email" value="{{ old('email') ?? @$hotel->email ?? '' }}" class="form-control @error('email') is-invalid @enderror"/>
  @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <div class="custom-control custom-checkbox @error('hide_phone') is-invalid @enderror">
    <input type="hidden" name="hide_phone" value="0">
    <input type="checkbox" @if(old('hide_phone') == 1 || @$hotel->hide_phone) checked
           @endif class="custom-control-input" id="hide_phone" name="hide_phone" value="1">
    <label class="custom-control-label" for="hide_phone">Показывать телефон</label>
  </div>
  @error('hide_phone')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="phone">Телефон</label>
  <input type="tel" name="phone" id="phone" value="{{ old('phone') ?? @$hotel->phone ?? '' }}"
         class="form-control phone @error('phone') is-invalid @enderror" required/>
  @error('phone')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="description">Описание</label>
  <textarea name="description" id="description"
            class="form-control editor @error('description') is-invalid @enderror">{{ old('description') ?? @$hotel->description ?? '' }}</textarea>
  @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="meta_title">Тайтл</label>
  <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') ?? @$hotel->meta_title ?? '' }}"
         class="form-control @error('meta_title') is-invalid @enderror"/>
  @error('meta_title')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group required">
  <label for="h1">H1</label>
  <input type="text" name="h1" id="h1" value="{{ old('h1') ?? @$hotel->meta_h1 ?? '' }}" class="form-control @error('h1') is-invalid @enderror" required/>
  @error('h1')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="meta_description">Мета описание</label>
  <textarea name="meta_description" id="meta_description"
            class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description') ?? @$hotel->meta_description ?? '' }}</textarea>
  @error('meta_description')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="meta_keywords">Canonical</label>
  <input name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') ?? @$hotel->meta_keywords ?? '' }}"
         class="form-control @error('meta_keywords') is-invalid @enderror"/>
  @error('meta_keywords')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label class="h5 w-100">Детально об отлеле</label>
  @foreach($attributes AS $attribute)
    <div class="form-check form-check-inline">
      <input class="form-check-input @error('attributes') is-invalid @enderror" type="checkbox" id="attr_{{ $loop->index }}" value="{{ $attribute->id }}"
             name="attributes[{{ $attribute->id }}]"
             @if((isset($hotel) && @$hotel->attrs()->count() > 0 && $hotel->attrs->contains($attribute)) || old('attributes.'.$attribute->id, 0) == $attribute->id)
             checked
        @endif
      >
      <label class="form-check-label" for="attr_{{ $loop->index }}">{{ $attribute->name }}</label>
    </div>
  @endforeach
  @error('attributes')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <div class="form-check form-check-inline @error('id_popular') is-invalid @enderror">
    <input type="hidden" name="is_popular" value="0">
    <input class="form-check-input" type="checkbox" id="is_popular" value="1" name="is_popular"
           @if(@$hotel->is_popular || old('is_popular', 0) == 1)
           checked
      @endif
    >
    <label class="form-check-label" for="is_popular">Популярный отель</label>
  </div>
  @error('is_popular')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

@if(count($hotelTypes) > 0)
  <div class="form-group">
    <label for="type">Тип размещения</label>
    <select name="type_id" id="type" class="form-control @error('type_id') is-invalid @enderror">
      @foreach($hotelTypes AS $hotelType)
        <option value="{{ $hotelType->id }}"
                @if ((isset($hotel) && $hotel->type && $hotel->type->id === $hotelType->id) || (old('type_id') === $hotelType->id))
                selected
          @endif>{{$hotelType->name}}</option>
      @endforeach
    </select>
    @error('type_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
@endif
<div class="form-group">
  <label for="address">Адрес</label>
  <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address"
         value="{{ old('address') ?? @$hotel->address->value ?? '' }}">
  @error('address')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="address_comment">Комментарий к адресу, будет добавлен через запятую</label>
  <input type="text" id="address_comment" class="form-control @error('address_comment') is-invalid @enderror" name="address_comment"
         value="{{ old('address_comment') ?? @$hotel->address->comment ?? '' }}">
  @error('address_comment')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="route_title">Заголовок как добратся</label>
  <input type="text" class="form-control @error('route_title') is-invalid @enderror" id="route_title" name="route_title"
         value="{{ old('route_title') ?? @$hotel->route_title ?? '' }}">
  @error('route_title')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="route">Содержимое как добратся</label>
  <textarea name="route" id="route" class="form-control editor @error('route') is-invalid @enderror">{{ old('route') ?? @$hotel->route ?? '' }}</textarea>
  @error('route')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
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
        <input type="text" id="metro_{{ $i }}_api_value" class="form-control" name="metros[{{ $i }}][api_value]"
               value="{{ old('metros.'.$i.'.api_value') }}" placeholder="Полное наименование (Улицы)">
        <input type="text" id="metro_{{ $i }}_distance" class="form-control" name="metros[{{ $i }}][distance]"
               value="{{ old('metros.'.$i.'.distance') }}" placeholder="Дистанция">
      </div>
      @error('metros')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
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

        <input type="text" id="metro_{{ $loop->index }}_color" class="form-control"
               name="metros[{{ $loop->index }}][color]"
               value="{{ old('metros.'.$loop->index.'.color', $metro->color) }}" placeholder="Цвет">

        <input type="text" id="metro_{{ $loop->index }}_name"
               class="form-control"
               name="metros[{{ $loop->index }}][name]"
               value="{{ old('metros.'.$loop->index.'.name', $metro->name) }}"
               placeholder="Название">
        <input type="text" id="metro_{{ $loop->index }}_api_value"
               class="form-control"
               name="metros[{{ $loop->index }}][api_value]"
               value="{{ old('metros.'.$loop->index.'.api_value', $metro->api_value) }}"
               placeholder="Полное наименование (Улицы)"
        >
        <input type="text" id="metro_{{ $loop->index }}_distance" class="form-control"
               name="metros[{{ $loop->index }}][distance]"
               value="{{ old('metros.'.$loop->index.'.distance', $metro->distance) }}" placeholder="Дистанция">
      </div>
      @error('metros')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
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
        <input type="text" id="metro_{{ $i }}_api_value" class="form-control" name="metros[{{ $i }}][api_value]"
               value="{{ old('metros.'.$i.'.api_value') }}" placeholder="Полное наименование (Улицы)">
        <input type="text" id="metro_{{ $i }}_distance" class="form-control" name="metros[{{ $i }}][distance]"
               value="{{ old('metros.'.$i.'.distance') }}" placeholder="Дистанция">
      </div>
      @error('metros')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  @endfor
@endif
<div class="dropdown-divider"></div>
<div class="h4">Описание цен</div>
<div class="col-12">
  <table class="table">
    <tbody>
      @if(isset($hotel))
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
      @endif
    </tbody>
  </table>
</div>
