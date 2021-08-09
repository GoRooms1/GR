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