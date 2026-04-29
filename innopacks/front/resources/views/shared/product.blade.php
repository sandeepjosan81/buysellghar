<div class="template-2">
    <article class="recent-product-card">
        @if($product->fallbackName())
        <div class="product-grid-item1  {{ request('style_list') ?? '' }}">

            <div class="image position-relative">
                @hookinsert('product.list_item.image.before')
                <a href="{{ $product->url }}">
                    @if ($product->masterSku->origin_price)    
                    <span class="product-image-offer">-{{getDiscountPercentage($product->masterSku->origin_price, $product->masterSku->getFinalPrice()) }}%</span>
                    @endif
                    <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->fallbackName() }}">
                    <?php /*
            <img src="{{ $product->image_url }}" class="img-fluid product-main-image">
            @if($product->hasHoverImage())
              <img src="{{ $product->getHoverImageUrl() }}" class="img-fluid product-hover-image">
            @endif
            */ ?>
                </a>
                <?php /*
          <div class="wishlist-container add-wishlist" data-in-wishlist="{{ $product->hasFavorite() }}"
              data-id="{{ $product->id }}" data-price="{{ $product->masterSku->price }}">
            <i class="bi bi-heart{{ $product->hasFavorite() ? '-fill' : '' }}"></i> {{ __('front/product.add_wishlist') }}
          </div>
          */ ?>
            </div>
            <!-- <div class="product-item-info"> -->
                <div class="product-name  mb-2 mt-3">
                    <a href="{{ $product->url }}" data-bs-toggle="tooltip" title="{{ $product->fallbackName() }}"
                        data-placement="top">
                         {{ getFivewords($product->fallbackName(), 5) }}
                    </a>
                </div>

                @hookinsert('product.list_item.name.after')

                @if(request('style_list') == 'list')
                <div class="sub-product-title">{{ $product->fallbackName('summary') }}</div>
                @endif
                  <!-- <div class="product-price">
                        <div class="price-new">{{ $product->masterSku->getFinalPriceFormat() }}</div>
                        @if ($product->masterSku->origin_price)
                        <div class="price-old">{{ $product->masterSku->origin_price_format }}</div>
                        @endif
                    </div> -->
                    <p class="rating-badge mb-2">{{ getAvgRating($product->id) }} ★ <span>({{ getTotalReviews($product->id) }})</span></p>
                    <p class="price mb-2">
                              {{ $product->masterSku->getFinalPriceFormat() }}
                              @if ($product->masterSku->origin_price)
                              <span>{{ $product->masterSku->origin_price_format }}</span>
                              @endif
                    </p>
                <div class=" product-bottom-btns d-flex gap-1">                   
                    @if(!system_setting('disable_online_order'))
                        <div class="btn-add-cart cursor-pointer btn btn-sm btn-cart fw-semibold"
                            data-id="{{ $product->id }}" data-price="{{ $product->masterSku->getFinalPrice() }}"
                            data-sku-id="{{ $product->masterSku->id }}">{{ __('front/cart.add_to_cart') }}
                        </div>
                    @endif                   
                    <?php /* @if(request('style_list') == 'list') */ ?>
                    <div class="add-wishlist btn btn-sm btn-cart" data-in-wishlist="{{ $product->hasFavorite() }}"
                        data-id="{{ $product->id }}" data-price="{{ $product->masterSku->price }}">
                        <i class="bi bi-heart{{ $product->hasFavorite() ? '-fill' : '' }}"></i>
                        {{ __('front/product.add_wishlist') }}
                    </div>
                    <?php /* @endif */ ?>
                </div>

            <!-- </div> -->
        </div>
        @endif
    </article>
</div>