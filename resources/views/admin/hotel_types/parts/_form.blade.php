<div class="form-group">
    <label for="name">Наименование</label>
    <input type="text" name="name" id="name" value="{{ old('name') ?? @$hotelType->name ?? '' }}"
           class="form-control " required/>
</div>
<div class="form-group">
    <label for="description">Описание</label>
    <textarea name="description" id="description"
              class="form-control ">{{ old('description') ?? @$hotelType->description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="name">Вес сортировки</label>
    <input type="text" name="sort" id="sort" value="{{ old('sort') ?? @$hotelType->sort ?? '' }}"
           class="form-control " required/>
</div>