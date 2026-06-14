@extends('layouts.app')
@section('body-class', 'page-product')

@section('title', \InnoShop\Common\Libraries\MetaInfo::getInstance($product)->getTitle())
@section('description', \InnoShop\Common\Libraries\MetaInfo::getInstance($product)->getDescription())
@section('keywords', \InnoShop\Common\Libraries\MetaInfo::getInstance($product)->getKeywords())

@push('header')
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">

  <script src="{{ asset('vendor/photoswipe/umd/photoswipe.umd.min.js') }}"></script>
  <script src="{{ asset('vendor/photoswipe/umd/photoswipe-lightbox.umd.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('vendor/photoswipe/photoswipe.css') }}">
  
  <script src="{{ asset('vendor/video-js/video.min.js') }}"></script>
  <link href="{{ asset('vendor/video-js/video-js.css') }}" rel="stylesheet">
  
@endpush

@push('style')
<style>
#dealSlides {
    position: relative;
}

.deal-slide {
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;

    opacity: 0;
    visibility: hidden;
    transition: opacity 0.6s ease-in-out;
}

.deal-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 1;
}
</style>
@endpush


@section('content')

  <x-front-breadcrumb type="product" :value="$product"/>

  @hookinsert('product.show.top')

  <div class="container">
    <div class="page-product-top">
      <div class="row">
        <div class="col-12 col-lg-5 product-left-col">
          <div class="product-images">
            @include('products.components._images')
          </div>
        </div>

        <div class="col-12 col-lg-5">
          <div class="product-info"> <!--  border-bottom -->
            <h1 class="product-title">{{ $product->fallbackName() }} - {{ ucfirst($product->propertyProps->city) }}</h1>
            <!-- @hookupdate('front.product.show.price')
            <div class="product-price">
              <span class="price">{{ $sku['price_format'] }}</span>
              @if($sku['origin_price'])
                <span class="old-price ms-2">{{ $sku['origin_price_format'] }}</span>
              @endif
            </div>
            @endhookupdate -->

            <!-- <div class="stock-wrap">
              @if($sku['quantity'] > 0)
                <div class="in-stock badge">{{ __('front/product.in_stock') }}</div>
              @else
                <div class="out-stock badge d-none">{{ __('front/product.out_stock') }}</div>
              @endif                
            </div> -->

            @hookinsert('product.detail.stock.after')
            <div class="sub-product-title mb-4">{{ $product->fallbackName('summary') }}</div>

            <!--  -->
              <div class="row g-3">
                @if(isset($product->propertyProps->super_builtup_area))  
                  <div class="col-4 col-md-4">
                      <div class="border rounded p-3 h-100">
                          <small class="text-muted d-block">Area</small>
                          <strong>{{ getSuperArea($product) }}</strong>
                      </div>
                  </div>
                @endif  
                @if(isset($product->propertyProps->bedrooms))
                  <div class="col-4 col-md-4">
                      <div class="border rounded p-3 h-100">
                          @php
                            $bedrooms = ($product->propertyProps->bedrooms)? $product->propertyProps->bedrooms. ' BHK' : "";                        
                          @endphp
                          <small class="text-muted d-block">Bedrooms</small>
                          <strong>{{ $bedrooms }}</strong>
                      </div>
                  </div> 
                @endif   
               
                @if(isset($product->propertyProps->price))
                <div class="col-4 col-md-4">
                    <div class="border rounded p-3 h-100">
                        <small class="text-muted d-block">Price</small>
                        <strong>{{  $product->propertyProps->getProprtyPriceFormat() }}</strong>
                    </div>
                </div>
                @endif
                @if(isset($product->propertyProps->city))
                <div class="col-4 col-md-4">
                    <div class="border rounded p-3 h-100">
                        <small class="text-muted d-block">City</small>
                        <strong>{{ ucfirst($product->propertyProps->city) }}</strong>
                    </div>
                </div>
                @endif
                @if(isset($product->propertyProps->property_type))
                <div class="col-4 col-md-4">
                    <div class="border rounded p-3 h-100">
                      @if ($product->categories->count())
                          <small class="text-muted d-block">{{ __('front/product.property_type') }}</small>
                          <strong>
                            @foreach ($product->categories as $category)
                              <a href="{{ $category->url }}"
                                    class="text-dark">{{ $category->fallbackName() }}</a>{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                          </strong>
                      @endif
                    </div>
                </div>
                @endif 
                @if(isset($product->propertyProps->property_for))
                  <div class="col-4 col-md-4">
                      <div class="border rounded p-3 h-100">
                          <small class="text-muted d-block">For</small>
                          <strong>{{ getPropertyFor($product) }}</strong>
                      </div>
                  </div>
                @endif 
                @if(isset($product->propertyProps->furnished_status))
                  <div class="col-6 col-md-4">
                      <div class="border rounded p-3 h-100">
                          <small class="text-muted d-block">Furnished Status</small>
                          <strong>{{ getFurnishedStatus($product) }}</strong>
                      </div>
                  </div>
                  @endif
              </div>
              <!--  -->
              <div class="d-flex mt-4">
                  <div class="col-md-3">
                    <button class="contact-btn custom_contact" data-url="{{ $product->url }}" data-product-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#leadContactModal">☎ Contact</button>
                  </div>
                  <div class="col-md-3 mt-3">
                      <div class="add-wishlist mb-3 ps-2" data-in-wishlist="{{ $product->hasFavorite() }}"
                      data-id="{{ $product->id }}"
                      data-price="{{ $product->masterSku->price }}">
                      <i class="bi bi-heart{{ $product->hasFavorite() ? '-fill' : '' }}"></i> {{ __('front/product.add_wishlist') }}
                      </div>
                  </div>
                  
              </div>
            
            @include('products.components._bundle_items')
              <div class="details-card mt-3">
                  
                  <div class="detail-row">
                    <h4 class="product-props">{{ __('front/product.product_properties') }}</h4>
                  </div>
                  @if(isset($product->propertyProps->plot_area) )
                    <div class="detail-row">
                      <div class="detail-label">Plot Area</div>
                      <div class="detail-value">{{ $product->propertyProps->plot_area.' '.getAreaType($product) }}</div>
                    </div>
                  @endif
                  
                  @if(isset($product->propertyProps->plot_length) )
                    <div class="detail-row">
                      <div class="detail-label">Plot Length</div>
                      <div class="detail-value">{{ $product->propertyProps->plot_length }} Ft</div>
                    </div>
                  @endif
                  @if(isset($product->propertyProps->plot_breadth) )
                    <div class="detail-row">
                      <div class="detail-label">Plot Breadth</div>
                      <div class="detail-value">{{ ucfirst($product->propertyProps->plot_breadth) }} Ft</div>
                    </div>
                  @endif

                  @if(isset($product->propertyProps->covered_area) )
                    <div class="detail-row">
                      <div class="detail-label">Covered Area</div>
                      <div class="detail-value">{{ $product->propertyProps->covered_area.' '. getCoverArea($product)  }}</div>
                    </div>
                  @endif

                  @if(isset($product->propertyProps->carpet_area) )
                    <div class="detail-row">
                      <div class="detail-label">Carpet Area</div>
                      <div class="detail-value">{{ $product->propertyProps->carpet_area.' '. getCoverArea($product)  }}</div>
                    </div>
                  @endif                  
                 
                  @if(isset($product->propertyProps->bathrooms))
                  <div class="detail-row">
                      <div class="detail-label">Bathrooms</div>
                      <div class="detail-value">{{ $product->propertyProps->bathrooms }}</div>
                  </div>
                  @endif
                  @if(isset($product->propertyProps->balcony))
                  <div class="detail-row">
                      <div class="detail-label">Balconies</div>
                      <div class="detail-value">{{ $product->propertyProps->balcony }}</div>
                  </div>
                  @endif
                  @if(isset($product->propertyProps->total_floors))
                  <div class="detail-row">
                      <div class="detail-label">Total Floors</div>
                      <div class="detail-value">{{$product->propertyProps->total_floors}}</div>
                  </div>
                  @endif
                  @if(isset($product->propertyProps->floor_no))
                  <div class="detail-row">
                      <div class="detail-label">Floor No.</div>
                      <div class="detail-value">{{getTotalFloors($product, $product->propertyProps->floor_no)}}</div>
                  </div>
                  @endif
                  @if(isset($product->propertyProps->facing))
                  <div class="detail-row">
                      <div class="detail-label">Facing</div>
                      <div class="detail-value">{{ucfirst($product->propertyProps->facing)}}</div>
                  </div>
                  @endif
                  
                  @if(isset($product->propertyProps->location) || isset($product->propertyProps->address))
                  <div class="detail-row">
                      <div class="detail-label">Location/Address</div>
                      <div class="detail-value">{{ ucfirst($product->propertyProps->location) . "(".ucfirst($product->propertyProps->address).")" }}  </div>
                  </div>
                  @endif                 
                  
                  
                  @if(isset($product->propertyProps->open_side) )
                    <div class="detail-row">
                      <div class="detail-label">Open Side</div>
                      <div class="detail-value">{{ ucfirst($product->propertyProps->open_side) }}</div>
                    </div>
                  @endif


                  @if(isset($product->propertyProps->property_age) )
                    <div class="detail-row">
                      <div class="detail-label">Property Age (How old property)</div>
                      <div class="detail-value">{{ $product->propertyProps->property_age  }}</div>
                    </div>
                  @endif

                  @if(isset($product->propertyProps->maintenance_cost) )
                    <div class="detail-row">
                      <div class="detail-label">Maintenance Cost</div>
                      <div class="detail-value">{{ $product->propertyProps->maintenance_cost  }}</div>
                    </div>
                  @endif

                  @if(isset($product->propertyProps->ownership_status) )
                    <div class="detail-row">
                      <div class="detail-label">Ownership status</div>
                      <div class="detail-value">{{ $product->propertyProps->ownership_status  }}</div>
                    </div>
                  @endif
                  @if(isset($product->propertyProps->rera_registration_no) )
                    <div class="detail-row">
                      <div class="detail-label">Rera Registration no</div>
                      <div class="detail-value">{{ $product->propertyProps->rera_registration_no  }}</div>
                    </div>
                  @endif

                  @if(isset($product->propertyProps->transaction_type) )
                    <div class="detail-row">
                      <div class="detail-label">Transaction Type</div>
                      <div class="detail-value">{{ getTransactionType($product) }}</div>
                    </div>
                  @endif
                  
                  @if(isset($product->propertyProps->is_corner) )
                    <div class="detail-row">
                      <div class="detail-label">Is corner?</div>
                      <div class="detail-value">{{ $product->propertyProps->is_corner? "Yes" : "No"  }}</div>
                    </div>
                  @endif

              </div>

            <ul class="product-param">
              <!-- <li class="sku"><span class="title">{{ __('front/product.sku_code') }}:</span> <span
                  class="value">{{ $sku['code'] }}</span></li>
              <li class="model {{ !($sku['model'] ?? false) ? 'd-none' : '' }}"><span class="title">{{ __('front/product.model') }}:</span>
                <span class="value">{{ $sku['model'] }}</span></li> -->
              
              <!-- @if($product->brand)
                <li class="brand">
                  <span class="title">{{ __('front/product.brand') }}:</span> <span class="value">
                    <a href="{{ $product->brand->url }}"> {{ $product->brand->name }} </a>
                  </span>
                </li>
              @endif
              @hookinsert('product.detail.brand.after') -->
              <!-- <li class="brand">
                <div class="detail-star-rating">
                  <span class="title">{{ __('front/product.rating') }}:</span> 
                    <p class="rating-badge mb-2">{{ getAvgRating($product->id) }} ★ <span>({{ getTotalReviews($product->id) }})</span></p>
                </div>
              </li> -->

            </ul>

            <!-- @include('products.components._variants')            
            @include('products.components._options')           -->
            
            <!-- @if(!system_setting('disable_online_order'))
            
              <div class="product-info-bottom">
                <div class="quantity-wrap">
                  <div class="minus"><i class="bi bi-dash-lg"></i></div>
                  <input type="number" class="form-control product-quantity" value="1"
                         data-sku-id="{{ $sku['id'] }}">
                  <div class="plus"><i class="bi bi-plus-lg"></i></div>
                </div>
                <div class="product-info-btns">
                  <button class="btn btn-primary add-cart" data-id="{{ $product->id }}"
                          data-price="{{ $product->masterSku->price }}">
                    {{ __('front/product.add_to_cart') }}
                  </button>
                  <button class="btn buy-now ms-2" data-id="{{ $product->id }}"
                          data-price="{{ $product->masterSku->price }}">
                    {{ __('front/product.buy_now') }}
                  </button>
                  @hookinsert('product.detail.cart.after')
                </div>
              </div>
            @endif -->



            @if($attributes)
            <div class="head-title pt-3">
              <h5 class="product-title-1 ">{{ __('front/product.product_properties') }}</h5>
            </div>
              <div class="" id="product-description-attribute1">
                <table class="table table-bordered attribute-table">
                  @foreach ($attributes as $group)
                    <thead class="table-light">
                    <tr>
                      <td colspan="2"><strong>{{ $group['attribute_group_name'] }}</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($group['attributes'] as $item)
                      <tr>
                        <td>{{ $item['attribute'] }}</td>
                        <td>{{ $item['attribute_value'] }}</td>
                      </tr>
                    @endforeach
                    </tbody>
                  @endforeach
                </table>
              </div>
            @endif  

            @hookinsert('product.detail.after')
          </div>
        </div>
        <div class="col-12 col-lg-2">
          <h4>{{ __('front/product.share_this_product') }}</h4>
          <div class="share-buttons icon-container d-flex gap-3 pt-4 pb-3 fsize25">
            <div class="share-button share-facebook-wrap">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($product->url) }}" target="_blank" class="share-button share-facebook">
                  <i class="bi bi-facebook"></i>
                </a>
            </div>
            <div class="share-button share-twitter-wrap">
              <a href="https://twitter.com/intent/tweet?url={{ urlencode($product->url) }}&text={{ urlencode($product->fallbackName()) }}" target="_blank" class="share-button share-twitter">
                <i class="bi bi-twitter"></i>
              </a>
            </div>
            <div class="share-button share-linkedin-wrap">
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($product->url) }}&title={{ urlencode($product->fallbackName()) }}" target="_blank" class="share-button share-linkedin">
              <i class="bi bi-linkedin"></i>
            </a>
            </div>
            <div class="share-button share-pinterest-wrap">
            <a href="https://pinterest.com/pin/create/button/?url={{ urlencode($product->url) }}&media={{ urlencode($product->image_url) }}&description={{ urlencode($product->fallbackName()) }}" target="_blank" class="share-button share-pinterest">
              <i class="bi bi-pinterest"></i>
            </a>
            </div>
              <div class="share-button share-email-wrap">
            <a href="whatsapp://send?text={{ urlencode($product->fallbackName() . ' - ' . $product->url) }}" target="_blank" class="share-button share-whatsapp">
              <i class="bi bi-whatsapp"></i>
            </a>
            </div>
        </div>
        <hr>
        <!-- <h4>Today's Deals</h4> -->
            <div class="quick-deals p-2">
              <h2 class="h6 mb-3 fw-bold p-1">{{ __('front/product.todays_deals') }}</h2>

              <div class="position-relative" style="height: 360px; overflow: hidden;">

                  <div id="dealSlides">

                      @foreach ($today_deal_products->chunk(3) as $key => $chunk)
                      <div class="deal-slide {{ $key == 0 ? 'active' : '' }}">

                          @foreach ($chunk as $deal)
                          <div class="deal-line d-flex gap-2 align-items-center mb-2">

                              <img src="{{ $deal->image_url }}"
                                  style="width:60px;height:60px;object-fit:cover;">

                              <div>
                                  <a href="{{ $deal->url }}" class="text-dark small text-decoration-none">
                                     {{ getSuperArea($product) }} | {{ getFivewords($deal->fallbackName(), 3) }} | For {{ getPropertyFor($product) }}
                                  </a>

                                  <div class="fw-bold text-primary small">
                                      {{ $deal->propertyProps->getProprtyPriceFormat() }}
                                  </div>
                                  <div class=" small">
                                    {{ ucfirst($product->propertyProps->city) }}
                                  </div>
                                  
                              </div>

                          </div>
                          @endforeach

                      </div>
                      @endforeach

                  </div>

              </div>
          </div>

      </div>
    </div>

    <div class="product-description">
      <ul class="nav nav-tabs tabs-plus">
        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="tab"
                  data-bs-target="#product-description-description"
                  type="button">{{ __('front/product.description') }}</button>
        </li>
        <?php /*
         <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#product-review"
                  type="button">{{ __('front/product.review') }}</button>
        </li>
        */ ?>
  
        @hookinsert('product.detail.tab.link.after')
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="product-description-description">
          @if($product->fallbackName('selling_point'))
            {!! parsedown($product->fallbackName('selling_point')) !!}
          @endif
          {!! $product->fallbackName('content') !!}
          @hookinsert('product.detail.description.after')
        </div>

        
      <?php 
        /*
          <div class="tab-pane fade" id="product-review" role="tabpanel">
            @include('products.components._review_section')
          </div>
        */ 
      ?>

        @hookinsert('product.detail.tab.pane.after')
      </div>
    </div>
    <div class="row border-top pt-3">
        <h5 class="pb-3">{{__('front/product.related_products')}}</h5>
       <div class="" id="product-description-correlation1">
          <div class="row gx-3 gx-lg-4">
            @foreach ($related as $relatedItem)
              <div class="col-6 col-md-4 col-lg-2 mb-3">
                @include('shared.product', ['product'=>$relatedItem])
              </div>
            @endforeach
          </div>
        </div>

    </div>

    @hookinsert('product.show.bottom')

  </div>

@endsection

@push('footer')

<script>
  // fade in fade out
  //   document.addEventListener("DOMContentLoaded", function () {
  //     const slides = document.querySelectorAll('.deal-slide');
  //     let current = 0;

  //     function showNextSlide() {
  //         // fade out current
  //         slides[current].classList.remove('active');

  //         // move to next
  //         current = (current + 1) % slides.length;

  //         // fade in next
  //         slides[current].classList.add('active');
  //     }

  //     setInterval(showNextSlide, 3000); // 3 sec
  // });
</script>

  <script>
    $('.quantity-wrap .plus, .quantity-wrap .minus').on('click', function () {
      if ($(this).parent().hasClass('disabled')) {
        return;
      }

      let quantity = parseInt($(this).siblings('input').val());
      if ($(this).hasClass('plus')) {
        $(this).siblings('input').val(quantity + 1);
      } else {
        if (quantity > 1) {
          $(this).siblings('input').val(quantity - 1);
        }
      }
    });

    $('.add-cart, .buy-now').on('click', function () {
      
      if (typeof validateRequiredOptions === 'function' && !validateRequiredOptions()) {
       
        const $firstError = $('.option-group.has-error').first();
        if ($firstError.length) {
          $('html, body').animate({
            scrollTop: $firstError.offset().top - 100
          }, 500);
        }
        
        if (window.inno && window.inno.alert) {
          window.inno.alert({msg: '{{ __("front/product.please_select_required_options") }}', type: 'warning'});
        } else {
          alert('{{ __("front/product.please_select_required_options") }}');
        }
        return;
      }

      const quantity = $('.product-quantity').val();
      const skuId = $('.product-quantity').data('sku-id');
      const isBuyNow = $(this).hasClass('buy-now');


      const productOptions = {};
      
    
      $('.option-select').each(function() {
        const optionId = $(this).data('option-id');
        const selectedValue = $(this).val();
        if (selectedValue) {
          productOptions[optionId] = [selectedValue];
        }
      });
      
     
      $('.option-radio-item input[type="radio"]:checked').each(function() {
        const optionId = $(this).data('option-id');
        const optionValue = $(this).val();
        productOptions[optionId] = [optionValue];
      });
      
   
      $('.option-checkbox-item input[type="checkbox"]:checked').each(function() {
        const optionId = $(this).data('option-id');
        const optionValue = $(this).val();
        if (!productOptions[optionId]) {
          productOptions[optionId] = [];
        }
        productOptions[optionId].push(optionValue);
      });

   
      const requestData = {
        skuId, 
        quantity, 
        isBuyNow,
        options: productOptions
      };
      
      inno.addCart(requestData, this, function (res) {
        if (isBuyNow) {
          window.location.href = '{{ front_route('carts.index') }}';
        }
      })
    });
  </script>
@endpush
