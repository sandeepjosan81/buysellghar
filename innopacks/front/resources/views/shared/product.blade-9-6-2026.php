<div class="template-2">
    <article class="recent-product-card">
        @if($product->fallbackName())
        <div class="product-grid-item1  {{ request('style_list') ?? '' }}">

            <div class="image position-relative">
                @hookinsert('product.list_item.image.before')
                <a href="{{ $product->url }}">
                    <!-- @if ($product->masterSku->origin_price)    
                    <span class="badge-offer">-{{getDiscountPercentage($product->masterSku->origin_price, $product->masterSku->getFinalPrice()) }}% off</span>
                    @endif -->
                    <!-- <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->fallbackName() }}"> -->
                    
                    <img src="{{ $product->image_url }}" class="img-fluid product-main-image">
                    <!-- @if($product->hasHoverImage())
                        <img src="{{ $product->getHoverImageUrl() }}" class="img-fluid product-hover-image">
                    @endif -->
                   
                </a>
            </div>
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
                    <p class="price mb-2">
                        {{  $product->propertyProps->getProprtyPriceFormat() }} 
                        | For {{ ucfirst($product->propertyProps->property_for) }}                       
                    </p>                
                    <p class="price mb-2">
                        {{ $product->propertyProps->getPossession() }} | {{ ucfirst($product->propertyProps->city) }}                      
                    </p>
                    <!-- <p class="price mb-2">{{ $product->propertyProps->getProprtyPriceFormat() }}</p> -->
                <div class=" product-bottom-btns d-flex gap-1">
                    <div >
                        <!-- <a href="{{ $product->url }}" class="cursor-pointer btn btn-sm btn-cart fw-semibold" >{{ __('front/common.view_details') }}</a> -->
                         <button class="contact-btn">☎ Contact</button>
                    </div>
                    <div class="add-wishlist contact-btn btn-cart" data-in-wishlist="{{ $product->hasFavorite() }}"
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