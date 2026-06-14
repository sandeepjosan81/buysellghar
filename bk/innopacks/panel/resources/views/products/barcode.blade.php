@extends('panel::layouts.app')
@section('body-class', 'page-product')
@section('title', __('panel/menu.products'))

@section('content')
  <div class="card h-min-600" id="app">
        <div class="card-body">
            <div class="barcode">
                <p class="name">{{$product->slug}}</p>
                <p class="price">Price: {{ currency_format($product->masterSku->price ?? 0) }}</p>    
                {!! DNS1D::getBarcodeHTML((string) $product->id, 'C128') !!}
                <p class="pid">{{$product->id}}</p>
            </div>

        </div>
    </div>
  @endsection

@push('footer')