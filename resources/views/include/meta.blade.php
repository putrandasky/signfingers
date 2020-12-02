<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta http-equiv="Content-Security-Policy"
    content="
      worker-src blob:;
      child-src blob: gap:;
      img-src 'self' blob: data:;
      default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap: content:">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
<meta name="author" content="signfinger.com">
<meta name="description" content="@lang('website.meta.description')">
<meta name="keywords" content="@lang('website.meta.keywords')">
<meta property="og:title" content="@lang('website.meta.title')" />
<meta property="og:site_name" content="@lang('website.meta.og_site_name')" />
<meta property="og:type" content="website" />
<meta property="og:description" content="@lang('website.meta.og_description')">
<meta property="og:image" content="{{asset('images/landingpage_hero.png')}}">
<meta property="og:url" content="https://signfinger.com" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="@lang('website.meta.twitter_title')">
<meta name="twitter:description" content="@lang('website.meta.twitter_description')">
<meta name="twitter:image:src" content="{{asset('images/landingpage_hero.png')}}">
<meta name="twitter:image" content="{{asset('images/landingpage_hero.png')}}">
<meta name="robots" content="all">
<meta name="webcrawlers" content="all">
<meta name="theme-color" content="#F5CB5C" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
