@hookinsert('layout.footer.top')

<footer id="appFooter">
  <div class="footer-box">
    <div class="container">
      <div class="footer-top-links">
        <div class="row">
          <div class="col-12 col-md-4 footer-item">
            <div class="about">
              <div class="footer-link-title">
                <span>{{ __('front/common.about_us') }}</span>
                <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
              </div>
              <div class="about-text footer-item-content">
                <p>
                  {{ system_setting_locale('meta_description', '') }}
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-8">
            <div class="row">
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>{{ __('front/common.products') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach($footerMenus['categories'] as $item)
                      <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>{{ __('front/common.news') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach($footerMenus['catalogs'] as $item)
                      <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>{{ __('front/common.pages') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach($footerMenus['pages'] as $item)
                      <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-12 col-md-3 footer-item">
                <div class="footer-links">
                  <div class="footer-link-title">
                    <span>{{ __('front/common.specials') }}</span>
                    <div class="footer-link-icon"><i class="bi bi-plus-lg"></i></div>
                  </div>
                  <ul class="footer-item-content">
                    @foreach($footerMenus['specials'] as $item)
                      <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-box">
        <div class="row">
          <div class="col-md-6">
            <div class="left-links">
              {!! innoshop_brand_link() !!}
              <!-- Powered By InnoShop {{ innoshop_version() }} -->
              <span class="copyright-text">
                <a href="{{ front_route('home.index') }}" class="ms-2" target="_blank">{{ config('app.name') }}</a>
                &copy; {{ date('Y') }} All Rights Reserved
                <?php /* @if(system_setting('icp_number', ''))
                  <a href="https://beian.miit.gov.cn" class="ms-2" target="_blank">{{ system_setting('icp_number', '') }}</a>
                @endif 
               */  ?>
              </span>
            </div>
          </div>
          <!-- <div class="col-md-6">
            <div class="payment-icon">
              <img src="{{ asset('images/demo/payment/1.png') }}" class="img-fluid">
              <img src="{{ asset('images/demo/payment/2.png') }}" class="img-fluid">
              <img src="{{ asset('images/demo/payment/3.png') }}" class="img-fluid">
              <img src="{{ asset('images/demo/payment/4.png') }}" class="img-fluid">
              <img src="{{ asset('images/demo/payment/5.png') }}" class="img-fluid">
            </div>
          </div> -->
      </div>
      </div>
    </div>
  </div>
</footer>

@hookinsert('layout.footer.bottom')

<!-- Trigger button -->
<!-- <button type="button" data-bs-toggle="modal" data-bs-target="#leadContactModal">
  Get Contact
</button> -->
<!-- Modal -->

<div class="justify-content-center pt-4 modal fade" id="leadContactModal" tabindex="-1" aria-labelledby="leadContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content border-0 shadow-md rounded-4 overflow-hidden">
          <div class="modal-header">
            <h4>Get Owner Contact Details</h4>
            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-md-4">            
            <div class="wrapper">
                <div class="panel1">
                  <form class="needs-validation" novalidate id="app-form" action="{{ front_route('leadcontact.store') }}" method="POST">
                    @csrf
                    @method('POST')                    

                    <div class="form-group mb-3">
                      <label for="name-input">{{ __('front/common.name') }}</label>
                      <input type="text" name="name" class="field" id="name-input" value="{{ old('name') }}" placeholder="{{ __('panel/register.name') }}" required>
                      @error('name')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <label for="email-input">{{ __('front/common.email') }}</label>
                      <input type="email" name="email" class="field" id="email-input" value="{{ old('email') }}" placeholder="{{ __('panel/register.email') }}" required>
                      @error('email')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                      @enderror
                    </div>                    

                    <div class="form-group mb-3">
                      <label for="contact_no"><i class="bi bi-whatsapp"></i>{{ __('front/common.contact_no') }}</label>
                      <input type="text" name="contact_no" class="field" id="contact_no" minlength="10"
       maxlength="15" value="{{ old('contact_no') }}" placeholder="{{ __('front/common.contact_no') }}" required>
                      @error('contact_no')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                      @enderror
                    </div>

                    @if (session('error'))
                    <div class="alert alert-danger">
                      {{ session('error') }}
                    </div>
                    @endif

                    <input type="hidden" id="" name="product_id" value="">
                    <input type="hidden" id="property_url" name="property_url" value="">
                    <div class="d-grid mb-4"><button type="submit" class="login-btn">{{ __('panel/common.btn_submit') }}</button></div>
                  </form>
                  <div id="form-message"></div>
              </div>
            </div>
          </div>
      </div>
  </div>
</div>


<style>

  .was-validated .field:invalid,
    .field.is-invalid {
        border-color: #dc3545;
    }

    .field.is-valid {
        border-color: #198754;
    }
    /* * {
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
    } */

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
      width: 100%;
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

    .field {
      width: 100%;
      height: 45px;
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

@if (system_setting('js_code', ''))
  {!! system_setting('js_code', '') !!}
@endif