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
  {{-- <link href="{{ mix('css/style.css') }}" rel="stylesheet">
  <link href="{{ mix('css/website/style.css') }}" rel="stylesheet"> --}}


</head>

<body>

  @yield('content')

  @yield('script')

</body>

</html>
