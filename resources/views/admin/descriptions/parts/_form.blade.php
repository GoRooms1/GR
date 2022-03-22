<div class="form-group required">
    <label for="title">Заголовок</label>
    <input type="text" name="title" id="title" value="{{ old('title') ?? @$description->title ?? '' }}" class="form-control " required/>
</div>
<div class="form-group {{ ($description->type === 'metro' || $description->type === 'street' || $description->type === 'district' || $description->type === 'area' || $description->type === 'city') ? 'required' : ''  }}">
    <label for="h1">H1</label>
    <input type="text" name="h1" id="h1" value="{{ old('h1') ?? @$description->h1 ?? '' }}" class="form-control" {{ ($description->type === 'metro' || $description->type === 'street' || $description->type === 'district' || $description->type === 'area' || $description->type === 'city') ? 'required' : ''  }}/>
</div>
<div class="form-group required">
    <label for="url">Ссылка</label>
    <input type="text" name="url" id="url" value="{{ old('url') ?? @$description->url ?? '' }}" class="form-control  " required />
</div>
<div class="form-group required">
    <label for="meta_description">Поисковое описание</label>
    <textarea name="meta_description" id="meta_description" required class="form-control">{{ old('meta_description') ?? @$description->meta_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_keywords">Ключевые слова</label>
    <textarea name="meta_keywords" id="meta_keywords" class="form-control">{{ old('meta_keywords') ?? @$description->meta_keywords ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="description">Описание</label>
    <textarea name="description" id="description" class="form-control editor ">{{ old('description') ?? @$description->description ?? '' }}</textarea>
</div>