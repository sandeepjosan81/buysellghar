<div class="template-2">
    <article class="recent-product-card">
        @if($product->fallbackName())
        <div class="product-grid-item1  {{ request('style_list') ?? '' }}">
                <div class="image position-relative">
                    @hookinsert('product.list_item.image.before')
                    <a href="{{ $product->url }}">
                        
                        <img src="{{ $product->image_url }}" class="img-fluid product-main-image" alt="{{ $product->fallbackName() }}">
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
                <div class=" product-bottom-btns d-flex gap-2 mt-3">
                    <div class="contact-now">
                        <!-- <a href="{{ $product->url }}" class="cursor-pointer btn btn-sm btn-cart fw-semibold" >{{ __('front/common.view_details') }}</a> -->
                        <button class="contact-btn custom_contact" data-url="{{ $product->url }}" data-product-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#leadContactModal">☎ Contact</button>
                    </div>
                    <div class="add-wishlist contact-btn btn-cart " data-in-wishlist="{{ $product->hasFavorite() }}"
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