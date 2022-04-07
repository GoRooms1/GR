<div class="form-group required">
  <label for="title">Заголовок</label>
  <input type="text" name="title" id="title" value="{{ old('title') ?? @$description->title ?? '' }}" class="form-control @error('title') is-invalid @enderror" required/>
  @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="h1">H1</label>
  <input type="text" name="h1" id="h1" value="{{ old('h1') ?? @$description->h1 ?? '' }}" class="form-control @error('h1') is-invalid @enderror"/>
  @error('h1')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group required">
  <label for="url">Ссылка</label>
  <input type="text" name="url" id="url" value="{{ old('url') ?? @$description->url ?? '' }}" class="form-control @error('url') is-invalid @enderror" required />
  @error('url')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group required">
  <label for="meta_description">Поисковое описание</label>
  <textarea name="meta_description" id="meta_description" required class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description') ?? @$description->meta_description ?? '' }}</textarea>
  @error('meta_description')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="meta_keywords">Ключевые слова</label>
  <textarea name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror">{{ old('meta_keywords') ?? @$description->meta_keywords ?? '' }}</textarea>
  @error('meta_keywords')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="form-group">
  <label for="description">Описание</label>
  <textarea name="description" id="description" class="form-control editor @error('description') is-invalid @enderror">{{ old('description') ?? @$description->description ?? '' }}</textarea>
  @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>