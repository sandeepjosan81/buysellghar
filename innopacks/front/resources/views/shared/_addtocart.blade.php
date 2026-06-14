    @if(!system_setting('disable_online_order'))
        <?php/* 
        <div class="btn-add-cart cursor-pointer btn btn-sm btn-cart  fw-semibold"
            data-id="{{ $product->id }}" data-price="{{ $product->masterSku->getFinalPrice() }}"
            data-sku-id="{{ $product->masterSku->id }}">{{ __('front/cart.add_to_cart') }}
        </div>
        */ ?>
    @endif
    <?php /* <div class=" product-bottom-btns d-flex gap-2 mt-3">
        <div class="contact-now">
            <a href="{{ $product->url }}" class="text-decoration-none contact-btn" title="{{ $product->fallbackName() }}" >{{ __('front/common.view_details') }}</a>            
        </div>
    </div> */ ?>
    <div class=" product-bottom-btns gap-2">
        <div class="contact-now">
            <button class="contact-btn custom_contact" data-url="{{ $product->url }}" data-product-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#leadContactModal">☎ Contact</button>
        </div>
    </div>
     <?php /* <div class="add-wishlist btn btn-sm btn-cart" data-in-wishlist="{{ $product->hasFavorite() }}"
        data-id="{{ $product->id }}" data-price="{{ $product->masterSku->price }}">
        <i class="bi bi-heart{{ $product->hasFavorite() ? '-fill' : '' }}"></i>
        {{ __('front/product.add_wishlist') }}
    </div> */ ?>