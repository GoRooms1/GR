@extends('lk.layouts.app')

@section('content')
  <input type="hidden" name="category.update" value="{{ route('lk.category.update') }}">
  <input type="hidden" name="category.create" value="{{ route('lk.category.create') }}">
  <input type="hidden" name="category.delete" value="{{ route('lk.category.delete') }}">

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
@endsection

@section('js')

@endsection