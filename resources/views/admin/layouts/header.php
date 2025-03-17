@if(!auth(ADMIN) && segment() !== 'login')
   @php redirect('login') @endphp
@endif

<!DOCTYPE html>
<html lang="{{ setup()->lang }}" dir="{{ setup()->dir }}" data-bs-theme="auto">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title></title>
      <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

      @if(setup()->dir == 'rtl')
         <link href="{{ asset('admin/css/main.rtl.css') }}" rel="stylesheet">
         <link href="{{ asset('plugins/bootstrap/v5.3/bootstrap.rtl.min.css') }}" rel="stylesheet">
      @else
         <link href="{{ asset('admin/css/main.ltr.css') }}" rel="stylesheet">
         <link href="{{ asset('plugins/bootstrap/v5.3/bootstrap.min.css') }}" rel="stylesheet">
      @endif
      
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      <link href="{{ asset('admin/css/main.css') }}" rel="stylesheet">
      <link href="{{ asset('plugins/fontawesome/v6.5/all.min.css') }}" rel="stylesheet">
   </head>
   <body>