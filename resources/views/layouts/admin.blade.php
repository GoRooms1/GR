<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}?v={{ time() }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  @if(config('app.debug'))
    <script src="{{ asset('js/vue-dev.js') }}"></script>
  @else
    <script src="{{ asset('js/vue@2.js') }}"></script>
  @endif

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

</head>
<body>
<div id="app">
  <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Gorooms.ru') }}
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        @auth
          <ul class="navbar-nav mr-auto sidenav" id="navAccordion">
            <li class="nav-item">
              <a href="{{ route('admin.hotels.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.hotels.*') ? 'active' : '' }}">Страницы отелей</a>
            </li>

            <li class="nav-item">
              <a id="hasSubItems"
                 class="nav-link nav-link-collapse {{ Route::currentRouteNamed('admin.attributes.*') || Route::currentRouteNamed('admin.attribute_categories.*') ? 'active nav-link-show' : '' }}"
                 href="#"
                 data-toggle="collapse"
                 data-target="#collapseSubItems2"
                 aria-controls="collapseSubItems2"
                 aria-expanded="true"
              >
                Атрибуты
              </a>

              <ul class="nav-second-level collapse {{ Route::currentRouteNamed('admin.attributes.*') || Route::currentRouteNamed('admin.attribute_categories.*') ? 'show' : '' }}"
                  id="collapseSubItems2"
                  data-parent="#navAccordion"
              >
                <li class="nav-item">
                  <a class="nav-link {{ Route::currentRouteNamed('admin.attribute_categories.*') ? 'active' : '' }}" href="{{ route('admin.attribute_categories.index') }}">
                    <span class="nav-link-text">Категории</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Route::currentRouteNamed('admin.attributes.*') ? 'active' : '' }}" href="{{ route('admin.attributes.index') }}">
                    <span class="nav-link-text">Атрибуты</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="{{ route('admin.moderators.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.moderators.*') ? 'active' : '' }}">Модераторы</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.cost_types.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.cost_types.*') ? 'active' : '' }}">Типы цен</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.hotel_types.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.hotel_types.*') ? 'active' : '' }}">Типы размещений</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.ratings.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.ratings.*') ? 'active' : '' }}">Категории рейтинга</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.articles.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.articles.*') ? 'active' : '' }}">Статьи</a>
            </li>

            <li class="nav-item">
              <a id="hasSubItems2"
                 class="nav-link nav-link-collapse {{ Route::currentRouteNamed('admin.descriptions.*') || Route::currentRouteNamed('admin.pages.*') ? 'active nav-link-show' : '' }}"
                 href="#"
                 data-toggle="collapse"
                 data-target="#collapseSubItems3"
                 aria-controls="collapseSubItems3"
                 aria-expanded="true"
              >
                SEO Контент
              </a>

              <ul class="nav-second-level collapse {{ Route::currentRouteNamed('admin.descriptions.*') || Route::currentRouteNamed('admin.pages.*') ? 'show' : '' }}"
                  id="collapseSubItems3"
                  data-parent="#navAccordion"
              >
                <li class="nav-item">
                  <a class="nav-link {{ Route::currentRouteNamed('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    <span class="nav-link-text">Страницы</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Route::currentRouteNamed('admin.descriptions.*') ? 'active' : '' }}" href="{{ route('admin.descriptions.index') }}">
                    <span class="nav-link-text">Страницы локаций</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.instructions.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.instructions.*') ? 'active' : '' }}">Инструкции</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.settings.index') }}" class="nav-link {{ Route::currentRouteNamed('admin.settings.*') ? 'active' : '' }}">Настройки</a>
            </li>
          </ul>
        @endauth
      <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"
                   ref="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                  Выход
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <section class="errors">
    @if ($errors->any())
      <div class="container">
        <div class="row">
          @foreach ($errors->all() as $error)
            <div class="col-md-12 my-2">
              <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>{{ $error }}</strong>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </section>

  <section class="errors">
    @if(session('success'))
      <div class="container">
        <div class="row">
          <div class="col-md-12 my-2">
            <div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>{{session('success')}}</strong>
            </div>
          </div>
        </div>
      </div>
    @endif
  </section>

  <main class="py-4 content-wrapper">
    @yield('content')
  </main>
</div>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"
        integrity="sha512-sR3EKGp4SG8zs7B0MEUxDeq8rw9wsuGVYNfbbO/GLCJ59LBE4baEfQBVsP2Y/h2n8M19YV1mujFANO1yA3ko7Q=="
        crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>
<script src="https://cdn.tiny.cloud/1/ghdxavsus8orb1hk0kqxhd7ncwttt1anujdh4p7lmje0oiak/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
<script src="https://cdn.tiny.cloud/1/z826n1n5ayf774zeqdphsta5v2rflavdm2kvy7xtmczyokv3/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>


<script>
  $("#address").suggestions({
    token: "a35c9ab8625a02df0c3cab85b0bc2e9c0ea27ba4",
    type: "ADDRESS",
  });
  $('.phone').inputmask("+7 (999) 999-99-99");
  tinymce.init({
    selector: 'textarea.editor',
    images_upload_url: '/admin/upload',
    automatic_uploads: true,
    block_unsupported_drop: false,
    plugins: "lists table image imagetools code",
    table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect | code',
    height: 400,
    extended_valid_elements: "script[*]"
  });
  $(function () {
    // Multiple images preview in browser
    var imagesPreview = function (input, placeToInsertImagePreview) {

      if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
          var reader = new FileReader();

          reader.onload = function (event) {
            $($.parseHTML('<div class="col-12 col-md-4 mb-3"><img class="img-fluid img-thumbnail" src="' + event.target.result + '"></div>')).appendTo(placeToInsertImagePreview);
          }

          reader.readAsDataURL(input.files[i]);
        }
      }

    };

    $('.js-image-preview').on('change', function () {
      imagesPreview(this, 'div.images');
    });
  });

</script>

<script>
  $(document).ready(function() {
    $('.nav-link-collapse').on('click', function() {
      $('.nav-link-collapse').not(this).removeClass('nav-link-show');
      $(this).toggleClass('nav-link-show');
    });
  });
</script>

@yield('js')
</body>
</html>
