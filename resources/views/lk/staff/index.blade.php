@extends('lk.layouts.app')

@section('content')

  <section class="part">
    <div class="container">
      <div class="row part__top">
        <div class="col-12">
          <h2 class="title title_black">Сотрудники</h2>
        </div>
      </div>
      <div class="row">

        @foreach($users as $user)
          <div class="col-4">
            <div class="staff-item staff-item_general">
              <div class="staff-item__name">{{ App\User::POSITIONS_LANGUAGE[$user->pivot->hotel_position] }}</div>
              <div class="staff-item__bottom">
                <p class="staff-item__text">{{ $user->position }}</p>
                <p class="staff-item__text">{{ $user->phone }}</p>
                <p class="staff-item__text">{{ $user->name }}</p>
              </div>
            </div>
          </div>
        @endforeach




        <div class="staff-item staff-item_general d-none">
            <div class="staff-item__name staff-item__name_blue">General</div>
            <div class="staff-item__bottom">
              <p class="staff-item__text">Директор</p>
              <p class="staff-item__text">+7 ( _ _ _ ) _ _  _ _  _ _</p>
              <p class="staff-item__text">Иван Иванов Иванович</p>
            </div>
          </div>

        <div class="staff-item staff-item_small staff-item_staff d-none">
            <div class="staff-item__name">Staff</div>
            <div class="staff-item__bottom">
              <p class="staff-item__text">Должность</p>
              <p class="staff-item__text">+7 ( _ _ _ ) _ _  _ _  _ _</p>
              <p class="staff-item__text">Полное имя сотрудника</p>
            </div>
        </div>

        <div class="staff-item staff-item_small staff-item_staff d-none">
          <div class="staff-item__name staff-item__name_orange">Staff</div>
          <div class="staff-item__bottom">
            <p class="staff-item__text">Администратор</p>
            <p class="staff-item__text">+7 ( _ _ _ ) _ _  _ _  _ _</p>
            <p class="staff-item__text">Иван Иванов Иванович</p>
          </div>
        </div>
      </div>
    </div>

  </section>

  <div class="overlay">
  </div>
  <div class="popup" id="popupGeneral">
    <img src="img/close.png" alt="" class="close-this">
    <h2 class="title title_blue popup__title">General</h2>
    <input type="text" class="field" placeholder="ФИО">
    <input type="phone" class="field" placeholder="+7 ( _ _ _ ) _ _ _  _ _  _ _">
    <input type="email" class="field" placeholder="E-mail">
    <input type="text" class="field" placeholder="Должность">
    <input type="text" class="field" placeholder="Придумайте пароль">
    <input type="text" class="field" placeholder="Придумайте кодовое слово">
    <div class="d-flex align-items-center popup-buttons">
      <div class="d-flex align-items-center">
        <button type="button" class="button button_blue">Сохранить</button>
        <button type="button" class="button button_gray reset">Сбросить пароль</button>
      </div>

      <button class="staff-remove">
        <img src="img/bin.png" alt="">
      </button>
    </div>
  </div>

  <div class="popup" id="popupStaff">
    <img src="img/close.png" alt="" class="close-this">
    <h2 class="title popup__title">Staff</h2>
    <input type="text" class="field" placeholder="ФИО">
    <input type="phone" class="field" placeholder="+7 ( _ _ _ ) _ _ _  _ _  _ _">
    <input type="email" class="field" placeholder="E-mail">
    <input type="text" class="field" placeholder="Должность">
    <input type="text" class="field" placeholder="Придумайте пароль">
    <input type="text" class="field" placeholder="Придумайте кодовое слово">
    <div class="d-flex align-items-center popup-buttons">
      <div class="d-flex align-items-center">
        <button type="button" class="button">Сохранить</button>
        <button type="button" class="button button_gray reset">Сбросить пароль</button>
      </div>

      <button class="staff-remove">
        <img src="img/bin.png" alt="">
      </button>
    </div>
  </div>
@endsection