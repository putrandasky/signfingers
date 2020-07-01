@extends('layouts.app')

@section('meta')
<title>@lang('website.meta.title')</title>
@include('include.meta')
@endsection

@section('content')
<div id="app">

    {{-- <example-component></example-component> --}}
</div>
@endsection

@section('script')
  @include('scripts.app')
@endsection
