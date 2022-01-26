<div class="form-group required">
  <label for="name">Наименование (уникальное)</label>
  <input type="text"
         name="name"
         id="name"
         value="{{ old('name', @$c->name) }}"
         class="form-control @error('name') is-invalid @enderror"
         required
  >
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-group">
  <label for="description">Описание</label>
  <input type="text"
         name="description"
         id="description"
         value="{{ old('description', @$c->description) }}"
         class="form-control @error('description') is-invalid @enderror"
  >
  @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>