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
            @if ($user->pivot->hotel_position === App\User::POSITION_GENERAL)
              <div class="staff-item staff-item_general" data-id="{{ $user->id }}">
                <div class="staff-item__name">{{ App\User::POSITIONS_LANGUAGE[$user->pivot->hotel_position] }}</div>
                <div class="staff-item__bottom">
                  <p class="staff-item__text">{{ $user->position }}</p>
                  <p class="staff-item__text">{{ $user->phone }}</p>
                  <p class="staff-item__text">{{ $user->name }}</p>
                </div>
              </div>
            @else
              <div class="staff-item staff-item_small staff-item_staff" data-id="{{ $user->id }}">
              <div class="staff-item__name">Staff</div>
              <div class="staff-item__bottom">
                <p class="staff-item__text">Должность</p>
                <p class="staff-item__text">+7 ( _ _ _ ) _ _  _ _  _ _</p>
                <p class="staff-item__text">Полное имя сотрудника</p>
              </div>
          </div>
            @endif
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

  @foreach($users as $user)
    <div class="popup" data-id="{{ $user->id }}">
      <img src="{{ asset('img/lk/close.png') }}" alt="" class="close-this">
      <h2 class="title title_blue popup__title">{{ App\User::POSITIONS_LANGUAGE[App\User::POSITION_GENERAL] }}</h2>
      <input type="text" class="field" placeholder="ФИО" value="{{ $user->name }}">
      <input type="phone" class="field" placeholder="+7 ( _ _ _ ) _ _ _  _ _  _ _" value="{{ $user->phone }}">
      <input type="email" class="field" placeholder="E-mail" value="{{ $user->email }}">
      <input type="text" class="field" placeholder="Должность" {{ $user->position }}>
      <input type="password" class="field" placeholder="Придумайте пароль">
      <input type="text" class="field" placeholder="Придумайте кодовое слово" value="{{ $user->code }}">
      <div class="d-flex align-items-center popup-buttons">
        <div class="d-flex align-items-center">
          <button type="button" class="button button_blue">Сохранить</button>
          <button type="button" class="button button_gray reset">Сбросить пароль</button>
        </div>
{{--        @if(auth()->id() !== $user->id)--}}
          <button class="staff-remove"
                  type="button"
                  onclick="event.preventDefault(); $('.popup[data-id={{ $user->id }}] form.remove-user').submit()">
            <img src="{{ asset('img/lk/bin.png') }}" alt="">
          </button>
{{--          @endif--}}
      </div>
      <form action="{{ route('lk.staff.remove', $user->id) }}" method="POST" class="remove-user d-none">
        @csrf
      </form>
    </div>
  @endforeach

@endsection


@section('js')
  <script>
    $("input[type='phone']").mask("+7 (999) 999 99-99");
  </script>
@endsection