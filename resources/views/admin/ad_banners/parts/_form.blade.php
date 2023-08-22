<div class="form-group required">
    <label for="name">Наименование</label>
    <input type="text" name="name" id="name" value="{{ old('name') ?? @$ad_banner->name ?? '' }}"
           class="form-control @error('name') is-invalid @enderror" required/>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="url">Ссылка</label>
    <input type="url" name="url" id="url" placeholder="https://example.com" value="{{ old('url') ?? @$ad_banner->url ?? '' }}"
           class="form-control  @error('url') is-invalid @enderror"/>
    @error('url')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group required">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="test@mail.ru" value="{{ old('email') ?? @$ad_banner->email ?? '' }}"
           class="form-control  @error('email') is-invalid @enderror" required/>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-check">   
    <input type="checkbox" class="form-check-input" name="is_show_always" id="is_show_always" class="form-control"
        @if (isset($ad_banner) ? $ad_banner->is_show_always : false) checked @endif       
    />
    <label for="is_show_always" class="form-check-label">Показывать постоянно</label>
    @error('is_show_always')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group show_dates-group">
    <label for="url">Дата начала показа</label>
    <input type="date" name="show_from" id="show_from" value="{{ old('show_from') ?? (isset($ad_banner) ? $ad_banner->show_from?->format('Y-m-d') : '') }}"
           class="form-control  @error('show_from') is-invalid @enderror" />
    @error('show_from')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group show_dates-group">
    <label for="show_to">Дата завершения показа</label>
    <input type="date" name="show_to" id="show_to" value="{{ old('show_from') ?? (isset($ad_banner) ? $ad_banner->show_to?->format('Y-m-d') : '') }}"
           class="form-control  @error('show_to') is-invalid @enderror"/>
    @error('show_to')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="h5 mt-2">Показывать на страницах: </div>
<div class="form-check form-check-inline">   
    <input type="checkbox" class="form-check-input" name="is_show_on_hotels" id="is_show_on_hotels" class="form-control"
        @if (isset($ad_banner) ? $ad_banner->is_show_on_hotels : false) checked @endif
    />
    <label for="is_show_on_hotels" class="form-check-label">Страница отелей</label>
    @error('is_show_on_hotels')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-check form-check-inline">   
    <input type="checkbox" class="form-check-input" name="is_show_on_rooms" id="is_show_on_rooms" class="form-control"
        @if (isset($ad_banner) ? $ad_banner->is_show_on_rooms : false) checked @endif
    />
    <label for="is_show_on_rooms" class="form-check-label">Страница номеров</label>
    @error('is_show_on_rooms')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-check form-check-inline">   
    <input type="checkbox" class="form-check-input" name="is_show_on_hotel" id="is_show_on_hotel" class="form-control"
        @if (isset($ad_banner) ? $ad_banner->is_show_on_hotel : false) checked @endif              
    />
    <label for="is_show_on_hotel" class="form-check-label">Карточка отеля</label>
    @error('is_show_on_hotel')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-check form-check-inline">   
    <input type="checkbox" class="form-check-input" name="is_show_on_hot" id="is_show_on_hot" class="form-control"
        @if (isset($ad_banner) ? $ad_banner->is_show_on_hot : false) checked @endif          
    />
    <label for="is_show_on_hot" class="form-check-label">Горячие предложения</label>
    @error('is_show_on_hot')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<br>
<div class="form-group">
    <label for="name">Показывать в городах:</label>    
    <select name="cities[]" class="form-control @error('cities') is-invalid @enderror" id="cities" multiple="multiple">
        @foreach ($cities as $city)
        <option value="{{ $city }}" @if(in_array($city, old('cities', $ad_banner->cities ?? []))) selected @endif>{{ $city }}</option>
        @endforeach
    </select>
    @error('cities')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@section('js')
  <script>
    $(document).ready(function () {
        $('#cities').select2( {
            placeholder: 'Города',
            closeOnSelect: false,
        });

        if ($('#is_show_always').is(":checked")) {
            $('.show_dates-group').addClass('d-none');        
        }
      
        $('#is_show_always').change(function() {       
            if(this.checked) {
                $('.show_dates-group').addClass('d-none');
            }
            else {
                $('.show_dates-group').removeClass('d-none');            
            }              
        });
    })
  </script>
@endsection
