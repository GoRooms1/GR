<div class="form-group">
    <label for="title">Наименование</label>
    <input type="text" name="title" id="title" value="{{ old('title') ?? @$page->title ?? '' }}" class="form-control " required/>
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="slug">Ссылка</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug') ?? @$page->slug ?? '' }}" class="form-control  " required />
    @error('slug')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="content">Описание</label>
    <textarea name="content" id="content" class="form-control editor ">{{ old('content') ?? @$page->content ?? '' }}</textarea>
    @error('content')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="header">Вставка перед {{ '</head>' }}</label>
    <textarea name="header" id="header"
              class="form-control  ">{{ old('header') ?? @$page->header ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="footer">Вставка перед {{ '</body>' }}</label>
    <textarea name="footer" id="footer"
              class="form-control  ">{{ old('footer') ?? @$page->footer ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_title">Тайтл</label>
    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') ?? @$page->meta_title ?? '' }}" class="form-control "/>
</div>
<div class="form-group">
    <label for="meta_description">Мета описание</label>
    <textarea name="meta_description" id="meta_description"
              class="form-control  ">{{ old('meta_description') ?? @$page->meta_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_keywords">Мета ключи</label>
    <textarea name="meta_keywords" id="meta_keywords"
              class="form-control  ">{{ old('meta_keywords') ?? @$page->meta_keywords ?? '' }}</textarea>
</div>
