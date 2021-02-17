@extends('layouts.app')

@section('meta')
<title>@lang('sign-request-respond.meta.title')</title>
@include('include.meta')
@endsection

@section('content')
<div id="app">

    {{-- <example-component></example-component> --}}
</div>
@endsection

@section('script')
  @include('scripts.sign-request-respond')
@endsection
