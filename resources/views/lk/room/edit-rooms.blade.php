@extends('lk.layouts.app')

@section('content')
  <input type="hidden" name="category.update" value="{{ route('lk.category.update') }}">
  <input type="hidden" name="category.create" value="{{ route('lk.category.create') }}">
  <input type="hidden" name="category.delete" value="{{ route('lk.category.delete', '') }}">

  <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
  <section class="part">
    <div class="container">
      <div class="row demonstration">
        <div class="col-12">
          <p class="text">Демонстрация каждого номера объекта в отдельности</p>
        </div>

      </div>
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center category">
            <h2 class="title">Категории номеров</h2>
            <button class="category__add">
              <span>Добавить категорию</span>
              <span class="plus">+</span>
            </button>
          </div>
          <ul class="categories">

            @foreach($hotel->categories as $category)
              <li class="categories__item" data-id="{{ $category->id }}">
                <div class="categories__first categories__first_big">
                  <span class="categories__name categories__hide">{{ $category->name }}</span>
                  <input type="text" class="field field_hidden field_hidden-room" placeholder="Введите категорию">
                </div>

                <div class="categories__control">
                  <button class="categories__custom change-category" id="">
                    <img class="category-change" src="{{ asset('img/lk/pen.png') }}" alt="">
                    <img class="category-good" src="{{ asset('img/lk/check.png') }}" alt="">
                  </button>
                  <button class="categories__custom categories__custom_2 categoryRemove" id="">
                    <img class="category-bin" src="{{ asset('img/lk/bin.png') }}" alt="">
                  </button>
                </div>
              </li>
            @endforeach

            <li class="categories__item">
              <div class="categories__first categories__first_big">
                <span class="categories__name categories__hide"></span>
                <input type="text" class="field field_hidden field_hidden-room" placeholder="Введите категорию">
              </div>

              <div class="categories__control">
                <button class="categories__custom change-category" id="">
                  <img class="category-change" src="{{ asset('img/lk/pen.png') }}" alt="">
                  <img class="category-good" src="{{ asset('img/lk/check.png') }}" alt="">
                </button>
                <button class="categories__custom categories__custom_2 categoryRemove" id="">
                  <img class="category-bin" src="{{ asset('img/lk/bin.png') }}" alt="">
                </button>
              </div>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="part category-list">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <div class="d-flex align-items-center rooms-head">
            <h2 class="title">Список номеров</h2>
            <button class="room__add">
              <span>Добавить номер</span>
              <span class="plus">+</span>
            </button>
          </div>
        </div>
      </div>

      <div id="rooms">
        @foreach($rooms as $room)
          <div class="shadow shadow-complete" data-id="{{ $room->id }}" data-attributes="{{ implode(',', $room->attrs->pluck('id')->toArray()) }}">
            <input type="hidden"
                   name="url"
                   value="{{ route('lk.room.save') }}">
            <input type="hidden"
                   name="url-delete"
                   value="{{ route('lk.room.deleteRoom', $room->id) }}">

            <input type="hidden"
                   name="attributes-get"
                   value="{{ route('lk.room.attr.get', $room->id) }}">
            <input type="hidden"
                   name="attributes-put"
                   value="{{ route('lk.room.attr.put', $room->id) }}">

            <div class="row row__head {{ $room->moderate ? '' : 'row__head_blue' }}">
              <div class="col-1">
                <p class="head-text">#{{ $room->order }}</p>
              </div>
              <div class="col-1 offset-sm-1">
                <p class="head-text">№ {{ $room->number }}</p>
              </div>
              <div class="col-2 offset-sm-1">
                <p class="head-text head-text_bold">{{ $room->name }}</p>
              </div>
              <div class="col-3 offset-sm-2">
                <p class="head-text">{{ $room->category->name ?? '' }}</p>
              </div>
              <div class="col-1 text-right">
                <button class="quote__remove text-white">
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </div>

            {{--          Status--}}
            @if($room->moderate)
              <div class="row">
                <div class="col-12">
                  <p class="text quote__status quote__status_red">Проверка модератором</p>
                </div>
              </div>
            @else
              <div class="row">
                <div class="col-12">
                  <p class="text quote__status quote__status_blue">Опубликовано</p>
                </div>
              </div>

            @endif


            <div class="row room-details">
              <div class="col-2">

                <label class="room-text" for="orderRoom-{{ $room->id }}">Ордер</label>
                <input type="number"
                       min="1"
                       name="order"
                       class="field field_border has-validate-error"
                       id="orderRoom-{{ $room->id }}"
                       placeholder="#1"
                       value="{{ $room->order }}">


              </div>
              <div class="col-2">

                <label class="room-text" for="numberRoom-{{ $room->id }}m">Номер</label>
                <input type="number"
                       min="1"
                       name="number"
                       class="field field_border has-validate-error"
                       id="numberRoom-{{ $room->id }}"
                       placeholder="№1"
                       value="{{ $room->number }}">


              </div>
              <div class="col-4">

                <label class="room-text" for="nameRoom-{{ $room->id }}">Название</label>
                <input type="text"
                       name="name"
                       class="field field_border has-validate-error"
                       id="nameRoom-{{ $room->id }}"
                       placeholder="Название"
                       value="{{ $room->name }}">


              </div>
              <div class="col-4">
                <p class="room-text">
                  Категория
                </p>
                <div class="select has-validate-error-select" id="selectRoom">
                  <input type="hidden" name="category_id" value="{{ $room->category->id ?? '' }}">
                  <div class="select__top select__top_100">
                    <span class="select__current">{{ $room->category->name ?? 'Категория' }}</span>
                    <img class="select__arrow" src="{{ asset('img/lk/arrow.png') }}" alt="">
                  </div>
                  <ul class="select__hidden category__list">
                    @foreach($hotel->categories as $category)
                      <li class="select__item {{ $room->category ? $room->category->id === $category->id ? 'active' : '' : '' }}"
                          data-id="{{ $category->id }}">
                        {{ $category->name }}
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="uploud-photo file-dropzone" data-id="{{$room->id}}" id="file-dropzone"></div>
                <ul class="visualizacao sortable dropzone-previews visualizacao-{{$room->id}}" id="original_items">
                </ul>
                <ul id="cloned_items">
                </ul>
                <div class="preview" style="display:none;">
                  <li>
                    <div>
                      <div class="dz-preview dz-file-preview">
                        <img data-dz-thumbnail/>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                        <div data-dz-success class="dz-success-mark"><span>Проверка модератором</span></div>
                        <div class="dz-error-mark"><span>✘</span></div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                      </div>
                    </div>
                  </li>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-12">
                <p class="uploud__min text">
                  (минимум 1 фотография, максимум 6)
                </p>
              </div>
            </div>
            <div class="row">
              <ul class="hours">
                @foreach($costTypes as $type)
                  @php
                    $id = $type->id;
                    $costRoom = $room->costs()->whereHas('period', function ($q) use($id) {
                      $q->where('cost_type_id', $id);
                    })->first();
                  @endphp
                  <li class="hour">
                    <p class="heading hours__heading">
                      {{ $type->name }}
                    </p>
                    <div class="d-flex align-items-center">
                      <input type="number"
                             min="0"
                             class="field hours__field has-validate-error"
                             id="value-{{ $room->id }}-{{$type->id}}"
                             placeholder=""
                             value="{{ $costRoom->value ?? null }}">

                      <div class="hours__hidden">
                        <span class="hours__money"></span>
                        <span class="hours__rub">руб.</span>
                      </div>

                      <span class="rub">руб.</span>

                      <div class="select has-validate-error-select hours__select">
                        <input type="hidden"
                               name="type[]"
                               data-id="{{$type->id}}"
                               value="{{ $costRoom->period->id ?? null }}">

                        <div class="select__top">
                          <span class="select__current">{{ $costRoom->period->info ?? 'Период' }}</span>
                          <img class="select__arrow"
                               src="{{ asset('img/lk/arrow.png') }}" alt="">
                        </div>
                        <ul class="select__hidden">
                          @foreach($type->periods as $period)
                            <li class="select__item" data-id="{{ $period->id }}">{{ $period->info }}</li>
                          @endforeach
                        </ul>
                      </div>
                      <span class="hours__after">
                        {{ $costRoom->period->info ?? 'Период' }}
                      </span>
                    </div>
                    </div>
                    <div class="align-items-center pt-4 pb-3 d-none">
                      <button class="costs_calendar__open mx-auto"                        
                        data-cost-id="{{ $costRoom->id }}"
                        data-room-name="{{ $room->name }}"
                        data-category-name="{{ $room->category->name }}"
                        data-period="{{ $type->name }}"
                        data-avg-value="{{ $costRoom->avg_value ?? $costRoom->value}}"
                      >                      
                        <span class="plus">+</span>
                      </button>
                    </div> 
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="row more-details">
              <div class="col-12">
                <p class="text {{ $room->attrs()->count() === 0 ? 'is-invalid form-control' : '' }}">Детально о номере</p>
                <p class="caption caption_mt">
                  Выберите пункты наиболее точно отражающие преимущества данного номера
                  / группы номеров. (минимум 3, максимум 9 пунктов)
                </p>
              </div>

            </div>

            <div class="row">
              <div class="col-12">
                <div class="mt-2 attributes-list">
                  @foreach($room->attrs as $a)
                    <span>{{ $a->name . (!$loop->last ? ',' : '') }}</span>
                  @endforeach
                </div>
              </div>
              <div class="col-12">
                <a class="show-all show-all_orange" data-room-id="{{ $room->id }}">Показать все</a>
              </div>
            </div>
            <div class="row row__bottom">
              <div class="col-12">
                <div class="d-flex align-items-center quote__buttons">
                  <button class="button save-room" id="saveRoom">Сохранить</button>
                  <button class="quote__read quote__read_1">
                    <img src="{{ asset('img/lk/pen.png') }}" alt="">
                  </button>
                  <button class="quote__remove remove-btn">
                    <i class="fa fa-trash"></i>
                  </button>

                </div>
              </div>
            </div>

          </div>
        @endforeach
      </div>

    </div>
  </section>

  <div class="shadow shadow-now d-none" id="new_room">

    <input type="hidden"
           name="url"
           value="{{ route('lk.room.save') }}">
    <input type="hidden"
           name="url-delete"
           value="{{ route('lk.room.deleteRoom', '') }}">

    <input type="hidden"
           name="attributes-get"
           value="{{ route('lk.room.attr.get', '') }}">
    <input type="hidden"
           name="attributes-put"
           value="{{ route('lk.room.attr.put', '') }}">

    <div class="row row__head">
      <div class="col-1">
        <p class="head-text"></p>
      </div>
      <div class="col-1 offset-sm-1">
        <p class="head-text"></p>
      </div>
      <div class="col-2 offset-sm-1">
        <p class="head-text head-text_bold"></p>
      </div>
      <div class="col-3 offset-sm-2">
        <p class="head-text"></p>
      </div>
      <div class="col-1 text-right">
        <button class="quote__remove" style="color: white;">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>

    <div class="row row-status">
      <div class="col-12">
        <p class="text quote__status quote__status_red">Проверка модератором</p>
      </div>
    </div>

    <div class="row room-details">
      <div class="col-2">
        <label class="room-text" for="orderRoom">Ордер</label>
        <input type="number"
               name="order"
               min="1"
               class="field field_border has-validate-error"
               id="orderRoom"
               placeholder="#1"
               autofocus>
      </div>
      <div class="col-2">
        <label class="room-text" for="numberRoom">Номер</label>
        <input type="number"
               name="number"
               min="1"
               class="field field_border has-validate-error"
               id="numberRoom"
               placeholder="№1">
      </div>
      <div class="col-4">
        <label class="room-text" for="nameRoom">Название</label>
        <input type="text"
               name="name"
               class="field field_border has-validate-error"
               id="nameRoom"
               placeholder="Название">
      </div>
      <div class="col-4">
        <p class="room-text">
          Категория
        </p>
        <div class="select has-validate-error-select" id="selectRoom">
          <input type="hidden" name="category_id">
          <div class="select__top select__top_100">
            <span class="select__current">Категория</span>
            <img class="select__arrow" src="{{ asset('img/lk/arrow.png') }}" alt="">
          </div>
          <ul class="select__hidden category__list">
            @foreach($hotel->categories as $category)
              <li class="select__item"
                  data-id="{{ $category->id }}">
                {{ $category->name }}
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
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
                <div data-dz-success class="dz-success-mark"><span>Проверка модератором</span></div>
                <div class="dz-error-mark"><span>✘</span></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
              </div>
            </div>
          </li>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-12">
        <p class="uploud__min text">
          (минимум 1 фотография, максимум 6)
        </p>
      </div>
    </div>
    <div class="row">
      <ul class="hours">
        @foreach($costTypes as $type)
          @php
            $id = $type->id;
          @endphp
          <li class="hour" data-id="{{ $type->id }}">
            <p class="heading hours__heading">
              {{ $type->name }}
            </p>
            <div class="d-flex align-items-center">
              <input type="number"
                     min="0"
                     value=""
                     class="field hours__field has-validate-error"
                     id="value"
                     placeholder="">

              <div class="hours__hidden">
                <span class="hours__money"></span>
                <span class="hours__rub">руб.</span>
              </div>

              <span class="rub">руб.</span>

              <div class="select has-validate-error-select hours__select">
                <input type="hidden"
                       name="type[]"
                       data-id="{{$type->id}}"
                       value=""
                >

                <div class="select__top">
                  <span class="select__current">Период</span>
                  <img class="select__arrow"
                       src="{{ asset('img/lk/arrow.png') }}" alt="">
                </div>
                <ul class="select__hidden">
                  @foreach($type->periods as $period)
                    <li class="select__item" data-id="{{ $period->id }}">{{ $period->info }}</li>
                  @endforeach
                </ul>
              </div>
              <span class="hours__after">
                Период
              </span>
            </div>            
          </li>
        @endforeach
      </ul>
    </div>
    <div class="row more-details">
      <div class="col-12">
        <p class="text is-invalid form-control">Детально о номере</p>
        <p class="caption caption_mt">
          Выберите пункты наиболее точно отражающие преимущества данного номера / группы номеров. (минимум 3, максимум 9 пунктов)
        </p>
      </div>

    </div>

    <div class="row">
      <div class="col-12">
        <div class="mt-2 attributes-list">

        </div>
      </div>
      <div class="col-12">
        <a class="show-all show-all_orange">Показать все</a>
      </div>
    </div>
    <div class="row row__bottom">
      <div class="col-12">
        <div class="d-flex align-items-center quote__buttons">
          <button class="button save-room" id="saveRoom">Сохранить</button>
          <button class="quote__read quote__read_1">
            <img src="{{ asset('img/lk/pen.png') }}" alt="">
          </button>
          <button class="quote__remove remove-btn">
            <i class="fa fa-trash"></i>
          </button>

        </div>
      </div>
    </div>

  </div>


  @include('lk.room.__popup_attributes', [$attribute_categories])
  @include('lk.room.__popup_costs_calendar')


@endsection

@section('header-js')
  <script src="{{ asset('js/lk/room.js') }}"></script>
@endsection

@section('js')
  <script>
    Dropzone.autoDiscover = false;
    let blockDropZone =  $('.file-dropzone')
    let uploader = []
    let mockFile
    let existFile = []

    $(document).ready(function () {
      $('.sortable').each(function () {
        let sortable = this
        $(sortable).sortable({
          items: '.dz-image-preview',
          update: function (event, ui) {
            let ids = [];
            $(sortable).find("li").each(function(i) {
              ids.push($(this).attr('data-id'))
            });
            console.log(ids)

            axios.post('/api/images/ordered', {
              ids
            })
              .catch(e => {
                if (e.response.data.message) {
                  alert(e.response.data.message)
                }
              })
          }
        });
      })

      $('.quote__read').each(function () {
        saveFrontData.call(this, true)
      })

      blockDropZone.each(function() {
        let zone = this
        // instantiate the uploader
        if ($(zone).hasClass('dropzone_disabled')) {

        } else {
          // Dropzone initial
          uploader[zone.dataset.id] = new Dropzone(this, initialDropZone.call(this) );
        }
      })

      @foreach($rooms as $room)
        existFile[{{ $room->id }}] = []
        @foreach($room->getMedia('images') as $image)

          existFile[{{ $room->id }}].push({
            id: "{{ $image->id }}",
            name: "{{ $image->name }}",
            path: "{{ $image->getUrl() }}",
            moderate_text: "{{ $image->getCustomProperty('moderate') ? 'Проверка модератором' : 'Опубликовано' }}",
            moderate: {!! $image->getCustomProperty('moderate')  ? 'true' : 'false' !!}
          })

          mockFile = { name: '{{ $image->name }}', dataURL: '{{ $image->getUrl() }}', size: "{{ $image->size }}" };
          uploader[{{ $room->id }}].emit("addedfile", mockFile);
          uploader[{{ $room->id }}].emit("thumbnail", mockFile, '{{ $image->getUrl() }}');
          uploader[{{ $room->id }}].emit("complete", mockFile);
          uploader[{{ $room->id }}].files.push(mockFile)

        @endforeach
      @endforeach


    });

    function initialDropZone () {
      let zone = this
      return {
        url: "{{ route('lk.room.image.upload') }}",
        maxFiles: 6,
        paramName: "image",
        thumbnailWidth: 352,
        thumbnailHeight: 260,
        addRemoveLinks: true,
        previewsContainer: '.visualizacao-' + zone.dataset.id,
        previewTemplate: $(zone).siblings('.preview').html(),
        acceptedFiles: "image/*",
        headers: {
          'x-csrf-token': "{{ csrf_token() }}",
        },
        sending: function(file, xhr, formData) {
          formData.append('model_name', "Room")
          formData.append('modelID', zone.dataset.id)
        },
        init: function () {
          this.on("complete", function (file) {

            let f = findExistImage(file, existFile[zone.dataset.id])
            console.log(f)

            let d = file.previewElement.querySelector("[data-dz-success]");
            d.innerHTML = f.moderate_text

            file.previewElement.dataset.id = f.id

            if (!f.moderate) {
              d.style.color="#2f64ad"
            }

            $(".dz-remove").html("<span class='upload__remove'><i class='fa fa-trash' aria-hidden='true'></i></span>");
            let str = $('ul.visualizacao-' + zone.dataset.id).get(0)
            $(zone).appendTo(str)

            if (existFile[zone.dataset.id].length >= 6) {
              $(zone).hide()
            }
          });
          this.on('success', function (file, json) {
            console.log(json)
            let image = json.payload.images[0]
            existFile[zone.dataset.id].push({
              id: image.id,
              path: image.url,
              name: image.name,
              moderate_text: image.moderate ? 'Проверка модератором' : 'Опубликовано',
              moderate: image.moderate
            })

            if (typeof blockSaveRoom === "function") {
              blockSaveRoom($('.shadow[data-id=' + zone.dataset.id + ']'))
            }
          });
          this.on("addedfile", function(file) {
            if (this.files[6] != null){
              this.removeFile(this.files[6], existFile[zone.dataset.id]);
              existFile[zone.dataset.id].pop();
              console.log(file, this.files.length, this.options.maxFiles)
            }
          });
          this.on("reset", function (file) {
            $(zone).show()
          });
          // this.on('queuecomplete', function (file) {
          //   $(this).parents(".shadow").find('.uploud__min').hide()
          // });
          this.on("removedfile", function (file) {
            console.log(file)
            if (existFile[zone.dataset.id].length === 1) {
              if (file.xhr) {
                let image = JSON.parse(file.xhr.response).payload.images[0]
                console.log(image.url)
                mockFile = { name: file.name, dataURL: image.url, size: 0 };
              } else {
                mockFile = { name: file.name, dataURL: file.dataURL, size: 0 };
              }

              uploader[zone.dataset.id].displayExistingFile(file, mockFile.dataURL)
              return false;
            }

            let flag = false
            existFile[zone.dataset.id].forEach(f => {
              if(f.path === file.dataURL) {
                flag = true
                let url = "{{ url('lk/room/image/delete/') }}" + '/' + f.id
                axios.post(url)
                  .then(response => {
                    console.log(response)
                    let index = existFile[zone.dataset.id].indexOf(f)
                    if (index > -1) {
                      existFile[zone.dataset.id].splice(index, 1);
                    }
                  })
                  .catch(error => {
                    alert('Ошибка при удалении')
                  })
              }
            })
            if (!flag) {
              existFile[zone.dataset.id].forEach(f => {
                if(f.id === JSON.parse(file.xhr.response).payload.images[0].id) {
                  flag = true
                  let url = "{{ url('lk/room/image/delete/') }}" + '/' + f.id
                  axios.post(url)
                    .then(response => {
                      console.log(response)
                      let index = existFile[zone.dataset.id].indexOf(f)
                      if (index > -1) {
                        existFile[zone.dataset.id].splice(index, 1);
                      }
                    })
                    .catch(error => {
                      alert('Ошибка при удалении')
                    })
                }
              })
            }

            setTimeout(() => {
              if (this.files.length < 6) {
                $(zone).show()
              }
            }, 600)
          })
        }
      }
    }

    function removeFile (file, existFile) {
      if (this.files.length > this.options.maxFiles) {
        this.removeFile(this.files[0]);
        existFile.shift();
        console.log(file, this.files.length, this.options.maxFiles)
      } else {
        removeFile.call(this, file)
      }
    }

  </script>
@endsection