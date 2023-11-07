<div class="form-group">
    <label for="name">Наименование</label>
    <input type="text" name="name" id="name" value="{{ old('name') ?? @$botMessageTemplate->name ?? '' }}"
           class="form-control @error('name') is-invalid @enderror"/>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="header">Заголовок</label>
    <input type="text" name="header" id="header" value="{{ old('header') ?? @$botMessageTemplate->header ?? '' }}"
           class="form-control @error('header') is-invalid @enderror"/>
    @error('header')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="body">Тело сообщения</label>
    <textarea name="body" id="body"
              class="form-control @error('body') is-invalid @enderror">{{ old('body') ?? @$botMessageTemplate->body ?? '' }}</textarea>
    @error('body')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="url">Ссылка</label>
    <input type="url" name="url" id="url" placeholder="https://example.com" value="{{ old('url') ?? @$botMessageTemplate->url ?? '' }}"
           class="form-control  @error('url') is-invalid @enderror"/>
    @error('url')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="sort">Порядок отправки сообщений</label>
    <input type="number" name="sort" id="sort" value="{{ old('sort') ?? @$botMessageTemplate->sort ?? '' }}" 
        class="form-control @error('sort') is-invalid @enderror"/>      
    @error('sort')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-check">   
    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" 
            {{ isset($botMessageTemplate) ? ($botMessageTemplate->is_active === true ? 'checked' : '') : 'checked' }}
           
           class="form-control"/>
    <label for="is_active" class="form-check-label">Активно</label>
    @error('is_active')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
</br>
