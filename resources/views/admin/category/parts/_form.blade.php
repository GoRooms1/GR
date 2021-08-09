<div class="form-group">
    <label for="name">Наименование</label>
    <input type="text" class="form-control "
           value="{{ old('name') ?? @$category->name ?? '' }}" name="name" id="name"/>
</div>
<div class="form-group">
    <label for="description">Описание</label>
    <textarea type="text" class="form-control " name="description"
              id="description">{{ old('description') ?? @$category->description ?? '' }}</textarea>
</div>