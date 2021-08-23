@extends('lk.layouts.app')

@section('content')

  <section class="gray part">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title">Объект</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-12">
          <p class="heading">{{ $hotel->name }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <p class="heading">Тип: {{ $hotel->type->name }}</p>
        </div>
      </div>
      <form action="{{ route('lk.object.update') }}" method="POST">
        @csrf
        <input type="hidden" value="phone" name="type_update">
        <div class="row part__content">
          <div class="col-4">
            <input type="phone"
                   class="field form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $hotel->phone) }}"
                   name="phone_2"
                   placeholder="Телефон 1 объекта"
                   required
            >
            @error('phone')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="col-4">
            <input type="phone"
                   class="field form-control @error('phone_2') is-invalid @enderror"
                   value="{{ old('phone_2', $hotel->phone_2) }}"
                   name="phone_2"
                   placeholder="Телефон 2 объекта"
            >
            @error('phone_2')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
           @enderror
          </div>
          <div class="col-4">
            <input type="email"
                   class="field form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $hotel->email) }}"
                   name="email"
                   placeholder="Email объекта для бронирований"
                   required
            >
            @error('email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>
        <div class="row part__bottom">
          <div class="col-12">
            <button class="button save-button" type="submit" id="save1">Сохранить</button>
          </div>
        </div>
      </form>

    </div>
  </section>
  <section class="part">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title">Адрес</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-8">
          <p class="caption">Вы можете указать дополнительную информацию к адресу, чтобы посетителям было понятнее.
            Например: «Вход через арку» или «2й этаж, направо»</p>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-12">
          <div class="d-flex align-items-center">
            <p class="text-bold adress">Адрес объекта: </p>
            <p class="text">
              {{ $hotel->address->value }}
            </p>
          </div>
        </div>

      </div>
      <form action="{{ route('lk.object.update') }}" method="POST">
        @csrf
        <input type="hidden" value="address" name="type_update">
        <div class="row">
          <div class="col-12">
            <div class="d-flex align-items-start">
              <p class="text-bold adress">Комментарий к адресу: </p>
              <input class="bordered form-control field @error('comment') is-invalid @enderror"
                     name="comment"
                     value="{{ old('comment', $hotel->address->comment) }}"
                     placeholder="Введите текст">

              @error('comment')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
        </div>


        <div class="row part__bottom">
          <div class="col-12">
            <button class="button" type="submit">Сохранить</button>

          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="part gray">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title">Информация об отеле</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-11">
          <p class="caption">Расскажите подробнее о Вашем объекте, его преимущества, местоположение, дополнительный сервис для гостей. Текст должен быть уникальным и содержать не менее 1500 знаков. Заполнив данное поле вы увеличиваете вероятность просмотров
            Вашего объекта до 20%.</p>
        </div>
      </div>

      <form action="{{ route('lk.object.update') }}" method="POST">
        @csrf
        <input type="hidden" value="description" name="type_update">
        <div class="row part__content">
          <div class="col-10">
            <textarea placeholder="Введите текст"
                      name="description"
                      id="editor"
                      class="field form-control @error('description') is-invalid @enderror">
              {!! old('description', $hotel->description) !!}
            </textarea>
            @error('description')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row part__bottom">
          <div class="col-12">
            <button class="button" type="submit">Сохранить</button>

          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="part gray">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title">Ближайшие станции метро</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-12">
          <p class="caption">Выберите ближайшие станции метро к Вашему объекту размещения и укажите за какое время можно добраться до объекта пешком в минутах.</p>
        </div>
      </div>
      <form action="{{ route('lk.object.update') }}" method="POST">
        @csrf
        <input type="hidden" value="metros" name="type_update">
        <div id="metro" class="row part__content">
          @forelse($hotel->metros as $index => $m)
            <div class="col-12" data-id="{{ $m->id }}">
              <div class="d-flex align-items-center station">
                <div class="select" style="width: 45%">
                  <select name="metros[]" class="form-control field metros w-100" required>
                    <option value="{{ $m->name }}">{{ $m->name }}</option>
                  </select>
                </div>
                <input type="hidden" name="metros_color[]" value="{{ $m->color }}">
                <input type="number" min="1" name="metros_time[]" value="{{ $m->distance }}" class="field field_small station-field" required>
                <p class="text">минут пешком до объекта</p>
                <button onclick="deleteMetro({{ $m->id }})" type="button" class="mx-3 button w-auto px-3">-</button>
              </div>
            </div>
          @empty
            <div class="col-12" data-id="1">
              <div class="d-flex align-items-center station">
                <div class="select" style="width: 45%">
                  <select name="metros[]" class="form-control field metros w-100" required>
                  </select>
                </div>
                <input type="hidden" name="metros_color[]">
                <input type="number" min="1" name="metros_time[]" class="field field_small station-field" required>
                <p class="text">минут пешком до объекта</p>
                <button onclick="deleteMetro(1)" type="button" class="mx-3 button w-auto px-3">-</button>
              </div>
            </div>
          @endforelse

        </div>
        <div class="row part__bottom">
          <div class="col-12">
            <button onclick="addMetro()" type="button" class="button">Добавить станцию</button>

          </div>
        </div>
        @error('metros')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
        <div class="row part__bottom">
          <div class="col-12">
            <button class="button" type="submit">Сохранить</button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="part">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title">Прайс лист отеля</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-12">
          <p class="caption">Стоимость и условия проживания в данном разделе, формируются автоматически, как только Вы установите цены в Разделе "Календарь цен",
            система автоматически выберет самое доступное предложение и укажет его как минимальную цену в Объекте.</p>
        </div>
      </div>

      <div class="row part__content">
        <div class="col-12">
          <table class="prices">
{{--            TODO: Выводить стоимость по комнатам, самую минимульную, или рандомную )--}}
            @foreach ($hotel->minimals as $min)
              <tr>
                <td class="prices__main">{{ $min['name'] }} - от {{ $min['value'] }} руб.</td>
                <td class="text">{{ $min['info'] }}</td>
              </tr>
            @endforeach

          </table>
        </div>
      </div>
    </div>
  </section>

  <section class="part gray">
    <form action="{{ route('lk.object.update') }}" method="post">
      @csrf
      <input type="hidden" name="type_update" value="attr">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title">Детально об отеле</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-12">
          <p class="caption">Выберите пункты наиболее точно отражающие преимущества Вашего объекта размещения (минимум 3, максимум 9 пунктов).</p>
        </div>
      </div>

      <div class="row part__content">
        <div class="col-12">
          <ul class="details">
            @foreach($attributeCategories as $category)
              <li class="detail">
                <p class="text-bold_small details__title">{{ $category->name }}</p>

                @foreach($category->attributes as $attr)
                  <div class="choice">
                    <input type="hidden" id="attr-{{ $attr->id }}-h" name="attr[{{ $attr->id }}]" value="false">
                    <input type="checkbox"
                           id="attr-{{ $attr->id }}"
                           value="true"
                           name="attr[{{ $attr->id }}]"
                           {{ $hotel->attrs->contains('id', $attr->id) ? 'checked' : '' }}
                    >
                    <div class="check">
                      <div class="check__flag"></div>
                    </div>
                    <label for="attr-{{ $attr->id }}">{{ $attr->name }}</label>
                  </div>
                @endforeach
              </li>
            @endforeach
          </ul>
        </div>

      </div>
      <div class="row part__bottom">
        <div class="col-12">
          <button class="button" type="submit">Сохранить</button>

        </div>
      </div>
    </div>
    </form>
  </section>

  <section class="part">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title">Фото объекта</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-12">
          <p class="caption">Загрузите фотографии объекта размещения. По этим фотографиям клиент сможет составить общее представление о Вашем объекте и выбрать его. Рекомендуем загрузить самые лучшие фотографии объекта. (минимум 1 фотография, максимум 6)</p>
        </div>
      </div>

      <div class="row part__content">
        <div class="col-12">

          <div class="uploud-photo" id="file-dropzone"></div>
          <ul class="visualizacao sortable dropzone-previews" id="original_items">
          </ul>
          <ul id="cloned_items">
          </ul>
          <div class="preview" style="display:none;">
            <li>
              <div>
                <div class="dz-preview dz-file-preview">
                  <img data-dz-thumbnail />
                  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                  <div class="dz-success-mark"><span>Проверка модератором</span></div>
                  <div class="dz-error-mark"><span>✘</span></div>
                  <div class="dz-error-message"><span data-dz-errormessage></span></div>
                </div>
              </div>
            </li>
          </div>
        </div>
      </div>

    </div>
  </section>

@endsection

@section('js')
  <script>

    $(document).ready(function() {
      selectInit()
    });

    let metros_ids = {{ $hotel->metros->pluck('distance')->max() ?? 1 }};

    function addMetro() {
      metros_ids++;
      $('#metro').append(
        "<div class='col-12' data-id='" + metros_ids + "'>" +
          "<div class='d-flex align-items-center station'>" +
            "<div class='select' style='width: 45%'>" +
              "<select name='metros[]' class='form-control field metros w-100' required></select>" +
            "</div>" +
            "<input type='hidden' name='metros_color[]' class='color'>" +
            "<input type='number' name='metros_time[]' class='form-control field field_small station-field' required>" +
            "<p class='text'>минут пешком до объекта</p>" +
            "<button onclick='deleteMetro(" + metros_ids +")' class='mx-3 button w-auto px-3'>-</button>" +
          "</div>" +
        "</div>"
      )

      selectInit()

      $('.metros').on("select2:select", takeColor);
    }

    function selectInit () {
      $('.metros').select2({
        placeholder: "Название станции",
        language: "ru",
        ajax: {
          delay: 250,
          type: "POST",
          headers: {
            "Content-Type": 'application/json',
            "Accept": 'application/json',
            "Authorization": "Token be33fe1fe0328828d9632c248dcad68166e62740"
          },
          url: 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/metro',
          data: function (params) {
            return JSON.stringify({
              query: params.term,
              filters: [
                {
                  "city": '{{ $hotel->address->city }}',
                }
              ]
            })
          },
          processResults: function (data) {
            return {
              results: data.suggestions.map((e) => {
                return {
                  text: e.value,
                  id: e.value,
                  color: e.data.color
                };
              })
            };
          }
        }
      });
    }

    $('.metros').on("select2:select", takeColor);

    function takeColor (e) {
      console.log($(e.currentTarget).parent().parent().children('input[type="hidden"]').get(0).value = e.params.data.color)
      console.log(e.params.data.color);
    }

    function deleteMetro(id) {
      let str = '[data-id=' + id + ']'
      console.log($(str).remove())
    }


    $("#address").suggestions({
      token: "a35c9ab8625a02df0c3cab85b0bc2e9c0ea27ba4",
      type: "ADDRESS",
    });
    $("input[type='phone']").mask("+7 (999) 999 99-99");
    ClassicEditor
      .create( document.querySelector( '#editor' ) )
      .catch( error => {
        console.error( error );
      } );

    ClassicEditor
      .create( document.querySelector( '#editor2' ) )
      .catch( error => {
        console.error( error );
      } );

    $(document).ready(function(){
      $('.sortable').sortable({
        items: '.dz-image-preview',
      });

    });

    //DropzoneJS snippet - js
    Dropzone.autoDiscover = false;
    // instantiate the uploader
    const uploader = new Dropzone('#file-dropzone', {
      paramName: "image",
      url: "{{ route('lk.object.image.upload') }}",
      maxFiles: 6,
      thumbnailWidth: 360,
      thumbnailHeight: 260,
      addRemoveLinks: true,
      previewsContainer: '.visualizacao',
      previewTemplate : $('.preview').html(),
      acceptedFiles: "image/*",
      headers: {
        'x-csrf-token': "{{ csrf_token() }}",
      },
      sending: function(file, xhr, formData) {
        formData.append('model_name', "Hotel")
        formData.append('modelID', "{{$hotel->id}}")
      },
      init: function() {

        this.on("complete", function (file) {
          $(".dz-remove").html("<span class='upload__remove'><i class='fa fa-trash' aria-hidden='true'></i></span>");
          $('#file-dropzone').appendTo('.visualizacao')
        });

        this.on('completemultiple', function (file, json) {

          // $('.sortable').sortable({
          // 	items: '.dz-image-preview',
          // });

          // if (this.files.length > 6) {
          //   this.removeFile(this.files[0]);
          // }

        });
        this.on("maxfilesexceeded", function(file) {

        });

        this.on('success', function (file, json) {
          console.log(json)
          let image = json.payload.images[0]
          let word = 'image'
          existFile.push({
            id: image.id,
            path: "{{ url('/') }}" + "/" + image.path,
            name: image.name
          })
        });

        this.on("addedfile", function(event) {
          console.log(this)
          while (this.files.length  > this.options.maxFiles) {
            this.removeFile(this.files[0]);
            console.log(event, this.files.length, this.options.maxFiles)
          }
        });


        this.on("reset", function (file) {
          $('#file-dropzone').show()

        });

        this.on('drop', function (file) {
        });
        this.on("removedfile", function (file) {
          console.log(file)
          if (existFile.length === 1) {
            if (file.xhr) {
              let image = JSON.parse(file.xhr.response).payload.images[0]
              console.log("{{ url('/') }}" + "/"+ image.path)
              mockFile = { name: file.name, dataURL: "{{ url('/') }}" + "/"+ image.path, size: 0 };
            } else {
              mockFile = { name: file.name, dataURL: file.dataURL, size: 0 };
            }

            uploader.displayExistingFile(file, mockFile.dataURL)
            return false;
          }

          let flag = false
          existFile.forEach(f => {
            if(f.path === file.dataURL) {
              flag = true
              let url = "{{ url('lk/object/image/delete/') }}" + '/' + f.id
              axios.post(url)
                .then(response => {
                  console.log(response)
                  let index = existFile.indexOf(f)
                  if (index > -1) {
                    existFile.splice(index, 1);
                  }
                })
                .catch(error => {
                  alert('Ошибка при удалении')
                })
              return;
            }
          })
          if (!flag) {
            existFile.forEach(f => {
              if(f.id === JSON.parse(file.xhr.response).payload.images[0].id) {
                flag = true
                let url = "{{ url('lk/object/image/delete/') }}" + '/' + f.id
                axios.post(url)
                  .then(response => {
                    console.log(response)
                    let index = existFile.indexOf(f)
                    if (index > -1) {
                      existFile.splice(index, 1);
                    }
                  })
                  .catch(error => {
                    alert('Ошибка при удалении')
                  })
                return;
              }
            })
          }
        })
      }
    });
    let mockFile
    let existFile = []

    @foreach($hotel->images as $image)

      existFile.push({
        id: "{{ $image->id }}",
        name: "{{ $image->name }}",
        path: "{{ url($image->path) }}"
      })

      mockFile = { name: '{{ $image->name }}', dataURL: '{{ url($image->path) }}' , size: {{ File::size($image->getRawOriginal('path')) }} };
      uploader.emit("addedfile", mockFile);
      uploader.emit("thumbnail", mockFile, '{{ url($image->path) }}');
      uploader.emit("complete", mockFile);
      uploader.files.push(mockFile)
    @endforeach
  </script>
@endsection