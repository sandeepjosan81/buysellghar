@extends('layouts.app')
@section('body-class', 'page-home')

@push('header')
<script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">
@endpush

@section('content')

@hookinsert('home.content.top')

<section class="module-content">
    @if (@$slideshow[0]['image'][front_locale_code()] ?? false)
    <section class="module-line">
        <div class="swiper" id="module-swiper-1">
            <div class="module-swiper swiper-wrapper">
                @foreach ($slideshow as $slide)
                @if ($slide['image'][front_locale_code()] ?? false)
                <div class="swiper-slide">
                    <a href="{{ $slide['link'] ?: 'javascript:void(0)' }}">
                      <img src="{{ image_origin($slide['image'][front_locale_code()]) }}" class="img-fluid"></a>
                </div>
                @endif
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <script>
    var swiper = new Swiper('#module-swiper-1', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
    });
    </script>
    @endif

    @hookinsert('home.swiper.after')

    @if (0)
    <section class="module-line">
        <div class="module-banner-2">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 mb-2 mb-lg-0">
                        <a href=""><img src="{{ asset('images/demo/banner/banner-3.jpg') }}" class="img-fluid"></a>
                    </div>
                    <div class="col-12 col-md-8">
                        <a href=""><img src="{{ asset('images/demo/banner/banner-4.jpg') }}" class="img-fluid"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <main>
        <section id="home" class="hero-section py-4">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-8">
                        <div class="hero-banner shadow-sm">
                            <p class="eyebrow mb-2 text-white-50">{{ __('front/product.big_saving_fest') }}</p>
                            <h1 class="display-6 fw-bold mb-2 text-white ads-flash-text">{{ __('front/product.up_to_saving_text') }}</h1>
                            <p class="text-white-50 mb-4">{{ __('front/product.home_ads_sub_title') }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="/products" class="btn btn-warning fw-semibold">{{ __('front/product.shop_deals') }}</a>
                                <!-- <a href="#offers" class="btn btn-outline-light">Today's Offers</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="quick-deals p-3">
                            <h2 class="h6 mb-3 fw-bold">{{ __('front/product.todays_deals') }}</h2>
                            <ul class="list-unstyled mb-0 d-grid gap-2">
                                @foreach (@$today_deal_products as $deal)
                                <li class="deal-line">
                                    <a href="{{ $deal->url }}" class="d-flex align-items-center gap-2 text-decoration-none" title="{{ $deal->fallbackName() }}">
                                        <img src="{{ $deal->image_url }}" alt="{{ $deal->fallbackName() }}"
                                            class="deal-thumb" />
                                          </a>
                                        <div class="d-flex">
                                            <a href="{{ $deal->url }}" class="d-flex align-items-center gap-2 text-decoration-none" title="{{ $deal->fallbackName() }}">
                                            <span class="text-decoration-none " title="{{ $deal->fallbackName() }}">
                                              {{ getFivewords($deal->fallbackName(), 5) }}
                                                
                                            </span>
                                            </a>
                                              <div class="d-flex">
                                                  <div class="product-price d-flex gap-1 mb-0 ps-2">
                                                      <div class="price-new">
                                                          <strong>{{ $deal->masterSku->getFinalPriceFormat() }}</strong>
                                                      </div>
                                                      @if ($deal->masterSku->origin_price)
                                                      <div class="price-old">{{ $deal->masterSku->origin_price_format }}</div>
                                                      @endif
                                                  </div>
                                                   <!-- @if(!system_setting('disable_online_order'))
                                                      <div class="btn-add-cart cursor-pointer btn btn-sm btn-cart fw-semibold mb-1"
                                                          data-id="{{ $deal->id }}" data-price="{{ $deal->masterSku->getFinalPrice() }}"
                                                          data-sku-id="{{ $deal->masterSku->id }}">{{ __('front/cart.add_to_cart') }}
                                                      </div>
                                                  @endif -->
                                              </div>
                                        </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="offers" class="py-4">
            <div class="container">
                <div class="row g-3">
                    @foreach (@$active_categories as $key=>$category)
                    <div class="col-6 col-md-2">
                        <article class="feature-card flash-offer h-100">
                            <a href="{{ $category->url }}" class="cursor-pointer text-decoration-none">
                                <img class="offer-card-thumb" src="{{ $category->image_url }}"
                                    alt="{{ $category->fallbackName() }}">
                                <p class="small text-secondary mb-2">{{ $category->summary }}</p>
                                <h2 class="h6 mb-0">
                                    {{ getFivewords($category->fallbackName(), 5) }}
                                </h2>
                            </a>
                        </article>
                    </div>
                    @if($loop->iteration == 6)
                    @break
                    @endif
                    @endforeach
                </div>
            </div>
        </section>
                <section id="products" class="py-5 bg-light-subtle">
            <div class="container">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                    <div>
                        <p class="eyebrow mb-2">{{ __('front/product.home_list_sub_txt') }}</p>
                        <h2 class="h3 mb-0">{{ __('front/product.product_list') }}</h2>
                    </div>
                    <!-- <a href="#" class="link-dark text-decoration-none fw-semibold">View All Products</a> -->
                </div>
                <div class="row g-4">
                    @foreach($new_arrival_products as $product)
                    @php
                    // $discount = 0;
                    // if ($product->masterSku->origin_price > 0) {
                    // $discount = round((($product->masterSku->origin_price - $product->masterSku->getFinalPrice()) /
                    // $product->masterSku->origin_price) * 100);
                    // }
                    @endphp
                    <div class="col-sm-6 col-lg-3">
                        <article class="recent-product-card">
                            <a href="{{ $product->url }}" class="cursor-pointer text-decoration-none" title="{{ $product->fallbackName() }}">
                                <div class="product-image-offer">
                                 @if ($deal->masterSku->origin_price)    
                                <span class="badge-offer">-{{getDiscountPercentage($product->masterSku->origin_price, $product->masterSku->getFinalPrice()) }}%</span>
                                @endif
                                    <img src="{{ $product->image_url }}" alt="{{ $product->fallbackName() }}">
                                </div>

                                <h3 class="h6 mt-3 mb-1">                                   
                                    {{ getFivewords($product->fallbackName(), 5) }}
                                </h3>
                            </a>
                            <p class="rating-badge mb-2">{{ getAvgRating($product->id) }} ★ <span>({{ getTotalReviews($product->id) }})</span></p>
                            <p class="price mb-2">
                              {{ $product->masterSku->getFinalPriceFormat() }}<span>{{ $product->masterSku->origin_price_format }}</span>
                            </p>
                            <!-- <p class="small text-secondary mb-3">Free delivery by tomorrow</p> -->
                            @if(!system_setting('disable_online_order'))
                            <div class="product-bottom-btns">
                                <div class="btn-add-cart cursor-pointer btn btn-sm btn-cart  fw-semibold"
                                    data-id="{{ $product->id }}" data-price="{{ $product->masterSku->getFinalPrice() }}"
                                    data-sku-id="{{ $product->masterSku->id }}">{{ __('front/cart.add_to_cart') }}
                                </div>
                                <div class="add-wishlist btn btn-sm btn-cart" data-in-wishlist="{{ $product->hasFavorite() }}"
                                              data-id="{{ $product->id }}" data-price="{{ $product->masterSku->price }}">
                                    <i class="bi bi-heart{{ $product->hasFavorite() ? '-fill' : '' }}"></i>
                                    {{ __('front/product.add_wishlist') }}
                                </div>
                            </div>
                            @endif
                        </article>
                    </div>
                    @endforeach


                </div>
            </div>
        </section>
        <section id="hot-deals" class="py-4">
            <div class="container">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3">
                    <div>
                        <p class="eyebrow mb-1">{{ __('front/product.limited_time') }}</p>
                        <h2 class="h4 mb-0">{{ __('front/product.hot_deal_text') }}</h2>
                    </div>
                    <!-- <a href="#" class="text-decoration-none fw-semibold small">View all deals</a> -->
                </div>
                <div class="row g-3">

                    @foreach (@$hot_deal_products as $deal)                    
                    <div class="col-md-3">
                        <article class="hot-deal-card flash-offer">
                            <a href="{{ $deal->url }}" class="cursor-pointer text-decoration-none" title="{{ $deal->fallbackName() }}">
                                <div class="product-image-offer">
                                    @if ($deal->masterSku->origin_price)    
                                    <span class="badge-offer">-{{getDiscountPercentage($deal->masterSku->origin_price, $deal->masterSku->getFinalPrice()) }}%</span>
                                    @endif
                                    <img class="deal-thumb mb-2" src="{{ $deal->image_url }}" alt="{{ $deal->fallbackName() }}">
                                </div>
                                
                                <p class="small mb-2 text-secondary">Electronics Bonanza</p>
                                <h3 class="h6 mb-2">
                                    {{ getFivewords($deal->fallbackName(), 5) }}
                                </h3>
                            </a>
                            <?php //echo "<pre>"; print_r($deal); echo "</pre>"; exit; ?>
                            <p class="rating-badge mb-2">{{ getAvgRating($deal->id) }} ★ <span>({{ getTotalReviews($deal->id) }})</span></p>
                            <p class="mb-2"><strong>{{ $deal->masterSku->getFinalPriceFormat() }}</strong>
                                @if ($deal->masterSku->origin_price)
                                <span class="old-price">{{ @$deal->masterSku->origin_price_format }}</span>
                                @endif
                            </p>

                            <!-- <button class="btn btn-sm btn-warning fw-semibold">Add to Cart</button> -->
                            @if(!system_setting('disable_online_order'))
                            <div class="product-bottom-btns">
                                <div class="btn-add-cart cursor-pointer btn btn-sm btn-cart  fw-semibold"
                                    data-id="{{ $deal->id }}" data-price="{{ $deal->masterSku->getFinalPrice() }}"
                                    data-sku-id="{{ $deal->masterSku->id }}">{{ __('front/cart.add_to_cart') }}
                                </div>
                                <div class="add-wishlist btn btn-sm btn-cart" data-in-wishlist="{{ $deal->hasFavorite() }}"
                                    data-id="{{ $deal->id }}" data-price="{{ $deal->masterSku->price }}">
                                    <i class="bi bi-heart{{ $deal->hasFavorite() ? '-fill' : '' }}"></i>
                                    {{ __('front/product.add_wishlist') }}
                                </div>
                            </div>
                            @endif
                        </article>
                    </div>
                    @endforeach

                </div>
            </div>
        </section>

        <section id="recent-search" class="py-3">
            <div class="container">
                <div class="section-box">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h2 class="h5 mb-0">{{ __('front/product.limited_time') }}</h2>
                        <!-- <a href="#" class="small text-decoration-none">View search history</a> -->
                    </div>
                    <div class="row g-3">
                        @foreach ($popularProducts as $product)
                        <div class="col-6 col-md-3">
                            <article class="recent-product-card ">
                                <a href="{{ $product->url }}" class="cursor-pointer text-decoration-none" title="{{ $product->fallbackName() }}">
                                    <div class="product-image-offer">
                                        @if ($deal->masterSku->origin_price)    
                                        <span class="badge-offer">-{{getDiscountPercentage($product->masterSku->origin_price, $product->masterSku->getFinalPrice()) }}%</span>
                                        @endif
                                        <img src="{{ $product->image_url }}" class="" alt="{{ $product->fallbackName() }}">
                                    </div>
                                    <h3 class="h6 mt-2 mb-1">
                                        {{ getFivewords($product->fallbackName(), 5) }}
                                    </h3>
                                </a>
                                <p class="rating-badge mb-2">{{ getAvgRating($product->id) }} ★ <span>({{ getTotalReviews($product->id) }})</span></p>
                                <p class="price mb-2">{{ $product->masterSku->getFinalPriceFormat() }}
                                    @if ($product->masterSku->origin_price)
                                    <span>{{ $product->masterSku->origin_price_format }}</span>
                                    @endif
                                </p>
                                @if(!system_setting('disable_online_order'))
                                <div class="product-bottom-btns">
                                    <div class="btn-add-cart cursor-pointer btn btn-sm btn-cart  fw-semibold"
                                        data-id="{{ $product->id }}"
                                        data-price="{{ $product->masterSku->getFinalPrice() }}"
                                        data-sku-id="{{ $product->masterSku->id }}">{{ __('front/cart.add_to_cart') }}
                                    </div>
                                    <div class="add-wishlist btn btn-sm btn-cart" data-in-wishlist="{{ $product->hasFavorite() }}"
                                        data-id="{{ $product->id }}" data-price="{{ $product->masterSku->price }}">
                                        <i class="bi bi-heart{{ $product->hasFavorite() ? '-fill' : '' }}"></i>
                                        {{ __('front/product.add_wishlist') }}
                                    </div>

                                </div>
                                @endif
                            </article>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>

        <section id="new-items-slider" class="py-4">
            <div class="container">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3">
                    <div>
                        <p class="eyebrow mb-1">{{ __('front/product.trending_text') }}</p>
                        <h2 class="h4 mb-0">{{ __('front/product.trending_title') }}</h2>
                    </div>
                </div>

                <div id="newItemsCarousel" class="carousel slide new-items-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($new_arrival_products->chunk(4) as $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row g-3">
                                @foreach($chunk as $product)
                                <div class="col-md-3">
                                    <article class="new-item-card">
                                        <a href="{{ $product->url }}" class="cursor-pointer text-decoration-none" title="{{ $product->fallbackName() }}">
                                            <div class="product-image-offer">
                                                @if ($deal->masterSku->origin_price)    
                                                <span class="badge-offer">-{{getDiscountPercentage($product->masterSku->origin_price, $product->masterSku->getFinalPrice()) }}%</span>
                                                @endif
                                                <img src="{{ $product->image_url }}"  alt="{{ $product->fallbackName() }}">
                                            </div>

                                            <h3 class="h6 mt-2 mb-1">
                                                {{ getFivewords($product->fallbackName(), 5) }}
                                            </h3>
                                        </a>
                                        <p class="rating-badge mb-2">{{ getAvgRating($product->id) }} ★ <span>({{ getTotalReviews($product->id) }})</span></p>
                                        <p class="price mb-2">
                                            {{ $product->masterSku->getFinalPriceFormat() }}<span>{{ $product->masterSku->origin_price_format }}</span>
                                        </p>
                                        @if(!system_setting('disable_online_order'))
                                        <div class="product-bottom-btns">
                                            <div class="btn-add-cart cursor-pointer btn btn-sm btn-cart  fw-semibold"
                                                data-id="{{ $product->id }}"
                                                data-price="{{ $product->masterSku->getFinalPrice() }}"
                                                data-sku-id="{{ $product->masterSku->id }}">
                                                {{ __('front/cart.add_to_cart') }}
                                            </div>
                                            <div class="add-wishlist btn btn-sm btn-cart" data-in-wishlist="{{ $product->hasFavorite() }}"
                                              data-id="{{ $product->id }}" data-price="{{ $product->masterSku->price }}">
                                              <i class="bi bi-heart{{ $product->hasFavorite() ? '-fill' : '' }}"></i>
                                              {{ __('front/product.add_wishlist') }}
                                          </div>
                                        </div>
                                        @endif
                                    </article>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#newItemsCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#newItemsCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>


        <section id="ads" class="py-4">
            <div class="container">
                <div class="ads-banner">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-8">
                            <p class="eyebrow mb-2 text-white-50">{{ __('front/product.sponsored') }}</p>
                            <h2 class="h4 text-white mb-2 ads-flash-text">{{ __('front/product.ads_text_1') }}</h2>
                            <p class="text-white-50 mb-0">{{ __('front/product.ads_text_2') }}</p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="#" class="btn btn-light fw-semibold">{{ __('front/product.shop_sponsored_deal') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section id="brand-categories" class="py-4">
            <div class="container">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3">
                    <h2 class="h4 mb-0">Brand-Wise Listings</h2>
                    <a href="#" class="small fw-semibold text-decoration-none">Explore all brands</a>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <article class="brand-card h-100">
                            <h3 class="h6">Samsung Store</h3>
                            <ul class="brand-list list-unstyled mb-0">
                                <li><a href="#products">Galaxy M14 5G</a></li>
                                <li><a href="#products">Samsung Buds 2</a></li>
                                <li><a href="#products">Samsung Smart TV 43"</a></li>
                                <li><a href="#products">Samsung Refrigerator</a></li>
                            </ul>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="brand-card h-100">
                            <h3 class="h6">Nike Store</h3>
                            <ul class="brand-list list-unstyled mb-0">
                                <li><a href="#products">Nike Revolution Shoes</a></li>
                                <li><a href="#products">Nike Dri-FIT Tshirt</a></li>
                                <li><a href="#products">Nike Sports Cap</a></li>
                                <li><a href="#products">Nike Backpack</a></li>
                            </ul>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="brand-card h-100">
                            <h3 class="h6">Maybelline Store</h3>
                            <ul class="brand-list list-unstyled mb-0">
                                <li><a href="#products">Fit Me Foundation</a></li>
                                <li><a href="#products">Colossal Kajal</a></li>
                                <li><a href="#products">Superstay Lipstick</a></li>
                                <li><a href="#products">Volume Express Mascara</a></li>
                            </ul>
                        </article>
                    </div>
                </div>
            </div>
        </section> -->



        <section id="related-listings" class="py-4">
            <div class="container">
                <div class="section-box">
                    <h2 class="h5 mb-3">Related Listings</h2>
                    <div class="row g-3">

                         <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="/products">
                                <img src="/cache/static/media/Pro cervical pillow composition(1)-100x100-pad-ffffff.jpg"
                                    alt="Comfort Health Wellness">
                                <span>Comfort Health Wellness</span>
                            </a>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="/products">
                                <img src="/cache/static/media/Travel Neck Pillow Car-100x100-pad-ffffff.jpg"
                                    alt="Comfort Travel">
                                <span>Comfort Travel</span>
                            </a>
                        </div>                       
                       
                        <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="/products">
                                <img src="/cache/static/media/armchair-living-room-with-copy-space-100x100-pad-ffffff.jpg"
                                    alt="Home and Decor">
                                <span>Home and Decor</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="/products">
                                <img src="/cache/static/media/DSC05765-100x100-pad-ffffff.jpg"
                                    alt="Medical Ortho">
                                <span>Medical Ortho</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php /*
        <section id="newsletter" class="py-5">
            <div class="container">
                <div class="newsletter-wrap p-4 p-lg-5">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-7">
                            <h2 class="h3 mb-2">Get price alerts and latest deals</h2>
                            <p class="text-secondary mb-0">Subscribe for new marketplace offers, coupons, and flash sale updates.</p>
                        </div>
                        <div class="col-lg-5">
                            <form id="newsletterForm" class="d-flex gap-2" novalidate>
                                <label for="newsletterEmail" class="visually-hidden">Email address</label>
                                <input id="newsletterEmail" type="email" class="form-control" placeholder="Email address" required>
                                <button type="submit" class="btn btn-dark">Subscribe</button>
                            </form>
                            <p id="newsletterMessage" class="small mt-2 mb-0" aria-live="polite"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section> */ ?>
    </main>

    <section class="module-line">
        <div class="module-product-tab">
            <div class="container">
                <div class="module-title-wrap">
                    <div class="module-title">{{ __('front/home.feature_product') }}</div>
                    <div class="module-sub-title">{{ __('front/home.feature_product_text') }}</div>
                </div>
                <?php /*
          <ul class="nav nav-tabs">
            @foreach ($tab_products as $item)
              <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                  data-bs-target="#module-product-tab-x-{{ $loop->iteration }}"
                  type="button">{{ $item['tab_title'] }}</button>
              </li>
            @endforeach
          </ul>
        */  ?>

                <div class="tab-content">
                    @foreach ($tab_products as $item)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}"
                        id="module-product-tab-x-{{ $loop->iteration }}">
                        <div class="row gx-3 gx-lg-3">
                            @foreach ($item['products'] as $product)
                            <div class="col-6 col-md-3 col-lg-3 mb-3">
                                @include('shared.product')
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</section>

@hookinsert('home.content.bottom')

@endsection

