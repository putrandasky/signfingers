@extends('layouts.website')
@section('content')

<x-hero>
  <x-slot name="title">
    Digitizing Your Signature Activities
  </x-slot>
  Providing a free and secure platform in order to supporting new normal for your work and business
  <x-slot name="button">
    Start Signing
  </x-slot>
</x-hero>



<div id="why" class="bg-c-dark container my-5">
  <div class="row mb-5">
    <div class="cols-12 w-100 text-warning text-center">
      <h3>
        <b>
          Why using SignFinger?
        </b>
      </h3>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-save fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          No File Stored
        </x-slot>
        What more secured for preventing data leaked than no data or file stored?
        We are not store any document even your digital signature in our storage for maximum security
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-download fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          No Download Required
        </x-slot>
        We are value your time, so we make the platform for you to do all the process directly on the browser
        No apps or download required for the fastest get the job done
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-hourglass-3 fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          No Hazzle
        </x-slot>
        Digitizing your signature as easy as counting until three
        To the point and shortest workflow for get the signing job done
        forget the way to digitizing a signature in a document with a crop, copy, paste from scanned signature
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-sign-in fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          No Register & Sign In Required
        </x-slot>
        We make this platform for the fastest get the job done, so we make it even faster with working directly after you open the apps on web

      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-file fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          No Printing / Paperless
        </x-slot>
        Support this earth to become greener with paperless habit. Never print any document just only for signing activities </p>
      </x-why-item>
    </div>
    <div class="col-lg-6 mb-5">
      <x-why-item>
        <x-slot name="icon">
          <i class="fa fa-dollar fa-stack-1x text-warning"></i>
        </x-slot>
        <x-slot name="title">
          No Cost or Fee
        </x-slot>
        Absolutely free, dont make a cost and fee issue intefere your worflow to signing your own document
      </x-why-item>
    </div>
  </div>
</div>
<div id="tagline" class="parallax py-5" style="background-image:linear-gradient(rgba(232, 237, 223, 0.8), rgba(232, 237, 223, 0.8)),url({{ asset('images/bg_tagline.jpg') }})">
  <div class="container py-5">
    <header class="text-center text-c-dark-grey">
      <h2 class="font-weight-bold">One of the most important part of your job will be easier, ever.</h2>
    </header>
  </div>
</div>
<div id="how-work" class="bg-c-dark-grey py-5">
  <div class=" container">
    <div class="row">
      <div class="col-lg-6 mb-3">
        <div class="w-100 text-warning text-center mb-5">
          <h3>
            <strong>

              Works as easy as count to three
            </strong>
          </h3>
        </div>
        <div>
          <h5 class="text-warning">
            Attaching your file or document
          </h5>
          <p class="text-white">
            Select your file which you want to sign and attach it to the browser
          </p>
        </div>
        <div>
          <h5 class="text-warning">
            Draw a signature on the browser
          </h5>
          <p class="text-white">
            Defining an area as signature target on the document and draw your signature on the given pad in the platform
          </p>
        </div>
        <div>
          <h5 class="text-warning">
            Download it
          </h5>
          <p class="text-white">
            Preview it before download. If it is not as desired, just repeat it. simple
          </p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="position-relative px-5">
          <img class="img-center img-fluid shadow-lg" src="{{ asset('images/sign_mock.png') }}" alt="">
        </div>
      </div>
    </div>
  </div>
</div>
<div id="cta" class="py-5">
  <div class="container-fluid text-center">
    <h3 class="text-warning">
      <strong>
        Complete the signing part of your job, easier.
      </strong>
    </h3>
    <a href='{{url("sign-file")}}' class="btn btn-warning mt-5">
      <strong>
        Start Signing
      </strong>
    </a>
  </div>
</div>
<div class="footer" class="">
  <div class="container-fluid text-center bg-warning py-3 text-dark">
    <strong>

      Developed by <a class="text-dark" href="https://alterfingers.com" target="_blank">Alterfingers</a> © 2020
    </strong>
  </div>
</div>

@endsection

@section('script')
@include('scripts.website')
@endsection
