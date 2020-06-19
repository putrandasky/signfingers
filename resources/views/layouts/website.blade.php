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
  @yield('meta')
  <link rel="canonical" href="https://signfinger.com">
  <link type="image/png" href="{{ asset('images/icon.png') }}" rel="icon">
  <!-- Main Stylesheet File -->
  <link href="{{ mix('css/style.css') }}" rel="stylesheet">
  <link href="{{ mix('css/website/style.css') }}" rel="stylesheet">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <nav id="main-navbar" class="navbar navbar--ontop fixed-top bg-c-dark px-md-5 shadow">
      <a class="navbar-brand" href="{{url("https://signfinger.com")}}">
        <img src="{{ asset('images/icon_signfinger.svg') }}" alt="">
        <img src="{{ asset('images/signfinger.svg') }}" alt="">

      </a>
      <div class="nav justify-content-end d-none d-md-flex">
        <a class="mr-2 {{ (request()->is("/")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm' }} " href="{{url("https://signfinger.com")}}">EN</a>
        <a class=" {{ (request()->is("id")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm'}} " href="{{url("https://signfinger.com/id")}}">ID</a>
      </div>
      <ul class="nav justify-content-end d-flex d-md-none">
        <button type="button" id="mobile-nav-button" class="btn btn-outline-warning btn-sm">
          <i class="fa fa-bars "></i>
        </button>
      </ul>
    </nav>
    <div id="mobile-sidebar" class="text-warning">
      <nav class="w-100 text-center">
        <a class="{{ (request()->is("/")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm' }} " href="{{url("https://signfinger.com")}}">EN</a>
        <a class=" {{ (request()->is("id")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm'}} " href="{{url("https://signfinger.com/id")}}">ID</a>

      </nav>
    </div>
    <div id="mobile-overlay">
      <button type="button" id="mobile-nav-button-close">
        <i class="fa fa-times"></i>
      </button>
    </div>
    @yield('content')

    @yield('script')

  </body>

  </html>
