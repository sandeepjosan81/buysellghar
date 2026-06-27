@hookinsert('layout.header.top')
@php
    $detect = new \Detection\MobileDetect;
    $isMobile = $detect->isMobile();

    $propertyProps = new InnoShop\Common\Models\Product\PropertyProps;

@endphp
<header class="site-header sticky-top">
    @if(!$detect->isMobile())
          <nav class="navbar navbar-expand-lg top-navbar h-60">
            <div class="container gap-2">
                <div class="header-desktop">
                  <div class="container d-flex justify-content-between align-items-center">
                    <div class="left">
                      <h1 class="logo">
                        <a href="{{ front_route('home.index') }}">
                          <img src="{{ image_origin(system_setting('front_logo', 'images/logo.svg')) }}" class="img-fluid">
                        </a>
                      </h1>
                    </div>
                  </div>
                </div>
                <!-- <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <!-- <form action="{{ front_route('products.index') }}" method="get" class="search-wrap d-none d-lg-flex">
                  <label for="searchInput" class="visually-hidden">Search</label>
                  <input id="searchInput" type="search" class="form-control" name="keyword" placeholder="{{ __('front/common.search') }}"
                    value="{{ request('keyword') }}" aria-label="Search">
                  <button type="submit" class="btn btn-warning fw-semibold">Search</button>
                </form> -->


                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-2">
                        <li class="nav-item">
                          <a class="nav-link" aria-current="page"
                            href="{{ front_route('home.index') }}">{{ __('front/common.home') }}</a>
                        </li>
                        @hookupdate('layouts.header.menu.pc')
                        @foreach ($headerMenus as $menu)
                          @if ($menu['children'] ?? [])
                            <li class="nav-item">
                              <div class="dropdown">
                                @if ($menu['name'])
                                  <a class="nav-link text-white-50 nav-link {{ equal_url($menu['url']) ? 'active' : '' }}"
                                    href="{{ $menu['url'] }}">{{ $menu['name'] }}</a>
                                @endif
                                <ul class="dropdown-menu">
                                  @foreach ($menu['children'] as $child)
                                    @if ($child['name'])
                                      <li><a class="dropdown-item" href="{{ $child['url'] }}">{{ $child['name'] }}</a></li>
                                    @endif
                                  @endforeach
                                </ul>
                              </div>
                            </li>
                          @else
                            @if ($menu['name'])
                              <li class="nav-item">
                                <a class=" nav-link text-white-50 nav-link {{ equal_url($menu['url']) ? 'active' : '' }}"
                                  href="{{ $menu['url'] }}">{{ $menu['name'] }}</a>
                              </li>
                            @endif
                          @endif                          

                        @endforeach
                        @endhookupdate
                        <li class="nav-item">
                            @hookinsert('layouts.header.news.before')
                            <a class="nav-link" href="{{ front_route('articles.index') }}">Blog</a>
                        </li>
                    </ul>
                  
                    <div class="header-actions ms-lg-3"> 
                        <div class="post-property"><a href="{{ panel_route('products.create') }}" class="contact-btn">{{ __('front/common.post_text') }}</a></div>                       
                        <div class="item">
                          <a href="{{ account_route('favorites.index') }}" class="header-icon-btn" aria-label="Wishlist">
                              <i class="bi bi-heart"></i>
                              <span class="icon-count">{{ $favTotal }}</span>
                          </a>
                        </div>
                        <?php 
                            /*
                                <div class="item">
                                    <a href="javascript:void(0)" class="header-cart-icon header-icon-btn" aria-label="Cart" data-bs-toggle="offcanvas"
                                    data-bs-target="#miniCart" aria-controls="miniCart">
                                    <i class="bi bi-cart3"></i>
                                    <span class="icon-quantity icon-count">0</span>
                                    </a>
                                </div>
                            */
                        ?>                        
                        @hookinsert('layouts.header.cart.after')
                        <?php /*
                            <div class="dropdown">
                                <button class="header-icon-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                                    <i class="bi bi-person-circle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if ($customer)
                                    <li><a href="{{ front_route('account.favorites.index') }}" class="dropdown-item">{{ __('front/account.account') }}</a></li>
                                    <!-- <li><a href="{{ front_route('account.orders.index') }}"
                                        class="dropdown-item">{{ __('front/account.orders') }}</a></li> -->
                                    <li><a href="{{ front_route('account.favorites.index') }}"
                                        class="dropdown-item">{{ __('front/account.favorites') }}</a></li>
                                    <li><a href="{{ front_route('account.logout') }}" class="dropdown-item">{{ __('front/account.logout') }}</a></li>
                                    @else
                                    <li><a href="{{ front_route('login.index') }}" class="dropdown-item">{{ __('front/common.login') }}</a></li>
                                    <li><a href="{{ front_route('register.index') }}"
                                        class="dropdown-item">{{ __('front/common.register') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        */ ?>
                    </div>
                </div>
            </div>
        </nav>
      @else
        <div class="header-mobile border-bottom">
          <div class="mb-icon" data-bs-toggle="offcanvas" data-bs-target="#mobile-menu-offcanvas"
            aria-controls="offcanvasExample">
            <i class="bi bi-list"></i>
          </div>

          <div class="logo">
            <a href="{{ front_route('home.index') }}">
              <img src="{{ image_origin(system_setting('front_logo', 'images/logo.svg')) }}" class="img-fluid">
            </a>
          </div>
          <div>
            <ul class="mobile-cart-icon mb-1">
                <li><div class="post-property"><a href="{{ panel_route('products.create') }}" class="contact-btn-mob">{{ __('front/common.post_text_mobile') }}</a></div> </li>
              <!-- <li>
                
                <a href="{{ account_route('favorites.index') }}" class="header-icon-btn" aria-label="Wishlist">
                  <img src="{{ asset('images/icons/love.svg') }}" class="img-fluid">
                  <span class="icon-quantity">{{ $favTotal }}</span>
                </a>
              </li> -->
            </ul>
          </div>

          <div class="offcanvas offcanvas-start" tabindex="-1" id="mobile-menu-offcanvas">
            <div class="offcanvas-header">
              <form action="{{ front_route('products.index') }}" method="get" class="search-group">
                <input type="text" class="form-control" name="keyword" placeholder="{{ __('front/common.search') }}"
                  value="{{ request('keyword') }}">
                <button type="submit" class="btn"><i class="bi bi-search"></i></button>
              </form>
              <a class="account-icon" href="{{ front_route('account.index') }}">
                <img src="{{ asset('images/icons/account.svg') }}" class="img-fluid">
              </a>
            </div>
            <div class="close-offcanvas" data-bs-dismiss="offcanvas"><i class="bi bi-chevron-compact-left"></i></div>
            <div class="offcanvas-body mobile-menu-wrap">
              <div class="accordion accordion-flush" id="menu-accordion">
                <div class="accordion-item">
                  <div class="nav-item-text">
                    <a class="nav-link {{ equal_route_name('home.index') ? 'active' : '' }}" aria-current="page"
                      href="{{ front_route('home.index') }}">{{ __('front/common.home') }}</a>
                  </div>
                </div>

                @hookupdate('layouts.header.menu.mobile')
                @foreach ($headerMenus as $key => $menu)
                  @if ($menu['name'])
                    <div class="accordion-item">
                      <div class="nav-item-text">
                        <a class="nav-link" href="{{ $menu['url'] }}" data-bs-toggle="{{ !$menu['url'] ? 'collapse' : '' }}">
                          {{ $menu['name'] }}
                        </a>
                        @if (isset($menu['children']) && $menu['children'])
                          <span class="collapsed" data-bs-toggle="collapse" data-bs-target="#flush-menu-{{ $key }}"><i
                              class="bi bi-chevron-down"></i></span>
                        @endif
                      </div>

                      @if (isset($menu['children']) && $menu['children'])
                        <div class="accordion-collapse collapse" id="flush-menu-{{ $key }}" data-bs-parent="#menu-accordion">
                          <div class="children-group">
                            <ul class="nav flex-column ul-children">
                              @foreach ($menu['children'] as $c_key => $child)
                                @if ($child['name'])
                                  <li class="nav-item">
                                    <a class="nav-link" href="{{ $child['url'] }}">{{ $child['name'] }}</a>
                                  </li>
                                @endif
                              @endforeach
                            </ul>
                          </div>
                        </div>
                      @endif
                    </div>
                  @endif
                @endforeach
                @endhookupdate
              </div>
            </div>
          </div>
        </div>  
      @endif  
        <?php
        /*
          <div id="categories" class="category-strip border-bottom  ">
              <div class="container">
                  <div class="d-flex flex-wrap gap-2 py-2 justify-content-center ">
                    @foreach ($activeCategories as $category )
                      <a href="{{ $category->url }}" class="chip-link">{{ $category->fallbackName() }}</a>
                    @endforeach
                  </div>
              </div>
          </div>
        */ ?>
        <!-- {{ Route::currentRouteName() }} -->
@if (!in_array(Route::currentRouteName(), ['front.register.index','front.login.index','front.articles.index']))    
    @if(!$detect->isMobile())
        <section class="d-flex search-filters border-bottom bg-white align-items-center">
            <div class="container">
                <form action="{{ front_route('products.index') }}" method="get">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-md-2 g-3">
                            <input id="searchInput" type="search"
                                class="select-style"
                                name="keyword"
                                placeholder="{{ __('front/common.search') }}"
                                value="{{ request('keyword') }}"
                                aria-label="Search">
                        </div>

                        <div class="col-6 col-md-2  g-3">
                            <select name="city" id="citySelect" class="form-search-select w-100">
                                <option value="">Select City</option>
                                @foreach ($cities as $c)
                                    <option value="{{ $c->city }}"  {{ request('city') === $c->city ? 'selected' : '' }} >{{ ucfirst($c->city) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-2  g-3">
                            <select name="list_type" class="form-search-select w-100" id="typeSelect" >
                                <option value="">Select Type</option>
                                @foreach ($activeCategories as $category)
                                    <option value="{{ $category->id }}" {{ request('list_type') == $category->id ? 'selected' : '' }}>{{ $category->fallbackName() }}</option>
                                
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2  g-3">
                            <select name="possession_status" class="form-search-select w-100" id="possessionSelect">
                                <option value="">Possession Status</option>
                                @foreach ($possession as $key=>$p)
                                    <option value="{{ $key }}"  {{ old('possession_status', request('possession_status')) === $key ? 'selected' : '' }} >{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center pb-2">
                        <div class="col-6 col-md-2  g-3">
                            <select name="property_for" id="propertyForSelect" class="form-search-select w-100">
                                <option value="">Select Sale/Rent</option>
                                @foreach ($forSailRent as $key=>$sr)
                                    <option value="{{ $key }}"  {{ old('property_for', request('property_for')) === $key ? 'selected' : '' }} >{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>                

                        <div class="col-6 col-md-1 g-3 sale">
                            <select name="budget_min" class="form-search-select w-100" id="minSelect" >
                                <option value="">Min</option>
                                @foreach ($budget as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_min') == $key ? 'selected' : '' }} >{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-1 g-3 sale">
                            <select name="budget_max" class="form-search-select w-100" id="maxSelect">
                                <option value="">Max</option>
                                @foreach ($budget as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_max') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-1 g-3 rent"  style="display:none">
                            <select name="budget_min" class="form-search-select w-100" id="minSelect" >
                                <option value="">Min</option>
                                @foreach ($budgetRent as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_min') == $key ? 'selected' : '' }} >{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>
                            
                        <div class="col-6 col-md-1 g-3 rent"  style="display:none">
                            <select name="budget_max" class="form-search-select w-100" id="maxSelect">
                                <option value="">Max</option>
                                @foreach ($budgetRent as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_max') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-1 g-3 ">
                            <select name="bedrooms" class="form-search-select w-100" id="bhkSelect">
                                <option value="">BHK</option>
                                @foreach ($bhk as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('bedrooms') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-6 col-md-2 g-3 ">
                            <select name="bedrooms" class="form-search-select w-100" id="bhkSelect">
                                <option value="">Furnished Status</option>
                                @foreach ($furnishedStatus as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('furnished_status') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                                
                            </select>
                        </div>                

                        <div class="col-12 col-md-1 mt-1 ">
                            <button type="submit" class="btn btn-primary-btn w-100 fw-semibold h35 mt-3">
                                Search
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </section>
    @endif

    @if($detect->isMobile())
        <div class="d-md-none">
            <div class="mobile-filter-trigger" data-bs-toggle="offcanvas" data-bs-target="#mobileFilterOffcanvas" aria-controls="mobileFilterOffcanvas">
                <span class="text-muted">Property Search, City, Budget...</span>
                <i class="bi bi-search mirrored-icon"></i>
            </div>
        </div>

        <div class="offcanvas  mobile-filter-offcanvas" tabindex="-1" id="mobileFilterOffcanvas" aria-labelledby="mobileFilterOffcanvasLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="mobileFilterOffcanvasLabel">Filter Properties</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <form action="{{ front_route('products.index') }}" method="get">
                    <div class="row g-3">               

                        <div class="col-12 col-md-2 g-3">
                            <input id="searchInput" type="search"
                                class="select-style"
                                name="keyword"
                                placeholder="{{ __('front/common.search') }}"
                                value="{{ request('keyword') }}"
                                aria-label="Search">
                        </div>

                        <div class="col-6 col-md-2  g-3">
                            <select name="city" id="citySelect" class="form-search-select w-100">
                                <option value="">Select City</option>
                                @foreach ($cities as $c)
                                    <option value="{{ $c->city }}"  {{ request('city') === $c->city ? 'selected' : '' }} >{{ $c->city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-2  g-3">
                            <select name="list_type" class="form-search-select w-100" id="typeSelect" >
                                <option value="">Select Type</option>
                                @foreach ($activeCategories as $category)
                                    <option value="{{ $category->id }}" {{ request('list_type') == $category->id ? 'selected' : '' }}>{{ $category->fallbackName() }}</option>
                                
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-1  g-3">
                            <select name="property_for" id="propertyForSelect" class="form-search-select w-100">
                                <option value="">Select Sale/Rent</option>
                                @foreach ($forSailRent as $key=>$sr)
                                    <option value="{{ $key }}"  {{ old('property_for', request('property_for')) === $key ? 'selected' : '' }} >{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>                
                        <div class="col-6 col-md-1 g-3 sale">
                            <select name="budget_min" class="form-search-select w-100" id="minSelect" >
                                <option value="">Min</option>
                                @foreach ($budget as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_min') == $key ? 'selected' : '' }} >{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-1 g-3 sale">
                            <select name="budget_max" class="form-search-select w-100" id="maxSelect">
                                <option value="">Max</option>
                                @foreach ($budget as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_max') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-1 g-3 rent"  style="display:none">
                            <select name="budget_min" class="form-search-select w-100" id="minSelect" >
                                <option value="">Min</option>
                                @foreach ($budgetRent as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_min') == $key ? 'selected' : '' }} >{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>
                            
                        <div class="col-6 col-md-1 g-3 rent"  style="display:none">
                            <select name="budget_max" class="form-search-select w-100" id="maxSelect">
                                <option value="">Max</option>
                                @foreach ($budgetRent as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('budget_max') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="col-6 col-md-1 g-3 ">
                            <select name="bedrooms" class="form-search-select w-100" id="bhkSelect">
                                <option value="">BHK</option>
                                @foreach ($bhk as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('bedrooms') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-6 col-md-2  g-3">
                            <select name="possession_status" class="form-search-select w-100" id="possessionSelect">
                                <option value="">Possession Status</option>
                                @foreach ($possession as $key=>$p)
                                    <option value="{{ $key }}"  {{ old('possession_status', request('possession_status')) === $key ? 'selected' : '' }} >{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-1 g-3 ">
                            <select name="bedrooms" class="form-search-select w-100" id="bhkSelect">
                                <option value="">Furnished Status</option>
                                @foreach ($furnishedStatus as $key=>$sr)
                                    <option value="{{ $key }}" {{ request('furnished_status') == $key ? 'selected' : '' }}>{{ $sr }}</option>
                                @endforeach
                                
                            </select>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-btn w-100 fw-semibold">
                                Search
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif
@endif

</header>

@push("footer")
<script>
    $(document).ready(function() {
        $('#propertyForSelect').on('change', function() {
            if ($(this).val() === 'sale') {
                $('.sale').show(); // Makes the div visible
                $('.rent').hide(); // Makes the div visible
            } else {
                $('.rent').show(); // Hides the div
                $('.sale').hide(); // Makes the div visible
            }
        });
    });    
</script>   
  <script>

    $('.custom_contact').on('click', function() {
      var productId = $(this).data('product-id');
      var propertyUrl = $(this).data('url');
      console.log(productId, propertyUrl);
      $('#app-form input[name="product_id"]').val(productId);
      $('#app-form input[name="property_url"]').val(propertyUrl);
    });
$(document).ready(function () {
  
    $('#app-form').on('submit', function (e) {
        e.preventDefault();
        let form = this;
        // Bootstrap validation
        if (!form.checkValidity()) {
            e.stopPropagation();
            $(form).addClass('was-validated');
            return;
        }
        let submitBtn = $(form).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('Submitting...');
        // Remove old errors
        $('.invalid-feedback.ajax-error').remove();
        $('.is-invalid').removeClass('is-invalid');
        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            dataType: 'json',

            success: function (response) {
                $('#form-message').html(
                    '<div class="alert alert-success">' +
                    (response.message || 'Form submitted successfully.') +
                    '</div>'
                );
                form.reset();
                $(form).removeClass('was-validated');
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        let input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after(
                            '<div class="invalid-feedback ajax-error">' +
                            messages[0] +
                            '</div>'
                        );
                    });
                } else {
                    $('#form-message').html(
                        '<div class="alert alert-danger">' +
                        (xhr.responseJSON?.message || 'Something went wrong.') +
                        '</div>'
                    );
                }
            },
            complete: function () {
                submitBtn.prop('disabled', false).html('{{ __("front/common.btn_submit") }}');
            }
        });
    });

});
</script> 
@endpush









