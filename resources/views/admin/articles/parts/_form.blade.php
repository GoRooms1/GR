<div class="form-group">
    <label for="title">Наименование</label>
    <input type="text" name="title" id="title" value="{{ old('title') ?? @$article->title ?? '' }}" class="form-control" required/>
</div>
<div class="form-group">
    <label for="slug">Ссылка</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug') ?? @$article->slug ?? '' }}" class="form-control" required />
</div>
<div class="form-group">
    <label for="notice">Краткое описание</label>
    <textarea name="notice" id="notice" class="form-control" style="height: 200px">{{ old('notice') ?? @$article->notice ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="content">Описание</label>
    <textarea name="content" id="content" class="form-control editor">{{ old('content') ?? @$article->content ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_title">Тайтл</label>
    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') ?? @$article->meta_title ?? '' }}" class="form-control "/>
</div>
<div class="form-group">
    <label for="meta_description">Мета описание</label>
    <textarea name="meta_description" id="meta_description"
              class="form-control  ">{{ old('meta_description') ?? @$article->meta_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_keywords">Мета ключи</label>
    <textarea name="meta_keywords" id="meta_keywords"
              class="form-control  ">{{ old('meta_keywords') ?? @$article->meta_keywords ?? '' }}</textarea>
</div>
<div class="form-check pb-4">
    <input type="hidden" name="published" value="0"> 
    <input type="checkbox" class="form-check-input" name="published" id="published" class="form-control"
        @if (isset($article) ? $article->published : false) checked @endif
    />
    <label for="published" class="form-check-label">Опубликовано</label>  
</div>