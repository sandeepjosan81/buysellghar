@hookinsert('layout.header.top')
<header class="site-header sticky-top">
        <nav class="navbar navbar-expand-lg top-navbar">
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

                <form action="{{ front_route('products.index') }}" method="get" class="search-wrap d-none d-lg-flex">
                <label for="searchInput" class="visually-hidden">Search</label>
                  <input id="searchInput" type="search" class="form-control" name="keyword" placeholder="{{ __('front/common.search') }}"
                    value="{{ request('keyword') }}" aria-label="Search">
                  <button type="submit" class="btn btn-warning fw-semibold">Search</button>
                </form>


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
                        <div class="item">
                          <a href="{{ account_route('favorites.index') }}" class="header-icon-btn" aria-label="Wishlist">
                              <i class="bi bi-heart"></i>
                              <span class="icon-count">{{ $favTotal }}</span>
                          </a>
                        </div>
                        <div class="item">
                            <a href="javascript:void(0)" class="header-cart-icon header-icon-btn" aria-label="Cart" data-bs-toggle="offcanvas"
                              data-bs-target="#miniCart" aria-controls="miniCart">
                              <i class="bi bi-cart3"></i>
                              <span class="icon-quantity icon-count">0</span>
                            </a>
                        </div>
                        
                        @hookinsert('layouts.header.cart.after')

                          <div class="dropdown">
                            <button class="header-icon-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                                <i class="bi bi-person-circle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                  @if ($customer)
                                  <li><a href="{{ front_route('account.index') }}" class="dropdown-item">{{ __('front/account.account') }}</a></li>
                                  <li><a href="{{ front_route('account.orders.index') }}"
                                    class="dropdown-item">{{ __('front/account.orders') }}</a></li>
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
                    </div>
                </div>
            </div>
        </nav>

        <div class="header-mobile">
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
            <ul class="mobile-cart-icon">
              <li>
                <a href="{{ account_route('favorites.index') }}" class="header-icon-btn" aria-label="Wishlist">
                  <img src="{{ asset('images/icons/love.svg') }}" class="img-fluid">
                  <span class="icon-quantity">{{ $favTotal }}</span>
                </a>
              </li>
              <li>
                <a href="{{ front_route('carts.index') }}" class="header-cart-icon"><img
                    src="{{ asset('images/icons/cart.svg') }}" class="img-fluid"><span class="icon-quantity">0</span></a>
              </li>
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
        <div id="categories" class="category-strip border-bottom  ">
            <div class="container">
              <!-- justify-content-lg-start -->
                <div class="d-flex flex-wrap gap-2 py-2 justify-content-center ">
                  @foreach ($activeCategories as $category )
                    <a href="{{ $category->url }}" class="chip-link">{{ $category->fallbackName() }}</a>
                  @endforeach
                </div>
            </div>
        </div>
    </header>










