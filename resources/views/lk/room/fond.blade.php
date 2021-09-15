@extends('lk.layouts.app')

@section('content')
  <section class="part">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title title title_blue">Номерной фонд</h2>
        </div>
      </div>
      <div class="row part__middle">
        <div class="col-8">
          <p class="caption">Выберите тип отображения</p>
        </div>
      </div>

      <form action="{{ route('lk.room.fond.update') }}" method="POST">
        @csrf
        <div class="row part__middle">
          <div class="col-6">
            <input type="radio"
                   name="fond"
                   value="{{ \App\Models\Hotel::ROOMS_TYPE }}"
                   id="everyRoom" {{ $hotel->type_fond === \App\Models\Hotel::ROOMS_TYPE || $hotel->type_fond === null ? 'checked' : '' }}
            >
            <label for="everyRoom"
                   class="long-label">
              Демонстрация каждой комнаты объекта в отдельности
            </label>
          </div>
          <div class="col-6">
            <input type="radio"
                   name="fond"
                   value="{{ \App\Models\Hotel::CATEGORIES_TYPE }}"
                   id="quote" {{ $hotel->type_fond === \App\Models\Hotel::CATEGORIES_TYPE ? 'checked' : '' }}
            >
            <label for="quote"
                   class="long-label">
              Демонстрация категорий отеля с квотами комнат
            </label>
          </div>

        </div>

        <div class="row part__middle">
          <p class="text text-center"
             id="fondText2">
            Выбрав данный вид Демонстрации номерного фонда, Вы сможете группировать комнаты по
            категориям с указанием общего числа комнат в категории. Например "Стандарт" доступно
            50 комнат. Для каждой категории Вы сможете загрузить фотографии, описание и цены. Мы
            рекомендуем данный вид демонстрации для объектов размещения с номерным фондом свыше 25 комнат.
          </p>
          <p class="text text-center"
             id="fondText1">
            Выбрав данный вид Демонстрации номерного фонда, каждая комната Вашего объекта будет
            выводиться отдельно, вы сможете загрузить фотографии, описание и цены для каждой комнаты
            в отдельности. Мы рекомендуем данный вид демонстрации для объектов размещения с номерным
            фондом до 25 комнат.
          </p>
        </div>

        <div class="row fond__bottom">
          <div class="col-12 text-center">
            <button class="button fond__button">Выбрать</button>
          </div>
        </div>
      </form>


    </div>
  </section>
@endsection

@section('js')

@endsection