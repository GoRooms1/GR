@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="h2">Редактирование обьединение "{{ $united->name }}"</div>
    <form class="row" action="{{ route('admin.united_cities.update', $united) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="col-12">

        <div class="row">
          <div class="col-12 col-md-4 col-lg-3">
            <div class="form-group required">
              <label for="name">Наименование</label>
              <input type="text" name="name" id="name" value="{{ old('name', $united->name) }}"
                     class="form-control @error('name') is-invalid @enderror" required/>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-4 col-lg-4">
            <div class="form-group required">
              <label for="name">Города</label>
              <select name="cities[]" class="form-control @error('cities') is-invalid @enderror" id="cities" multiple="multiple" required>
                @foreach($cities as $city)
                  <option value="{{ $city }}" @if(in_array($city, old('cities', $united->united()->toArray()))) selected @endif>{{ $city }}</option>
                @endforeach
              </select>
              @error('cities')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>


        <button class="btn btn-success" type="submit">Обновить</button>
        <a href="{{ route('admin.hotel_types.index') }}" class="btn btn-warning">Отмена</a>
      </div>
    </form>
  </div>
@endsection

@section('js')
  <script>

    $(document).ready(function () {
      $('#cities').select2( {
        placeholder: 'Города',
        closeOnSelect: false,
      })
    })
  </script>
@endsection
