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
      <div class="row part__content">
        <div class="col-4">
          <input type="phone" class="field" value="{{ $hotel->phone }}" name="phone" placeholder="Телефон 1 объекта">
        </div>
        <div class="col-4">
          <input type="phone" class="field" value="{{ $hotel->phone_2 }}" name="phone_2" placeholder="Телефон 2 объекта">
        </div>
        <div class="col-4">
          <input type="email" class="field" value="{{ $hotel->email }}" name="email" placeholder="Email объекта для бронирований">
        </div>
      </div>
      <div class="row part__bottom">
        <div class="col-12">
          <button class="button save-button" id="save1">Сохранить</button>

        </div>
      </div>
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

      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-start">
            <p class="text-bold adress">Комментарий к адресу: </p>
            <textarea class="bordered comment-field" placeholder="Введите текст">{{ old('comment', $hotel->address->comment) }}</textarea>
          </div>
        </div>

      </div>

      <div class="row part__bottom">
        <div class="col-12">
          <button class="button">Сохранить</button>

        </div>
      </div>
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

      <div class="row part__content">
        <div class="col-10">
          <textarea placeholder="Введите текст" id="editor">{!! old('description', $hotel->description) !!}</textarea>
        </div>
      </div>
      <div class="row part__bottom">
        <div class="col-12">
          <button class="button">Сохранить</button>

        </div>
      </div>
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

      <div id="metros" class="row part__content">
        <div class="col-12" data-id="1">
          <div class="d-flex align-items-center station">
            <div class="select" style="width: 45%">
              <select name="metro[]" class="metro w-100"></select>
            </div>
            <input type="number" name="metro_time[]" class="field field_small station-field">
            <p class="text">минут пешком до объекта</p>
            <button onclick="deleteMetro(1)" class="mx-3 button w-auto px-3">-</button>
          </div>
        </div>

      </div>
      <div class="row part__bottom">
        <div class="col-12">
          <button onclick="addMetro()" class="button">Добавить станция</button>

        </div>
      </div>
      <div class="row part__bottom">
        <div class="col-12">
          <button class="button">Сохранить</button>

        </div>
      </div>
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
            @foreach ($costTypes as $costType)
              <tr>
                <td class="prices__main">{{ $costType->name }} - {{ $hotel->costs()->where('type_id', $costType->id)->first()->description }}</td>
                <td class="text">{{ $hotel->costs()->where('type_id', $costType->id)->first() ? $hotel->costs()->where('type_id', $costType->id)->first()->description : '' }}</td>
              </tr>
            @endforeach

          </table>
        </div>
      </div>
{{--      <div class="row part__bottom">--}}
{{--        <div class="col-12">--}}
{{--          <button class="button">Обновить</button>--}}

{{--        </div>--}}
{{--      </div>--}}
    </div>
  </section>

@endsection

@section('js')
  <script>

    $(document).ready(function() {
      $('.metro').select2({
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
                  id: e.value
                };
              })
            };
          }
        }
      });
    });

    let metros_ids = 1;

    function addMetro() {
      metros_ids++;
      $('#metros').append(
        "<div class='col-12' data-id='" + metros_ids + "'>" +
          "<div class='d-flex align-items-center station'>" +
            "<div class='select' style='width: 45%'>" +
              "<select name='metro[]' class='metro w-100'></select>" +
            "</div>" +
            "<input type='number' name='metro_time[]' class='field field_small station-field'>" +
            "<p class='text'>минут пешком до объекта</p>" +
            "<button onclick='deleteMetro(" + metros_ids +")' class='mx-3 button w-auto px-3'>-</button>" +
          "</div>" +
        "</div>"
      )

      $('.metro').select2({
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
                  id: e.value
                };
              })
            };
          }
        }
      });
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
    $('#file-dropzone').dropzone({
      url: "/file/post",
      maxFiles: 6,
      thumbnailWidth: 360,
      thumbnailHeight: 260,
      addRemoveLinks: true,
      previewsContainer: '.visualizacao',
      previewTemplate : $('.preview').html(),
      init: function() {

        this.on("complete", function(file) {
          $(".dz-remove").html("<span class='upload__remove'><i class='fa fa-trash' aria-hidden='true'></i></span>");
          $('#file-dropzone').appendTo('.visualizacao')
        });

        this.on('completemultiple', function(file, json) {

          // $('.sortable').sortable({
          // 	items: '.dz-image-preview',
          // });

          if (this.files.length > 6) {
            this.removeFile(this.files[0]);
          }

        });

        // $('.uploud-photo').draggable( "disable" )
        this.on('success', function(file, json) {

        });

        this.on('addedfile', function(file) {

        });



        this.on("reset", function (file) {
          $('#file-dropzone').show()

        });

        this.on('drop', function(file) {
        });
      }
    });
  </script>
@endsection