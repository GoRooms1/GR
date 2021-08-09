<div class="form-group">
    <label for="name">Наименование</label>
    <input type="text" class="form-control "
           value="{{ old('name') ?? @$rating->name ?? '' }}" name="name" id="name"/>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="sort">Сортировка</label>
    <input type="number" class="form-control "
           value="{{ old('sort') ?? @$rating->sort ?? '' }}" name="sort" id="sort"/>
    @error('sort')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>