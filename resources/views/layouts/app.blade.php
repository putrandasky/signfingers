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
  <title>Digital Signing Platform | SignFinger </title>
  <meta http-equiv="X-UA-Compatible" content="chrome=1">
  <meta charset="utf-8">
  <meta name="author" content="Radityo Putra Paripurna | alterfingers.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <meta name="description" content="Signfinger provide digital signature platform without registration for free and secure . Digital signature for replacing conventional signing activities with digital.">
  <meta name="keywords" content="digital signing, esign, digital signature, sign digital">
  <meta property="og:image" content="{{asset('images/landingpage_hero.png')}}">
  <meta property="og:title" content="Digital Signing Platform | SignFinger " />
  <meta property="og:url" content="https://signfinger.com" />
  <meta property="og:description" content="Signfinger provide digital signature platform without registration for free and secure . Digital signature for replacing conventional signing activities with digital.">
   <link type="image/png" href="{{ asset('images/icon.png') }}" rel="icon">
  <!-- Main Stylesheet File -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/website/style.css') }}" rel="stylesheet">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>

  @yield('content')

  @yield('script')

</body>

</html>
