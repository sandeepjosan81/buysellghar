<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ front_locale_direction() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="{{ front_route('home.index') }}">
  <title>@yield('title', system_setting_locale('meta_title', 'BuySellGhar Online Ecommerce platform '))</title>
  <meta name="description" content="@yield('description', system_setting_locale('meta_description', 'BuySellGhar is an innovative open-source e-commerce platform developed based on Laravel 12, featuring multi-language and multi-currency support. It adopts a powerful and flexible plugin architecture based on Hooks, providing users with rich customization and extension functions. Welcome to experience BuySellGhar and build your own e-commerce platform!'))">
  <meta name="keywords" content="@yield('keywords', system_setting_locale('meta_keywords', 'BuySellGhar, innovation, open source, e-commerce, cross-border e-commerce, open source independent website, Laravel 12, multi-language, multi-currency, Hook, plugin architecture, flexible, powerful'))">
  <meta name="generator" content="BuySellGhar">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="api-token" content="{{ session('front_api_token') }}">
  <meta name="author" content="Urban Grain ">

  <link rel="shortcut icon" href="{{ image_origin(system_setting('favicon', 'images/favicon.png')) }}">
  <link rel="stylesheet" href="{{ mix('build/front/css/bootstrap.css') }}">
  <script src="{{ mix('build/front/js/app.js') }}"></script>
  <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('vendor/layer/3.5.1/layer.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <?php 
    /*
      <!-- Zoom Image-->
      <link rel="stylesheet" href="{{ mix('build/front/css/jquery.jqZoom.css') }}" type="text/css"/>
      <script src="{{ mix('build/front/js/jquery.jqZoom.js') }}"></script>
      <script>
          $(function(){
              $(".zoom-box img").jqZoom({
                  selectorWidth: 30,
                  selectorHeight: 30,
                  viewerWidth: 400,
                  viewerHeight: 300
              });
          })
      </script>
      <!-- Zoom Image-->
    */ 
  ?>  
  <link rel="stylesheet" href="{{ mix('build/front/css/fonts/bootstrap-icons.min.css') }}">
  <link rel="stylesheet" href="{{ mix('build/front/css/landing.css') }}">
  <link rel="stylesheet" href="{{ mix('build/front/css/landing-template2.css') }}">  
  
  <link rel="stylesheet" href="{{ mix('build/front/css/app.css') }}">  
  <!-- Facebook, WhatsApp, LinkedIn  -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="Your Page Title">
  <meta property="og:description" content="Your page description here">
  <meta property="og:image" content="{{ asset('images/preview.jpg') }}">
  <meta property="og:url" content="{{ front_route('home.index') }}">
  <meta property="og:site_name" content="Your Website Name">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Your Page Title">
  <meta name="twitter:description" content="Your page description here">
  <meta name="twitter:image" content="{{ asset('images/preview.jpg') }}">
  <meta name="twitter:url" content="{{ front_route('home.index') }}">

  <!-- Whatsapp -->
  <meta name="whatsapp:title" content="Your Page Title">
  <meta name="whatsapp:description" content="Your page description here">
  <meta name="whatsapp:image" content="{{ asset('images/preview.jpg') }}">
  <meta name="whatsapp:url" content="{{ front_route('home.index') }}">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">

  <!-- Optional -->
  <meta name="twitter:site" content="@yourusername">
  <meta name="twitter:creator" content="@yourusername">

    <!-- Optional but useful -->
  <meta property="og:locale" content="en_US">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <meta name="robots" content="index, follow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta property="og:title" content="Buy Premium Products Online">
  <meta property="og:description" content="Best quality products at affordable price. Shop now!">
  <meta property="og:image" content="{{ asset('images/shoes.jpg') }}">
  <?php /* <meta property="og:url" content="{{ front_route('products.show', ['id' => $product->id]) }}"> */ ?>


  <script>
    const urls = {
      front_api: '{{ route('api.home.base') }}',
      front_base: '{{ front_route('home.index') }}',
      front_upload: '{{ front_root_route('upload.images') }}',
      front_cart_add: '{{ front_route('carts.store') }}',
      front_cart_mini: '{{ front_route('carts.mini') }}',
      front_cart: '{{ front_route('carts.index') }}',
      front_checkout: '{{ front_route('checkout.index') }}',
      front_login: '{{ front_route('login.index') }}',
      front_favorites: '{{ account_route('favorites.index') }}',
      front_favorite_cancel: '{{ account_route('favorites.cancel') }}',
    };

    const config = {
      isLogin: !!{{ current_customer()->id ?? 'null' }},
      currency: {
        code: '{{ current_currency_code() }}',
        symbol_left: '{{ current_currency()->symbol_left ?? "$" }}',
        symbol_right: '{{ current_currency()->symbol_right ?? "" }}',
        decimal_place: {{ current_currency()->decimal_place ?? 2 }},
        rate: {{ current_currency()->value ?? 1 }}
      }
    };

    const asset_url = '{{ asset('') }}';
  </script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

  <?php /*

    @font-face {
    font-family: 'Montserrat';
        src: url(https://cdn.staticmb.com/mbfonts/montserrat-regular.woff2) format('woff2'), url(https://cdn.staticmb.com/mbfonts/montserrat-regular.woff) format('woff'), url(https://cdn.staticmb.com/mbfonts/montserrat-regular.ttf) format('ttf');
        font-display: block;
        font-style: normal;
    }
  </style>
  */ ?>


  @stack('header')
  @hookinsert('front.layout.app.head.bottom')
</head>
<?php 
  $class =" template-2";
  // if (request()->routeIs('home.new_home')) {
  //   $class .= " template-2";
  // }
?>

<body class="@yield('body-class') {{ $class }}">
  @if (!request('iframe'))
    <x-front-header />
  @endif

  <div class="m-0 p-0" id="appContent">
      @yield('content')
  </div>

  @if (!request('iframe'))
    <x-front-footer />
  @endif

  @if (!request('iframe'))
    @include('components.mini-cart')
  @endif

  @stack('footer')
 
</body>

</html>
