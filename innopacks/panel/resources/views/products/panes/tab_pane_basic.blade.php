<div class="tab-pane fade show active mt-3" id="basic-tab-pane" role="tabpanel" aria-labelledby="basic-tab"
     tabindex="0">
     <input type="hidden" name="type" value="{{ old('type', $product->type ?? 'normal') }}">
     <?php /*
      <div class="mb-3 col-12 col-md-5">
        <label class="form-label">{{ __('panel/product.type') }}</label>
        <select class="form-select" name="type" id="product-type" {{ $product->id ? 'disabled' : '' }} required>
          @php
            $productTypes = \InnoShop\Common\Repositories\ProductRepo::getProductTypes();
            $currentType = old('type', $product->type ?? 'normal');
          @endphp
          @foreach($productTypes as $typeValue => $typeLabel)
            <option value="{{ $typeValue }}" {{ $currentType == $typeValue ? 'selected' : '' }}>
              {{ $typeLabel }}
            </option>
          @endforeach
        </select>
        @if($product->id)
          <input type="hidden" name="type" value="{{ old('type', $product->type ?? 'normal') }}">
        @endif
        <div class="mt-2 text-muted small">
          <i class="bi bi-info-circle me-1"></i>{{ __('panel/product.type_hint') }}
        </div>
      </div>
      */  ?>
  <div class="row">
      <div class="mb-3 col-12 col-md-5">
        <div class="mb-1 fs-6">{{ __('panel/product.property_title') }}</div>
        @if(has_translator())
          <div
            class="d-flex align-items-center my-3 py-2 px-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3"
            style="white-space: nowrap;">
            <div class="d-flex align-items-center me-3">{{ __('panel/product.auto_translate') }}</div>
            <select id="source-locale" class="form-select form-select-sm">
              @foreach (locales() as $locale)
                <option value="{{ $locale->code }}">{{ $locale->name }}</option>
              @endforeach
            </select>
            <div class="px-1"><i class="bi bi-arrow-right"></i></div>
            <select id="target-locale" class="form-select form-select-sm">
              <option value="all">{{ __('panel/product.other_all') }}</option>
              @foreach (locales() as $locale)
                <option value="{{ $locale->code }}">{{ $locale->name }}</option>
              @endforeach
            </select>
            <button type="button" class="mx-2 btn btn-primary btn-custom-small btn-sm" id="translate-button">
              {{ __('panel/product.translate') }}
            </button>
          </div>
        @endif

        @foreach (locales() as $locale)
          @php($localeCode = $locale->code)
          @php($localeName = $locale->name)
          <div class="input-group mb-2">
            <div class="input-group-text">
              <div class="d-flex align-items-center wh-20">
                <img src="{{ image_origin($locale->image) }}"
                    class="img-fluid {{ default_locale_class($locale->code) }}"
                    alt="{{ $localeName }}">
              </div>
            </div>
            <input type="text" class="form-control" name="translations[{{ $localeCode }}][name]"
                  value="{{ old('translations.' . $localeCode . '.name', $product->translate($localeCode, 'name')) }}"
                  required placeholder="{{ __('panel/product.name') }}" aria-label="{{ $localeName }}"
                  aria-describedby="basic-addon1" data-locale="{{ $localeCode }}">
          </div>
        @endforeach
        <div class="mt-1 text-muted small">
          <i class="bi bi-info-circle me-1"></i>{{ __('panel/product.name_required_hint') }}
        </div>
      </div>
      <?php /* <div class="col-12 col-md-3">
          <x-common-form-select :title="__('panel/product.list_type')" name="propertyProps[list_type]"
                          :value="old('propertyProps.list_type', $product->propertyProps->list_type ?? 0)" :options="$categoryOptions"
                          key="id" label="name"/>  
        </div> */ ?>
      
      <div class="col-12 col-md-5" id="product-category">
        <x-panel::form.row title="{{ __('panel/common.listing_type') }}">
          <div class="category-select">
            <el-cascader
              :options="source.categories"
              size="medium"
              ref="refCascader"
              placeholder="Please select/search property type"
              :props="{ label: 'label', value: 'value', children: 'children', checkStrictly: true}"
              @change="categoriesChange"
              filterable
              class="category-cascader"
              :class="!categoryFormat.length ? 'no-data' : ''"
              style="width: 100%;">
            </el-cascader>

            <div class="category-data" v-if="categoryFormat.length">
              <div class="d-flex flex-wrap gap-2 mt-2">
                <span v-for="item, index in categoryFormat" :key="index" 
                      class="badge bg-light text-dark border d-flex align-items-center px-2 py-1" 
                      style="font-size: 0.875rem; border-radius: 6px; font-weight: normal;">
                  <span class="me-2">@{{ item.fullPath }}</span>
                  <i class="bi bi-x cursor-pointer" 
                    @click="removeCategory(index)" 
                    style="font-size: 0.75rem; opacity: 0.7;"
                    @mouseover="$event.target.style.opacity='1'" 
                    @mouseout="$event.target.style.opacity='0.7'"></i>
                  <input type="hidden" name="categories[]" :value="item.value">
                </span>
              </div>
            </div>
          </div>
        </x-panel::form.row>
      </div>
  </div>

  <div class="row">
    <div class="col-12">      
        <div id="single_price_box1" class="">
          <div class="row">
                
                 <div class="col-12 col-md-3 form-group mb-3">                 
                      <label class="form-label">{{ __('panel/product.seller_type') }}:</label>
                      <div class="radio-group">
                          <div class="form-check">
                            <label class="radio">
                              <input class="form-check-input" type="radio" name="propertyProps[seller_type]" id="owner"
                                value="owner" {{ old('propertyProps.seller_type', $product->propertyProps->seller_type ?? '') == 'owner' ? 'checked' : '' }}>
                              <span class="radio-span" for="owner">{{ __('panel/product.owner') }}</span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[seller_type]" id="dealer"
                              value="dealer" {{ old('propertyProps.seller_type', $product->propertyProps->seller_type ?? '') == 'dealer' ? 'checked' : '' }}>
                            <span class="radio-span" for="dealer">
                              {{ __('panel/product.dealer') }}
                            </span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[seller_type]" id="builder"
                              value="builder"  {{ old('propertyProps.seller_type', $product->propertyProps->seller_type ?? '') == 'builder' ? 'checked' : '' }}>
                            <span class="radio-span" for="builder">
                              {{ __('panel/product.builder') }}
                            </span>
                            </label>
                          </div>
                      </div>
                </div> 

                <div class="col-12 col-md-3 form-group">                 
                      <label class="form-label">{{ __('panel/product.property_for') }}:</label>
                      <div class="radio-group">
                          <div class="form-check">
                            <label class="radio">
                              <input class="form-check-input" type="radio" name="propertyProps[property_for]" id="sale"
                                value="sale" {{ old('propertyProps.property_for', $product->propertyProps->property_for ?? '') == 'sale' ? 'checked' : '' }}>
                              <span class="radio-span" for="sale">{{ __('panel/product.sale') }}</span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[property_for]" id="rent"
                              value="rent" {{ old('propertyProps.property_for', $product->propertyProps->property_for ?? '') == 'rent' ? 'checked' : '' }}>
                            <span class="radio-span" for="rent">
                              {{ __('panel/product.rent') }}
                            </span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[property_for]" id="pg_hostal"
                              value="pg_hostal"  {{ old('propertyProps.property_for', $product->propertyProps->property_for ?? '') == 'pg_hostal' ? 'checked' : '' }}>
                            <span class="radio-span" for="pg_hostal">
                              {{ __('panel/product.pg_hostal') }}
                            </span>
                            </label>
                          </div>
                      </div>
                </div> 
                <div class="col-12 col-md-3 form-group">                 
                      <label class="form-label">{{ __('panel/product.possession_status') }}:</label>
                      <div class="radio-group">
                          <div class="form-check">
                            <label class="radio">
                              <input class="form-check-input" type="radio" name="propertyProps[possession_status]" id="ready_to_move"
                                value="ready_to_move"  {{ old('propertyProps.possession_status', $product->propertyProps->possession_status ?? '') == 'ready_to_move' ? 'checked' : '' }}>
                              <span class="radio-span" for="ready_to_move">{{ __('panel/product.ready_to_move') }}</span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[possession_status]" id="under_construction"
                                value="under_construction" {{ old('propertyProps.possession_status', $product->propertyProps->possession_status ?? '') == 'under_construction' ? 'checked' : '' }}>
                            <span class="radio-span" for="under_construction">
                              {{ __('panel/product.under_construction') }}
                            </span>
                            </label>
                          </div>
                      </div>
                </div>
                <div class="col-12 col-md-3 form-group">                 
                      <label class="form-label">{{ __('panel/product.transaction_type') }}:</label>
                      <div class="radio-group">
                          <div class="form-check">
                            <label class="radio">
                              <input class="form-check-input" type="radio" name="propertyProps[transaction_type]" id="new_property"
                                value="new_property" {{ old('propertyProps.transaction_type', $product->propertyProps->transaction_type ?? '') == 'new_property' ? 'checked' : '' }}>
                              <span class="radio-span" for="new_property">{{ __('panel/product.new_property') }}</span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[transaction_type]" id="resale"
                              value="resale" {{ old('propertyProps.transaction_type', $product->propertyProps->transaction_type ?? '') == 'resale' ? 'checked' : '' }}>
                            <span class="radio-span" for="resale">
                              {{ __('panel/product.resale') }}
                            </span>
                            </label>
                          </div>
                      </div>
                </div>
          </div>       
        </div>        
        <div id="single_price_box1 " class="">
          <div class="row">
                                
                <div class="col-12 col-md-3 plot-area-field mb-3">
                    <label>{{ __('panel/product.plot_area') }}</label>
                      <div class="plot-area-input">
                        <input
                          type="number"
                          name="propertyProps[plot_area]"
                          placeholder="{{ __('panel/product.plot_area') }}"
                          class="plot-area-number"                       
                          value="{{ old('propertyProps.plot_area', $product->propertyProps->plot_area ?? '') }}"
                        />
                        <select class="plot-area-type" name="propertyProps[plot_area_type]">
                            @foreach($areaTypeOptions as $value => $label)
                                <option
                                    value="{{ $label['id'] }}"
                                    {{ old('propertyProps.plot_area_type', $product->propertyProps->plot_area_type ?? '') == $label['id'] ? 'selected' : '' }}>
                                    {{ $label['name'] }}
                                </option>
                            @endforeach
                        </select>
                      </div>
                </div>  

                <div class="col-12 col-md-3 plot-area-field">
                    <label>{{ __('panel/product.covered_area') }}</label>
                      <div class="plot-area-input">
                        <input
                          type="number"
                          name="propertyProps[covered_area]"
                          placeholder="{{ __('panel/product.covered_area') }}"
                          class="plot-area-number"                       
                          value="{{ old('propertyProps.covered_area', $product->propertyProps->covered_area ?? '') }}"
                        />
                        <select class="plot-area-type" name="propertyProps[covered_area_type]">
                            @foreach($areaTypeOptions as $value => $label)
                                <option
                                    value="{{ $label['id'] }}"
                                    {{ old('propertyProps.covered_area_type', $product->propertyProps->covered_area_type ?? '') == $label['id'] ? 'selected' : '' }}>
                                    {{ $label['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>  

                <div class="col-12 col-md-3 plot-area-field">
                    <label>{{ __('panel/product.carpet_area') }}</label>
                      <div class="plot-area-input">
                        <input
                          type="number"
                          name="propertyProps[carpet_area]"
                          placeholder="{{ __('panel/product.carpet_area') }}"
                          class="plot-area-number"                       
                          value="{{ old('propertyProps.carpet_area', $product->propertyProps->carpet_area ?? '') }}"
                        />
                        <select class="plot-area-type" name="propertyProps[carpet_area_type]">
                            @foreach($areaTypeOptions as $value => $label)
                                <option
                                    value="{{ $label['id'] }}"
                                    {{ old('propertyProps.carpet_area_type', $product->propertyProps->carpet_area_type ?? '') == $label['id'] ? 'selected' : '' }}>
                                    {{ $label['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-3 plot-area-field">
                  <label>{{ __('panel/product.super_builtup_area') }}</label>
                    <div class="plot-area-input">
                      <input
                        type="number"
                        name="propertyProps[super_builtup_area]"
                        placeholder="{{ __('panel/product.super_builtup_area') }}"
                        class="plot-area-number"                       
                        value="{{ old('propertyProps.super_builtup_area', $product->propertyProps->super_builtup_area ?? '') }}"
                      />
                      <select class="plot-area-type" name="propertyProps[super_builtup_area_type]">
                          @foreach($areaTypeOptions as $value => $label)
                              <option
                                  value="{{ $label['id'] }}"
                                  {{ old('propertyProps.super_builtup_area_type', $product->propertyProps->super_builtup_area_type ?? '') == $label['id'] ? 'selected' : '' }}>
                                  {{ $label['name'] }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                </div>
          </div>      
        </div>
        <div id="single_price_box1 " class="">
          <div class="row">
            <div class="col-12 col-md-3 mb-3">
                    <x-common-form-select :title="__('panel/product.bedrooms')" name="propertyProps[bedrooms]"
                                  :value="old('propertyProps.bedrooms', $product->propertyProps->bedrooms ?? 0)" :options="$bedroomsOptions"
                                  key="id" label="name"/>  
                </div>
                <div class="col-12 col-md-3">
                    <x-common-form-select :title="__('panel/product.bathrooms')" name="propertyProps[bathrooms]"
                                  :value="old('propertyProps.bathrooms', $product->propertyProps->bathrooms ?? 0)" :options="$bathRoomsOptions"
                                  key="id" label="name"/>  
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-select :title="__('panel/product.balcony')" name="propertyProps[balcony]"
                                  :value="old('propertyProps.balcony', $product->propertyProps->balcony ?? 0)" :options="$balconyOptions"
                                  key="id" label="name"/>  
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-select :title="__('panel/product.total_floors')" name="propertyProps[total_floors]"
                                  :value="old('propertyProps.total_floors', $product->propertyProps->total_floors ?? 0)" :options="$totalFloorsOptions"
                                  key="id" label="name"/>  
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-select :title="__('panel/product.floor_no')" name="propertyProps[floor_no]"
                                  :value="old('propertyProps.floor_no', $product->propertyProps->floor_no ?? 0)" :options="$totalFloorsOptions"
                                  key="id" label="name"/>  
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-select :title="__('panel/product.facing')" name="propertyProps[facing]"
                                  :value="old('propertyProps.facing', $product->propertyProps->facing ?? 0)" :options="$facingOptions"
                                  key="id" label="name"/>  
                </div>
                
                <div class="col-12 col-md-3">
                  <x-common-form-select :title="__('panel/product.open_side')" name="propertyProps[open_side]"
                                  :value="old('propertyProps.open_side', $product->propertyProps->open_side ?? 0)" :options="$openSideOptions"
                                  key="id" label="name"/>  
                </div>
               <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.allowed_floors')" name="propertyProps[allowed_floors]"
                                    value="{{ old('propertyProps.allowed_floors', $product->propertyProps->allowed_floors ?? '') }}" />
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.plot_length')" name="propertyProps[plot_length]"
                                    value="{{ old('propertyProps.plot_length', $product->propertyProps->plot_length ?? '') }}" />
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.plot_breadth')" name="propertyProps[plot_breadth]"
                                    value="{{ old('propertyProps.plot_breadth', $product->propertyProps->plot_breadth ?? '') }}" />
                </div>
                
                
                <div class="col-12 col-md-3 plot-area-field">
                    <label>{{ __('panel/product.price') }}</label>
                      <div class="plot-area-input">
                        <input
                          type="number"
                          name="propertyProps[price]"
                          placeholder="{{ __('panel/product.price') }}"
                          class="plot-area-number"                       
                          value="{{ old('propertyProps.price', $product->propertyProps->price ?? '') }}"
                        />
                        <select class="plot-area-type" name="propertyProps[price_type]">
                            @foreach($priceTypeOptions as $value => $label)
                                <option
                                    value="{{ $label['id'] }}"
                                    {{ old('propertyProps.price_type', $product->propertyProps->price_type ?? '') == $label['id'] ? 'selected' : '' }}>
                                    {{ $label['name'] }}
                                </option>
                            @endforeach
                        </select>
                      </div>
                </div>  

                <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.city')" name="propertyProps[city]"
                                    value="{{ old('propertyProps.city', $product->propertyProps->city ?? '') }}" />
                </div>

                <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.location')" name="propertyProps[location]"
                                    value="{{ old('propertyProps.location', $product->propertyProps->location ?? '') }}" />
                </div>

                <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.address')" name="propertyProps[address]"
                                    value="{{ old('propertyProps.address', $product->propertyProps->address ?? '') }}" />
                </div>
                <div class="col-12 col-md-3 form-group">                 
                      <label class="form-label">{{ __('panel/product.furnished_status') }}:</label>
                      <div class="radio-group">
                          <div class="form-check">
                            <label class="radio">
                              <input class="form-check-input" type="radio" name="propertyProps[furnished_status]" id="unfurnished"
                                value="unfurnished" {{ old('propertyProps.furnished_status', $product->propertyProps->furnished_status ?? '') == 'unfurnished' ? 'checked' : '' }}>
                              <span class="radio-span" for="unfurnished">{{ __('panel/product.unfurnished') }}</span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[furnished_status]" id="furnished"
                              value="furnished" {{ old('propertyProps.furnished_status', $product->propertyProps->furnished_status ?? '') == 'furnished' ? 'checked' : '' }}>
                            <span class="radio-span" for="furnished">
                              {{ __('panel/product.furnished') }}
                            </span>
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="radio">
                            <input class="form-check-input" type="radio" name="propertyProps[furnished_status]" id="semi_furnished"
                              value="semi_furnished"  {{ old('propertyProps.furnished_status', $product->propertyProps->furnished_status ?? '') == 'semi_furnished' ? 'checked' : '' }}>
                            <span class="radio-span" for="semi_furnished">
                              {{ __('panel/product.semi_furnished') }}
                            </span>
                            </label>
                          </div>
                      </div>
                </div>
                            
      
                <input type="hidden" name="skus[0][code]" value="<?php echo time(); ?>">
                <input type="hidden" name="skus[0][model]" value="">
                <input type="hidden" name="skus[0][is_default]" value="1">
                <input type="hidden" name="skus[0][quantity]" value="1">
                <input class="form-check-input" type="hidden" name="price_type" id="price_type_single" value="single">
                <!-- <input type="hidden" name="propertyProps.admin_id" value="{{ old('propertyProps.admin_id', $product->propertyProps->admin_id ?? auth()->user()->id ) }}"> -->

          </div>   
        </div>
        <div id="single_price_box1" class="">
          <div class="row">                   
                <div class="col-12 col-md-3">
                  <x-common-form-select :title="__('panel/product.property_age')" name="propertyProps[property_age]"
                                  :value="old('propertyProps.property_age', $product->propertyProps->property_age ?? 0)" :options="$propertyAgeOptions"
                                  key="id" label="name"/>  
                </div>
                  <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.rera_registration_no')" name="propertyProps[rera_registration_no]"
                                    value="{{ old('propertyProps.rera_registration_no', $product->propertyProps->rera_registration_no ?? '') }}" />
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.maintenance_cost')" name="propertyProps[maintenance_cost]"
                                    value="{{ old('propertyProps.maintenance_cost', $product->propertyProps->maintenance_cost ?? '') }}" />
                </div>
                <div class="col-12 col-md-3">
                  <x-common-form-input :title="__('panel/product.maintenance_cost_period')" name="propertyProps[maintenance_cost_period]"
                                    value="{{ old('propertyProps.maintenance_cost_period', $product->propertyProps->maintenance_cost_period ?? '') }}" />
                </div>
                <div class="col-12 col-md-2">
                  <x-common-form-switch-radio :title="__('panel/product.is_corner')" name="is_corner"
                                          :value="old('is_corner', $product->is_corner ?? false)"/>
                </div>          
                
                  @if (!auth()->user()->hasAnyRole(['Seller'])) 
                      

                      <div class="col-12 col-md-2">
                        <x-common-form-switch-radio :title="__('panel/common.status')" name="active"
                                                :value="old('active', $product->active ?? true)"/>
                      </div>
                      <div class="col-12 col-md-2">
                        <x-common-form-switch-radio :title="__('panel/product.today_deal')" name="is_today_deal"
                                                :value="old('is_today_deal', $product->is_today_deal ?? false)"/>
                      </div>
                      <div class="col-12 col-md-2">
                        <x-common-form-switch-radio :title="__('panel/common.is_hot_deal')" name="is_hot_deal"
                                                :value="old('is_hot_deal', $product->is_hot_deal ?? false)"/>
                      </div>
                      <div class="col-12 col-md-2">
                        <x-common-form-switch-radio :title="__('panel/common.is_featured')" name="is_featured"
                                                :value="old('is_featured', $product->is_featured ?? false)"/>
                      </div>
              @endif  
                    
            </div>
           
        </div>
      <!-- Properties Details Below End-->
    </div>  

    <div class="mt-5 mb-4">      
        <x-common-form-images title="{{ __('panel/common.image') }}" name="images"
                              :values="old('images', $product->images ?? [])"/>
        <x-common-form-image title="{{ __('panel/product.hover_image') }}" name="hover_image"
                            :value="old('hover_image', $product->hover_image ?? '')"
                            :description="__('panel/product.hover_image_help')"/>

        <?php /* @include('panel::products.form._form_video') */ ?>        
        @include('panel::products.panes.tab_pane_content', $product)
    </div>
      
    </div>
  </div>
    
  @hookinsert('panel.product.edit.basic.after')

  <!-- Variant -->
      <div id="specifications_box" class="{{ !$product->isMultiple() ? 'd-none' : '' }}">
              <div class="alert alert-info mb-3" id="multi_spec_notice">
                <i class="bi bi-info-circle me-2"></i>
                {{ __('panel/product.multiple_spec_notice') }}
              </div>
              @include('panel::products.form._form_variant')
              @hookinsert('panel.product.edit.form_variant.after')
            </div>
      </div>


@push('footer')
<script src="https://unpkg.com/element-plus/dist/index.full.js"></script>
<link rel="stylesheet" href="https://unpkg.com/element-plus/dist/index.css">
<script>
  const productApp = Vue.createApp({
    data() {
      return {
        form: {
          categories: @json(old('categories', $product->categories->pluck('id')->toArray()) ?? []),
        },
        source: {
          categories: @json($categories),
        }
      };
    },
    mounted() {
      this.$nextTick(() => {
        //  console.log('Cascader component:', this.$refs.refCascader);
      });
    },

    computed: {
      categoryFormat() {

        const categories = JSON.parse(JSON.stringify(this.source.categories));
        const categoryIds = this.form.categories;
        const categoryFormat = [];

        const findCategoryWithPath = (cats, id, parentPath = []) => {
          for (let cat of cats) {
            const currentPath = [...parentPath, cat.label];
            if (cat.value == id) {
              return {
                value: cat.value,
                label: cat.label,
                fullPath: currentPath.join(' > ')
              };
            }
            if (cat.children && cat.children.length) {
              const found = findCategoryWithPath(cat.children, id, currentPath);
              if (found) return found;
            }
          }
          return null;
        };

       
        categoryIds.forEach((categoryId) => {
          const category = findCategoryWithPath(categories, categoryId);
          
          if (category) {
            if(categoryFormat.length > 0){
              alert("Maximum 1 categories can be selected.");
            }else{
              categoryFormat.push(category);
            }              
          }
        });

        

        return categoryFormat;
      },
    },

    methods: {
      categoriesChange(e) {
        console.log('Category changed:', e);
        const last = e[e.length - 1];
        if (last && this.form.categories.includes(last)) {
          this.$message.warning('This category has already been selected.');
          return;
        }

        if (last) {
          this.form.categories.push(last);
        }
      },
      removeCategory(index) {
        this.form.categories.splice(index, 1);
      },
    }
  });
  productApp.use(ElementPlus);
  productApp.mount('#product-category');
  </script>
  @endpush
