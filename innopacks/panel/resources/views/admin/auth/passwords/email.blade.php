<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ panel_locale_direction() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="{{ panel_route('home.index') }}">
  <title>@yield('title', __('panel/login.reset_password'))</title>
  <meta name="keywords" content="@yield('keywords', __('panel/login.keywords'))">
  <meta name="description" content="@yield('description', __('panel/login.description'))">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
  <link rel="stylesheet" href="{{ mix('build/panel/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ mix('build/panel/css/app.css') }}">
  <script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ mix('build/panel/js/app.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/layer/3.5.1/layer.js') }}"></script>
  @stack('header')
   <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
    }

    body {
      min-height: 100vh;
      background: #f7f9fc;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 20px;
      color: #253858;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .login-wrap {
      width: 100%;
    }

    .wrapper {
      width: 1200px;
      max-width: 100%;
      display: flex;
      background: transparent;
      position: relative;
      flex-wrap: wrap;
    }

    .panel {
      background: #fff;
      box-shadow: 0 14px 35px rgba(45, 80, 130, 0.12);
      min-height: auto;
    }

    .left-panel {
      margin-left: 5%;
      width: 50%;
      padding: 70px 80px;
      position: relative;
      z-index: 1;
    }

    .right-panel {
      width: 42%;
      padding: 40px 70px;
      margin-left: -20px;
      z-index: 2;
    }

    h1 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 34px;
      color: #253858;
    }

    .features {
      list-style: none;
      margin-bottom: 34px;
    }

    .features li {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      font-size: 17px;
      line-height: 1.6;
      color: #253858;
      margin-bottom: 18px;
    }

    .check {
      color: #82a9d6;
      font-size: 20px;
      line-height: 1.2;
      margin-top: 1px;
      flex-shrink: 0;
    }

    .register-btn {
      display: inline-block;
      padding: 14px 44px;
       border: 1px solid #d9a234;
      color: #DB9200;
      background: #fff;
      border-radius: 2px;
      font-size: 18px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 1px 0 rgba(0, 0, 0, 0.02);
    }

    .illustration {
      position: absolute;
      right: 40px;
      bottom: 25px;
      width: 240px;
      opacity: 0.98;
    }

    .form-group {
      margin-bottom: 30px;
    }

    label {
      display: block;
      font-size: 14px;
      font-weight: 700;
      color: #253858;
      margin-bottom: 8px;
    }

    input {
      width: 100%;
      height: 55px;
      border: 1px solid #d9dde7;
      outline: none;
      padding: 0 14px;
      font-size: 15px;
      color: #253858;
      background: #fff;
    }

    input::placeholder {
      color: #b7becb;
    }

    .password-wrap {
      position: relative;
    }

    .show-text {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #7e9dc5;
      font-size: 15px;
      cursor: pointer;
      user-select: none;
    }

    .forgot {
      text-align: right;
      margin-top: 10px;
      margin-bottom: 24px;
      font-size: 14px;
      color: #7e9dc5;
    }

    .login-btn {
      width: 100%;
      height: 48px;
      border: none;
      background: #DB9200;
      color: white;
      font-size: 18px;
      font-weight: 700;
      cursor: pointer;
      margin-bottom: 18px;
    }

    .otp-link {
      text-align: center;
      color: #a57f31;
      font-size: 16px;
      margin-bottom: 28px;
    }

    .divider {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 20px 0 28px;
      color: #9aa6b7;
      font-size: 14px;
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #dcdfe6;
    }

    .google-btn {
      width: 100%;
      height: 50px;
      border: 1px solid #e6eaf0;
      border-radius: 25px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 14px;
      color: #6c7785;
      font-size: 16px;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .google-btn img {
      width: 22px;
      height: 22px;
    }

    .header-logo-r {
      height: 40px;
    }

    .login-wrap p {
      margin-bottom: 0;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 980px) {
      .wrapper {
        flex-direction: column;
        width: 100%;
      }

      .left-panel,
      .right-panel {
        width: 100%;
        margin-left: 0;
        padding: 40px 30px;
      }

      .left-panel {
        margin-bottom: 20px;
      }

      h1 {
        font-size: 24px;
        margin-bottom: 24px;
      }

      .features li {
        font-size: 15px;
        margin-bottom: 14px;
      }

      .register-btn {
        padding: 12px 30px;
        font-size: 16px;
      }

      input {
        height: 48px;
        font-size: 16px;
      }

      .login-btn {
        height: 50px;
        font-size: 16px;
      }

      .header-logo-r {
        height: 35px;
      }
    }

    @media (max-width: 576px) {
      body {
        padding: 15px;
        align-items: flex-start;
      }

      .left-panel,
      .right-panel {
        padding: 30px 20px;
      }

      h1 {
        font-size: 22px;
        margin-bottom: 20px;
      }

      .features li {
        font-size: 14px;
        gap: 10px;
      }

      .check {
        font-size: 18px;
      }

      .register-btn {
        padding: 12px 24px;
        font-size: 15px;
        display: block;
        text-align: center;
      }

      label {
        font-size: 13px;
      }

      input {
        height: 46px;
        font-size: 15px;
        padding: 0 12px;
      }

      .show-text {
        font-size: 14px;
        right: 12px;
      }

      .login-btn {
        height: 48px;
        font-size: 15px;
      }

      .header-logo-r {
        height: 32px;
      }
    }
  </style>
</head>
<body class="page-login1 mt-4">
  <div class="row d-flex justify-content-center pt-5">
    <div class="wrapper">
      <div class="panel left-panel">
        <div class="header-logo-r d-flex justify-content-center mb-4">
          <a href="#" class="register-sidebar-logo">
            <img src="{{ image_origin(system_setting('panel_logo', 'images/logo-panel.png')) }}" class="img-fluid register" alt="Logo">
          </a>
        </div>
        <ul class="features">
          <li><span class="check">✓</span><span>Reset password on BuySellGhar Seller profile.</span></li>
          <li><span class="check">✓</span><span>Grow your Real E-state business on BuySellGhar.com.</span></li>
        </ul>
        <a href="{{ panel_route('login.index') }}" class="register-btn">Login Here</a>
      </div>
      <div class="panel right-panel ">
     
        <form action="{{ panel_route('password.email') }}" method="post">
          @csrf
         
          <h1>{{ __('panel/login.reset_password') }}</h1>

          <div class="form-group">
            <label for="email-input">{{ __('panel/login.email') }}</label>
            <input type="email" name="email" id="email-input" value="{{ old('email', $email ?? '') }}"  placeholder="{{ __('panel/login.email') }}" required>
            @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          @if (session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
          @endif
          <div class="d-grid mb-4"><button type="submit" class="login-btn">{{ __('panel/common.send_reset_link') }}</button></div>
        </form>
      </div>
    </div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.toggle-password');
    
        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const input = this.previousElementSibling;
    
                if (input.type === 'password') {
                    input.type = 'text';
                    this.textContent = 'Hide';
                } else {
                    input.type = 'password';
                    this.textContent = 'Show';
                }
            });
        });
    });
  </script>
</body>
</html>
