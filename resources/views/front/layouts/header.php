<!DOCTYPE html>
<html lang="{{ setup()->lang }}" dir="{{ setup()->dir }}" data-bs-theme="auto">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title></title>
      <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      
      @if(setup()->dir == 'rtl')
         <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
         <link href="{{ asset('front/css/blog.rtl.css') }}" rel="stylesheet">
         <link href="{{ asset('plugins/bootstrap/v5.3/bootstrap.rtl.min.css') }}" rel="stylesheet">
      @else
         <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
         <link href="{{ asset('front/css/blog.ltr.css') }}" rel="stylesheet">
         <link href="{{ asset('plugins/bootstrap/v5.3/bootstrap.min.css') }}" rel="stylesheet">
      @endif
      
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      <link href="{{ asset('front/css/blog.css') }}" rel="stylesheet">
      <link href="{{ asset('plugins/fontawesome/v6.5/all.min.css') }}" rel="stylesheet">
   </head>
   <body>
