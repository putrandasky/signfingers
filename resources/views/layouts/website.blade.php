<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  @include('include.analytics')
  @yield('meta')
  <link rel="canonical" href="https://signfinger.com">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
  <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">
  <!-- Main Stylesheet File -->
  <link href="{{ mix('css/style.css') }}" rel="stylesheet">
  <link href="{{ mix('css/website/style.css') }}" rel="stylesheet">


</head>

<body>
    <nav id="main-navbar" class="navbar navbar--ontop fixed-top bg-c-dark px-md-5 shadow">
      <a class="navbar-brand" href="{{url("")}}">
        <img src="{{ asset('images/icon_signfinger.svg') }}" alt="">
        <img src="{{ asset('images/signfinger.svg') }}" alt="">

      </a>
      <div class="nav justify-content-end d-none d-md-flex">
        <a class="mr-2 {{ (request()->is("/")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm' }} " href="{{url("")}}">EN</a>
        <a class=" {{ (request()->is("id")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm'}} " href="{{url("/id")}}">ID</a>
      </div>
      <ul class="nav justify-content-end d-flex d-md-none">
        <button type="button" id="mobile-nav-button" class="btn btn-outline-warning btn-sm">
          <i class="fa fa-bars "></i>
        </button>
      </ul>
    </nav>
    <div id="mobile-sidebar" class="text-warning">
      <nav class="w-100 text-center">
        <a class="{{ (request()->is("/")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm' }} " href="{{url("")}}">EN</a>
        <a class=" {{ (request()->is("id")) ? 'btn btn-warning btn-sm' : 'btn btn-outline-warning btn-sm'}} " href="{{url("/id")}}">ID</a>

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
