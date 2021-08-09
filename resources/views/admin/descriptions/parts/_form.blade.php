<div class="form-group">
    <label for="title">Наименование</label>
    <input type="text" name="title" id="title" value="{{ old('title') ?? @$description->title ?? '' }}" class="form-control " required/>
</div>
<div class="form-group">
    <label for="url">Ссылка</label>
    <input type="text" name="url" id="url" value="{{ old('url') ?? @$description->url ?? '' }}" class="form-control  " required />
</div>
<div class="form-group">
    <label for="meta_description">Поисковое описание</label>
    <textarea name="meta_description" id="meta_description" class="form-control">{{ old('meta_description') ?? @$description->meta_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_keywords">Ключевые слова</label>
    <textarea name="meta_keywords" id="meta_keywords" class="form-control">{{ old('meta_keywords') ?? @$description->meta_keywords ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="description">Описание</label>
    <textarea name="description" id="description" class="form-control editor ">{{ old('description') ?? @$description->description ?? '' }}</textarea>
</div>