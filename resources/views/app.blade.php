<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="text-[16px]">

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
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" as="style">
  <link rel="canonical" href="{{ url(Request::url()) }}" />

  @vite
  @inertiaHead
</head>

<body class="text-zinc-600">
  @inertia

  @if (config('app.env') === 'production1')
  <!-- Yandex.Metrika counter -->
  <script type="text/javascript">
    (function() {
      'use strict';
      var loadedMetrica = false,
        metricaId = 72285235,
        timerId;

      if (navigator.userAgent.indexOf('YandexMetrika') > -1) {
        loadMetrica();
      } else {
        window.addEventListener('scroll', loadMetrica, {
          passive: true
        });
        window.addEventListener('touchstart', loadMetrica);
        document.addEventListener('mouseenter', loadMetrica);
        document.addEventListener('click', loadMetrica);
        document.addEventListener('DOMContentLoaded', loadFallback);
      }

      function loadFallback() {
        timerId = setTimeout(loadMetrica, 1000);
      }

      function loadMetrica(e) {
        if (e && e.type) {
          console.log(e.type);
        } else {
          console.log('DOMContentLoaded');
        }
        if (loadedMetrica) {
          return;
        }

        (function(m, e, t, r, i, k, a) {
          m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
          };
          m[i].l = 1 * new Date();
          k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })(window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");
        ym(metricaId, "init", {
          clickmap: true,
          trackLinks: true,
          accurateTrackBounce: true
        });

        loadedMetrica = true;
        clearTimeout(timerId);

        window.removeEventListener('scroll', loadMetrica);
        window.removeEventListener('touchstart', loadMetrica);
        document.removeEventListener('mouseenter', loadMetrica);
        document.removeEventListener('click', loadMetrica);
        document.removeEventListener('DOMContentLoaded', loadFallback);
      }
    })()
  </script>
  <noscript>
    <div><img src="https://mc.yandex.ru/watch/72285235" style="position:absolute; left:-9999px;" alt="" /></div>
  </noscript>
  <!-- /Yandex.Metrika counter -->
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-73NM6845XT"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'G-73NM6845XT');
  </script>
  @endif
</body>

</html>