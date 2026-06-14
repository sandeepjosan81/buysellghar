<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ panel_locale_direction() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="{{ panel_route('home.index') }}">
  <title>@yield('title', __('panel/register.title'))</title>
  <meta name="keywords" content="@yield('keywords', __('panel/register.keywords'))">
  <meta name="description" content="@yield('description', __('panel/register.description'))">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
  <link rel="stylesheet" href="{{ mix('build/panel/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ mix('build/panel/css/app.css') }}">
  <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ mix('build/panel/js/app.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/layer/3.5.1/layer.js') }}"></script>
  @stack('header')
</head>
<body class="page-login">
  <div class="">
    <div class="container vh-100 pt-2 pt-sm-5 pb-4 pb-sm-5">
      <div class="locale-wrap">
        <div class="d-flex align-items-center locale">
          <div class="wh-20 me-2"><img src="{{ image_origin('images/flag/'. panel_locale_code().'.png') }}" class="img-fluid"></div>
          <span class="">{{ current_panel_locale()['name'] }} <i class="bi bi-chevron-down"></i></span>
          <ul class="dropdown-menu">
            @foreach (panel_locales() as $locale)
            <li>
              <a class="dropdown-item d-flex" href="{{ panel_route('login.index', ['locale'=> $locale['code']]) }}">
                <div class="wh-20 me-2"><img src="{{ image_origin($locale['image']) }}" class="img-fluid"></div>
                {{ $locale['name'] }}
              </a>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="login-wrap">
        <div class="card login-content">
            <div class="card-header">
              <h3 class="fw-bold text-center">{{ __('panel/register.login_index') }}</h3>
            </div>

            <div class="card-body">
              
              <?php /* <form action="{{ panel_route('login.store') }}" method="post">
                @csrf

                <div class="form-floating mb-4">
                  <input type="text" name="email" class="form-control" id="email-input" value="{{ old('email', $admin_email ?? '') }}" placeholder="{{ __('common.email') }}">
                  <label for="email-input">{{ __('panel/login.email') }}</label>
                  @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-floating mb-5">
                  <input type="password" name="password" class="form-control" id="password-input" value="{{ old('password', $admin_password ?? '') }}" placeholder="{{ __('shop/login.password') }}">
                  <label for="password-input">{{ __('panel/login.password') }}</label>
                  @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>

                @if (session('error'))
                  <div class="alert alert-danger">
                    {{ session('error') }}
                  </div>
                @endif

                <div class="d-grid mb-4"><button type="submit" class="btn btn-lg btn-primary">{{ __('panel/common.btn_submit') }}</button></div>
              </form>
              */ ?>
              <form class="needs-validation" novalidate id="app-form" action="{{ panel_route('login.store_seller') }}"  method="POST">
              @csrf
              @method('POST')

                <div class="form-floating mb-4">
                    <input type="text" name="name" class="form-control" id="email-input" value="{{ old('name') }}" placeholder="{{ __('register.name') }}">
                    <label for="email-input">{{ __('panel/register.name') }}</label>
                    @error('email')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <input type="text" name="email" class="form-control" id="email-input" value="{{ old('email') }}" placeholder="{{ __('common.email') }}">
                    <label for="email-input">{{ __('panel/register.email') }}</label>
                    @error('email')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-5">
                    <input type="password" name="password" class="form-control" id="password-input" value="{{ old('password') }}" placeholder="{{ __('panel/register.password') }}">
                    <label for="password-input">{{ __('panel/register.password') }}</label>
                    @error('password')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <input type="text" name="whatsapp_no" class="form-control" id="email-input" value="{{ old('whatsapp_no') }}" placeholder="{{ __('register.whatsapp_no') }}">
                    <label for="email-input">{{ __('panel/register.whatsapp_no') }}</label>
                    @error('email')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                @if (session('error'))
                  <div class="alert alert-danger">
                    {{ session('error') }}
                  </div>
                @endif

              <input type="hidden" name="locale" value="en">
              <input type="hidden" name="roles[]" value="1">
              <div class="d-grid mb-4"><button type="submit" class="btn btn-lg btn-primary">{{ __('panel/common.btn_submit') }}</button></div>
            </form>
            </div>
        </div>
        <p class="text-center text-secondary mt-5">
          {{ config('app.name') }}&copy; {{ date('Y') }} All Rights Reserved
        </p>
      </div>

    </div>
  </div>
</body>
</html>
