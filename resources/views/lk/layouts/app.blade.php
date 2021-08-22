<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gorooms - @yield('title', 'Личный кабинет')</title>

  <!-- Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/lk.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet"/>
  <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>
  <script src="https://use.fontawesome.com/2c0868e10d.js"></script>
  <meta name="viewport" content="width=1200">
</head>
<body>
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible position-fixed w-auto fade show" style="top: 50px; z-index: 1000; right: 20px" role="alert">
  <strong>Успешно</strong> {{ session()->get('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<header class="header">
  <div class="header__top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6">
          <a href="{{ route('lk.index') }}" class="logo-link">
            <img src="{{ asset('img/lk/logo.png') }}" alt="" class="logo">

          </a>
        </div>
        <div class="col-6 text-right">
          @if (auth()->check())
            <button type="button"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="sign">
              <span>{{ auth()->user()->name }}</span>
              <img src="{{ asset('img/lk/sign.png') }}" alt="" class="sign__picture">
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
              @csrf
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="header__bottom">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="menu">
            <a href="#" class="menu__item">Календарь цен</a>
            <a href="#" class="menu__item">Маркетинг</a>
            <a href="#" class="menu__item">Объект</a>
            <a href="#" class="menu__item">Номерной фонд</a>
            <a href="#" class="menu__item">Сотрудники</a>
            <a href="#" class="menu__item">Инструкции</a>
          </nav>
        </div>
      </div>

    </div>
  </div>
</header>

{{-- MAIN--}}

<main class="content">

  @yield('content')

</main>

{{-- FOOTER --}}
<footer class="footer"></footer>


<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>

<script src="{{ asset('js/dropzone.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/lk.js') }}"></script>
<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/ru.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@yield('js')

</body>
</html>