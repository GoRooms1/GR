<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
  <meta name="format-detection" content="telephone=no">
  <meta name="format-detection" content="address=no">
  <meta http-equiv="x-rim-auto-match" content="none">

  <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
  <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
  <link rel="canonical" href="{{ url(Request::url()) }}"/>
{{--  <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />--}}
  @vite
{{--  <script src="{{ mix('/js/app.js') }}" defer></script>--}}
  @inertiaHead
</head>

<body>
  @inertia
</body>
</html>