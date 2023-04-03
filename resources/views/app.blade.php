<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="max-[390px]:text-[12px] max-[460px]:text-[14px] max-[420px]:text-[13px]">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
  <meta name="format-detection" content="telephone=no">
  <meta name="format-detection" content="address=no">
  <meta http-equiv="x-rim-auto-match" content="none">

  <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
  <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet">  
  <link rel="canonical" href="{{ url(Request::url()) }}"/> 
  <!-- <script src="https://api-maps.yandex.ru/2.1/?apikey={{ config('services.yandex.map.key') }}&lang=ru_RU"
          type="text/javascript">
  </script> -->
   
  @routes
  @vite  
  @inertiaHead
</head>

<body class="text-zinc-600">
  @inertia
</body>
</html>