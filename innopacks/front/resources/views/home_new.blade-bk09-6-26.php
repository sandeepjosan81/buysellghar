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
        <?php /*
        <section id="home" class="hero-section py-4">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-8">
                        <div class="hero-banner shadow-sm">
                            <p class="eyebrow mb-2 text-white-50">{{ __('front/product.big_saving_fest') }}</p>
                            <h1 class="display-6 fw-bold mb-2 text-white ads-flash-text">{{ __('front/product.up_to_saving_text') }}</h1>
                            <p class="text-white-50 mb-4">{{ __('front/product.home_ads_sub_title') }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ front_route("products.index") }}" class="btn btn-warning fw-semibold">{{ __('front/product.shop_deals') }}</a>
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
                                    <a href="{{ $product->url }}" class="d-flex align-items-center gap-2 text-decoration-none" title="{{ $product->fallbackName() }}">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->fallbackName() }}" class="deal-thumb" />
                                        @if($product->hasHoverImage())
                                            <img src="{{ $product->getHoverImageUrl() }}" class="img-fluid product-hover-image">
                                        @endif
                                          </a>
                                        <div class="d-flex">
                                            <a href="{{ $product->url }}" class="d-flex align-items-center gap-2 text-decoration-none" title="{{ $product->fallbackName() }}">
                                            <span class="text-decoration-none " title="{{ $product->fallbackName() }}">
                                              {{ getFivewords($product->fallbackName(), 5) }}
                                                
                                            </span>
                                            </a>
                                              <div class="d-flex">
                                                  <div class="product-price d-flex gap-1 mb-0 ps-2">
                                                      <div class="price-new">
                                                          <strong>{{ $product->masterSku->getFinalPriceFormat() }}</strong>
                                                      </div>
                                                      @if ($product->masterSku->origin_price)
                                                      <div class="price-old">{{ $product->masterSku->origin_price_format }}</div>
                                                      @endif
                                                  </div>
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
        */?>
       
        <section id="products" class="py-3 bg-light-subtle">
            <div class="container">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                    <div>
                        <p class="eyebrow mb-2">{{ __('front/product.home_list_sub_txt') }}</p>
                        <h2 class="h3 mb-0">{{ __('front/product.product_list') }}</h2>
                    </div>
                    <!-- <a href="#" class="link-dark text-decoration-none fw-semibold">View All Products</a> -->
                </div>
                <div class="row g-4">
                    @foreach($propertyForSale as $product)
                    <div class="col-sm-6 col-lg-3">
                        <article class="recent-product-card">
                            <a href="{{ $product->url }}" class="cursor-pointer text-decoration-none" title="{{ $product->fallbackName() }}">
                                <div class="product-image-offer">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->fallbackName() }}">
                                    <!-- @if($product->hasHoverImage())
                                        <img src="{{ $product->getHoverImageUrl() }}" class="img-fluid product-hover-image">
                                    @endif -->
                                </div>
                                <h3 class="h6 mt-3 mb-1">                                   
                                    {{ getFivewords($product->fallbackName(), 5) }}
                                </h3>
                            </a>
                            <div class="row">
                                    @if(!empty(trim($product->propertyProps->super_builtup_area)) || !empty(trim($product->propertyProps->plot_area)))
                                    <div class="col-4 col-md-4">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">Area</small>
                                            <strong>{{ getSuperArea($product)}}</strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->price))
                                    <div class="col-4 col-md-4">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">Price</small>
                                            <strong>{{  $product->propertyProps->getProprtyPriceFormat() }} </strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->property_for))
                                    <div class="col-4 col-md-4">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">For</small>
                                            <strong>{{  ucfirst($product->propertyProps->property_for) }} </strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->property_for))
                                    <div class="col-7 col-md-7">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">Possession</small>
                                            <strong>{{  ucfirst($product->propertyProps->getPossession()) }} </strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->city))
                                    <div class="col-5 col-md-5">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">City</small>
                                            <strong>{{  ucfirst(ucfirst($product->propertyProps->city)) }} </strong>
                                        </div>
                                    </div>
                                    @endif                                    

                            </div>     
                            <div class="col-md-6 product-bottom-btns  d-flex gap-1 mt-3">
                                @include('shared._addtocart', ['product'=>$product])
                            </div>                       
                        </article>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <?php /*
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
        */ ?>

        <section id="hot-deals" class="py-4">
            <div class="container">
                <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3">
                    <div>
                        <p class="eyebrow mb-1">{{ __('front/product.limited_time') }}</p>
                        <h2 class="h4 mb-0">{{ __('front/product.property_for_rent') }}</h2>
                    </div>
                    <!-- <a href="#" class="text-decoration-none fw-semibold small">View all deals</a> -->
                </div>
                <div class="row g-3">
                        @foreach ($propertyForRent as $product)
                        <div class="col-12 col-md-3">
                            <article class="recent-product-card ">
                                <a href="{{ $product->url }}" class="cursor-pointer text-decoration-none" title="{{ $product->fallbackName() }}">
                                    <div class="product-image-offer">
                                        @if ($product->masterSku->origin_price)    
                                        <span class="badge-offer">-{{getDiscountPercentage($product->masterSku->origin_price, $product->masterSku->getFinalPrice()) }}%</span>
                                        @endif
                                        <img src="{{ $product->image_url }}" class="" alt="{{ $product->fallbackName() }}">
                                        <!-- @if($product->hasHoverImage())
                                            <img src="{{ $product->getHoverImageUrl() }}" class="img-fluid product-hover-image">
                                        @endif -->
                                        
                                    </div>
                                    <h3 class="h6 mt-2 mb-1">
                                        {{ getFivewords($product->fallbackName(), 5) }}
                                    </h3>
                                </a>
                                <div class="row">
                                    @if(!empty(trim($product->propertyProps->super_builtup_area)) || !empty(trim($product->propertyProps->plot_area)))
                                    <div class="col-4 col-md-4">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">Area</small>
                                            <strong>{{ getSuperArea($product)}}</strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->price))
                                    <div class="col-4 col-md-4">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">Price</small>
                                            <strong>{{  $product->propertyProps->getProprtyPriceFormat() }} </strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->property_for))
                                    <div class="col-4 col-md-4">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">For</small>
                                            <strong>{{  ucfirst($product->propertyProps->property_for) }} </strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->possession_status))
                                    <div class="col-7 col-md-7">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">Possession</small>
                                            <strong>{{  $product->propertyProps->getPossession() }} </strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($product->propertyProps->city))
                                    <div class="col-5 col-md-5">
                                        <div class="p-1 h-100">
                                            <small class="text-muted d-block">City</small>
                                            <strong>{{  ucfirst(ucfirst($product->propertyProps->city)) }} </strong>
                                        </div>
                                    </div>
                                    @endif                                    

                            </div> 
                                <!-- <p class="rating-badge mb-2">{{ getAvgRating($product->id) }} ★ <span>({{ getTotalReviews($product->id) }})</span></p> -->
                               
                               
                                <div class="col-md-6 product-bottom-btns  d-flex gap-1 mt-3">
                                @include('shared._addtocart', ['product'=>$product])
                            </div>
                            </article>
                        </div>
                        @endforeach

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
                <!-- Slider Items -->
                    <div id="newItemsCarousel" class="carousel slide new-items-carousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- <div class="nav-btn">‹</div> -->
                             @foreach($propertyForSale->chunk(($isTablet || $isMobile) ? 1 : 4 ) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row g-3">                                        
                                            <div class="content-grid">
                                                <div class="cards-row">
                                                    @foreach($chunk as $product)
                                                        @php
                                                            $bedrooms = ($product->propertyProps->bedrooms)? $product->propertyProps->bedrooms. ' BHK' : "";
                                                        
                                                        @endphp
                                                        <div class=" plan-card">
                                                            <div class="plan-image product-image-offer">
                                                                <img src="{{ $product->image_url }}" class="img-h200" alt="{{ $product->fallbackName() }}">
                                                                <!-- @if($product->hasHoverImage())
                                                                    <img src="{{ $product->getHoverImageUrl() }}" class="img-fluid product-hover-image">
                                                                @endif -->
                                                                <!-- <span class="image-badge">View Floor Plan</span> -->
                                                            </div>
                                                            <div class="plan-info">
                                                                <div class="plan-top">
                                                                    <div>
                                                                        <div class="small-label">Super Area</div>
                                                                        <div class="plan-size">{{ getSuperArea($product) ." | ". $bedrooms }}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="plan-price">{{  $product->propertyProps->getProprtyPriceFormat() }}  <span>Onwards</span> | <em>For {{ ucfirst($product->propertyProps->property_for) }}</em></div>
                                                                <div class="plan-possession">{{ $product->propertyProps->getPossession() }} | {{ ucfirst($product->propertyProps->city) }} </div>

                                                                <div class="plan-footer">
                                                                <a href="{{ $product->url }}" class="text-decoration-none contact-btn" title="{{ $product->fallbackName() }}" >{{ __('front/common.view_details') }}</a>
                                                                <button class="contact-btn">☎ Contact</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                       
                                    </div>
                                </div>
                            @endforeach
                        </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#newItemsCarousel"
                                data-bs-slide="prev">
                                <span class="nav-btn" aria-hidden="true">‹</span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#newItemsCarousel"
                                data-bs-slide="next">
                                <span class="nav-btn" aria-hidden="true">›</span>
                                <span class="visually-hidden">Next</span>
                            </button>
                    </div>
                <?php
                    /* 
                        <div id="newItemsCarousel" class="carousel slide new-items-carousel" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($propertyForSale->chunk(4) as $chunk)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="row g-3">
                                        @foreach($chunk as $product)
                                        <div class="col-md-3">
                                            <article class="new-item-card">
                                                <a href="{{ $product->url }}" class="cursor-pointer text-decoration-none" title="{{ $product->fallbackName() }}">
                                                    <div class="product-image-offer">
                                                        @if ($product->masterSku->origin_price)    
                                                        <span class="badge-offer">-{{getDiscountPercentage($product->masterSku->origin_price, $product->masterSku->getFinalPrice()) }}% off</span>
                                                        @endif
                                                        <img src="{{ $product->image_url }}"  alt="{{ $product->fallbackName() }}">
                                                    </div>

                                                    <h3 class="h6 mt-2 mb-1">
                                                        {{ getFivewords($product->fallbackName(), 5) }}
                                                    </h3>
                                                </a>
                                                <!-- <p class="rating-badge mb-2">{{ getAvgRating($product->id) }} ★ <span>({{ getTotalReviews($product->id) }})</span></p> -->
                                                <p class="price mb-2">
                                                    {{  $product->propertyProps->getProprtyPriceFormat() }} 
                                                    | For {{ ucfirst($product->propertyProps->property_for) }}                       
                                                </p>                
                                                <p class="price mb-2">
                                                    {{ $product->propertyProps->getPossession() }} | {{ ucfirst($product->propertyProps->city) }}                        
                                                </p>
                                                <div class="product-bottom-btns  d-flex gap-1">
                                                    @include('shared._addtocart', ['product'=>$product])
                                                </div>
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
                    */ 
                ?>
            </div>
        </section>

        <!-- Uncommneted -->
 
        <!-- <section id="ads" class="py-4">
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

        <section id="brand-categories" class="py-4">
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
        </section>  -->


<?php /*
        <section id="related-listings" class="py-4">
            <div class="container">
                <div class="section-box">
                    <h2 class="h5 mb-3">Related Listings</h2>
                    <div class="row g-3">

                         <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="{{ front_route("products.index") }}">
                                <img src="/cache/static/media/Pro cervical pillow composition(1)-100x100-pad-ffffff.jpg"
                                    alt="Comfort Health Wellness">
                                <span>Comfort Health Wellness</span>
                            </a>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="{{ front_route("products.index") }}">
                                <img src="/cache/static/media/Travel Neck Pillow Car-100x100-pad-ffffff.jpg"
                                    alt="Comfort Travel">
                                <span>Comfort Travel</span>
                            </a>
                        </div>                       
                       
                        <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="{{ front_route("products.index") }}">
                                <img src="/cache/static/media/armchair-living-room-with-copy-space-100x100-pad-ffffff.jpg"
                                    alt="Home and Decor">
                                <span>Home and Decor</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <a class="related-item" href="{{ front_route("products.index") }}">
                                <img src="/cache/static/media/DSC05765-100x100-pad-ffffff.jpg"
                                    alt="Medical Ortho">
                                <span>Medical Ortho</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                <?php

                    /*
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
                            <div class="col-12 col-md-3 col-lg-3 mb-3">
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

