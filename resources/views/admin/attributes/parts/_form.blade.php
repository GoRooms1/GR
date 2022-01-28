<div class="form-group required">
  <label for="name">Наименование</label>
  <input type="text" name="name" id="name" value="{{ old('name', @$attribute->name) }}"
         class="form-control @error('name') is-invalid @enderror" required/>
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-group required">
  <label for="category">Категория</label>
  <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
    @foreach($categories AS $category)
      <option value="{{ $category->id }}"
        {{ old('category', isset($attribute) ? $attribute->relationCategory->id : '') === $category->id ? 'selected' : '' }}>
        {{ $category->name }}
      </option>
    @endforeach
  </select>
  @error('category')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

@if($created)
  <div class="form-group required">
    <label for="model">Для</label>
    <select name="model" id="model" class="form-control @error('model') is-invalid @enderror" required>
      @foreach(\App\Models\Attribute::MODELS_TRANSLATE AS $model => $title)
        <option value="{{ $model }}" @if(isset($attribute) && $attribute->model_name === $model) selected @endif>{{ $title }}</option>
      @endforeach
    </select>
    @error('model')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
@endif

<div class="form-group">
  <div class="form-check form-check-inline">
    <input type="hidden" name="in_filter" value="0">
    <input class="form-check-input" type="checkbox" id="in_filter" value="1" name="in_filter"
           @if(@$attribute->in_filter || old('in_filter', 0) === 1)
           checked
      @endif
    >
    <label class="form-check-label" for="in_filter">Участвует в фильтре</label>
  </div>
</div>
<div class="form-group">
  <label for="description">Описание</label>
  <textarea name="description" id="description"
            class="form-control @error('description') is-invalid @enderror">{{ old('description', @$attribute->description) }}</textarea>
  @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

