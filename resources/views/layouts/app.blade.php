<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145249635-2"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-145249635-2');
    gtag('config', 'G-145249635');
  </script>
  <title>SignFingers - Simple Yet Digital Signaturing</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Radityo Putra Paripurna | alterfingers.com">
    <meta property="og:image" content="{{ asset('images/icon.png') }}">

    <meta property="og:title" content="SignFinger" />
    <meta property="og:url" content="https://signfinger.com" />
    <meta property="og:description" content="Simple Yet Digital Signaturing">
    <link type="image/png" href="{{ asset('images/icon.png') }}" rel="icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>

  @yield('content')

  @yield('script')

</body>

</html>
