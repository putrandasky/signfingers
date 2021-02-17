@extends('layouts.website')

@section('meta')
<title>@lang('website.meta.title')</title>

@include('include.meta')
@endsection

@section('content')

<x-hero>
  <x-slot name="title">
    @lang('website.hero.title')

  </x-slot>
  @lang('website.hero.subtitle')
  <x-slot name="buttonOutline">
    @lang('website.hero.buttonOutline')
  </x-slot>
  <x-slot name="buttonSolid">
    @lang('website.hero.buttonSolid')
  </x-slot>
</x-hero>




<div id="why" class="bg-c-dark container my-5 ">
  <div class="row mb-5 ">
    <div class="cols-12 w-100 text-warning text-center">
      <h2>
        <b>
          @lang('website.why.title')
        </b>
      </h2>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 pb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-save fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          @lang('website.why.1.title') *
        </x-slot>
        @lang('website.why.1.subtitle')
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-download fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          @lang('website.why.2.title')
        </x-slot>
        @lang('website.why.2.subtitle')
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-hourglass-3 fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          @lang('website.why.3.title')
        </x-slot>
        @lang('website.why.3.subtitle')
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-sign-in fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          @lang('website.why.4.title')
        </x-slot>
        @lang('website.why.4.subtitle')

      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-file fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          @lang('website.why.5.title')
        </x-slot>
        @lang('website.why.5.subtitle')
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-dollar fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          @lang('website.why.6.title')
        </x-slot>
        @lang('website.why.6.subtitle')
      </x-why-item>
    </div>
  </div>
  <div class="text-white">
    <small>@lang('website.why.footnote')</small>
  </div>
</div>
<div id="tagline" class="parallax py-5" style="background-image:linear-gradient(rgba(232, 237, 223, 0.8), rgba(232, 237, 223, 0.8)),url({{ asset('images/bg_tagline.jpg') }})">
  <div class="container py-5">
    <header class="text-center text-c-dark-grey">
      <h2 class="font-weight-bold">@lang('website.tagline')</h2>
    </header>
  </div>
</div>
<div id="how-work" class="bg-c-dark-grey py-5">
  <div class=" container ">
    <div class="row mb-5">
      <div class="cols-12 w-100 text-warning text-center">
        <h2>
          <b>
            @lang('website.how-work.title')
          </b>
        </h2>
      </div>
    </div>
    <carrousel-how-works locale="{{ (request()->is("id")) ? 'id' : 'en' }}"></carrousel-how-works>

  </div>
</div>
<div id="cta" class="py-5">
  <div class="container-fluid text-center">
    <h2 class="text-warning">
      <strong>
        @lang('website.cta.title')
      </strong>
    </h2>
    <a href='{{(request()->is("id")) ?  url("tanda-tangan-digital") : url("digital-signature")}}' class="btn btn-outline-warning mt-5">
      <strong>
        @lang('website.cta.buttonOutline')
      </strong>
    </a>
    <a href='{{(request()->is("id")) ?  url("tanda-tangan-digital") : url("digital-signature")}}' class="btn btn-warning mt-5">
      <strong>
        @lang('website.cta.buttonSolid')
      </strong>
    </a>
  </div>
</div>
<div class="footer" class="">
  <div class="container-fluid text-center bg-warning py-3 text-dark">
    <strong>

      Developed by <a class="text-dark" href="https://alterfingers.com" target="_blank">alterfingers.com</a> © 2020
    </strong>
  </div>
</div>
@endsection

@section('script')
@include('scripts.website')
@endsection
