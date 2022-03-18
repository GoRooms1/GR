@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список страниц</div>
          <a href="{{ route('admin.descriptions.create') }}" class="btn btn-primary btn-sm">Новая страница</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.descriptions.index') }}" method="get" id="filter" class="mb-2">
          <div class="row align-items-center">
            <div class="col-md-3 col-lg-2">
              <div class="form-group">
                <label for="type">Тип</label>
                <select name="type" class="form-control" id="type">
                  <option value="">-</option>
                  <option value="city" {{ Request::get('type') === 'city' ? 'selected' : '' }}>Города</option>
                  <option value="area" {{ Request::get('type') === 'area' ? 'selected' : '' }}>Округи</option>
                  <option value="district" {{ Request::get('type') === 'district' ? 'selected' : '' }}>Районы</option>
                  <option value="street" {{ Request::get('type') === 'street' ? 'selected' : '' }}>Улицы</option>
                  <option value="metro" {{ Request::get('type') === 'metro' ? 'selected' : '' }}>Метро</option>
                </select>
              </div>
            </div>

            <div class="col-md-3 col-lg-2">
              <div class="form-group">
                <label for="city">Город</label>
                <select name="city" class="form-control" id="city">
                  <option value="">-</option>
                  @foreach($cities as $city)
                    <option value="{{ $city }}" {{ Request::get('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-3 col-lg-2">
              <div class="form-group">
                <label for="area">Округ</label>
                <select name="area" class="form-control" id="area">
                  <option value="">-</option>
                  @if (Request::get('area', '') !== '')
                    <option value="{{ Request::get('area') }}" selected>{{ Request::get('area') }}</option>
                  @endif
                </select>
              </div>
            </div>

            <div class="col-md-3 col-lg-2">
              <div class="form-group">
                <label for="district">Район</label>
                <select name="district" class="form-control" id="district">
                  <option value="">-</option>
                  @if (Request::get('district', '') !== '')
                    <option value="{{ Request::get('district') }}" selected>{{ Request::get('district') }}</option>
                  @endif
                </select>
              </div>
            </div>

            <div class="col-auto ml-auto mr-3">
              <button type="submit" class="btn btn-primary">Поиск</button>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Заголовок</th>
              <th>Ссылка</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($descriptions AS $page)
              <tr>
                <td>{{ $page->id }}</td>
                <td>
                  <span class="{{ $page->meta_description === null ? 'text-danger' : '' }}">{{ $page->title }}</span>
                </td>
                <td>
                  {{ $page->url }}
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.descriptions.edit', $page) }}" class="btn btn-success">Изменить</a>
                    <button type="button" data-action="{{ route('admin.descriptions.destroy', $page) }}"
                            class="btn btn-danger js-delete">Удалить
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        @php
          $filter = [
            'type' => Request::get('type'),
            'city' => Request::get('city'),
            'area' => Request::get('area'),
            'district' => Request::get('district')
          ];
        @endphp
        <div class="row justify-content-center">
          {{ $descriptions->appends($filter)->links() }}
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script>
    $(document).ready(function () {
      let city = $('#city');
      let area = $('#area')
      let district = $('#district')

      let cityVal = city.val()
      let areaVal = area.val()
      let districtVal = district.val()

      city.change(function () {
        if (city.val() !== '') {
          axios.get('/api/filter/city-area', { params: { city: city.val(), search: '' } })
            .then(r => {
              if (r.data.success) {
                let a = area[0]
                area.find('option')
                  .remove()
                  .end()
                let d = district[0]
                district.find('option')
                  .remove()
                  .end()
                d.add(new Option('-', ''));
                a.add(new Option('-', ''));
                if (r.data.payload.city_areas.length > 0 || Object.keys(r.data.payload.city_areas).length > 0) {
                  for(let item in r.data.payload.city_areas) {
                    let el = r.data.payload.city_areas[item]
                    a.add(new Option(el, el));
                  }
                  if (areaVal !== '') {
                    area.val(areaVal).trigger('change')
                    areaVal = ''
                  }
                } else {
                  area.val(null).trigger('change')
                }
              }
            })
        } else {
          let a = area[0]
          area.find('option')
            .remove()
            .end()
          a.add(new Option('-', ''));
          let d = district[0]
          district.find('option')
            .remove()
            .end()
          d.add(new Option('-', ''));
        }

      })
      area.change(function () {
        if (area.val() !== '') {
          axios.get('/api/filter/district', { params: { city: city.val(), city_area: area.val(), search: '' } })
            .then(r => {
              if (r.data.success) {
                let d = district[0]
                district.find('option')
                  .remove()
                  .end()
                d.add(new Option('-', ''));
                for(let item in r.data.payload.districts) {
                  let el = r.data.payload.districts[item]
                  d.add(new Option(el, el));
                }
                if (districtVal !== '') {
                  district.val(districtVal).trigger('change')
                  districtVal = ''
                }
              }
            })
        }
        else if (city.val() !== '') {
          axios.get('/api/filter/district', { params: { city: city.val(), city_area: '', search: '' } })
            .then(r => {
              if (r.data.success) {
                let d = district[0]
                district.find('option')
                  .remove()
                  .end()
                d.add(new Option('-', ''));
                for(let item in r.data.payload.districts) {
                  let el = r.data.payload.districts[item]
                  d.add(new Option(el, el));
                }
                if (districtVal !== '') {
                  district.val(districtVal).trigger('change')
                  districtVal = ''
                }
              }
            })
        }
        else {
          let d = district[0]
          district.find('option')
            .remove()
            .end()
          d.add(new Option('-', ''));
        }

      })

      if (cityVal !== '') {
        city.trigger('change')
      }
    })
  </script>
@endsection