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
                            <div class="col-md-6 product-bottom-btns gap-1 mt-3">
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
                                        
                                        <img src="{{ $product->image_url }}" class="" alt="{{ $product->fallbackName() }}">
                                        <!-- <span class="posted"> Posted on: {{ $product->created_on }} </span> -->
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
                               
                               
                                <div class="col-md-6 product-bottom-btns gap-1 mt-3 ">
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
                
            </div>
        </section>

        <!-- Uncommneted -->
 
        
    </main>

    <section class="module-line">
        <div class="module-product-tab">
            <div class="container">
                <div class="module-title-wrap">
                    <div class="module-title">{{ __('front/home.feature_product') }}</div>
                    <div class="module-sub-title">{{ __('front/home.feature_product_text') }}</div>
                </div>
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

