


@extends('layouts.app')
@section('body-class', 'page-home')

@push('header')
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">
@endpush

@section('content')

  @hookinsert('home.content.top')

  <section class="module-content">
    
        <div class="container">

        <div class="success-icon">
            ✔
        </div>

        <h1>Payment Successful!</h1>

        <p>Your payment has been completed successfully.</p>

        <div class="details">
            <p><strong>Order ID:</strong> #{{ $number ?? 'N/A' }}</p>
            <p><strong>Amount Paid:</strong> ₹{{ $amount ?? '0.00' }}</p>
            <p><strong>Payment ID:</strong> {{ $gateway_payment_id ?? 'N/A' }}</p>
        </div>

        <a href="{{ url('/') }}" class="btn">Continue Shopping</a>


        </div>

  </section>

  @hookinsert('home.content.bottom')

@endsection
<style>
    .success-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: #e6f9f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-icon svg {
        width: 40px;
        height: 40px;
        color: #28a745;
    }

    h1 {
        color: #28a745;
        margin-bottom: 10px;
    }

    p {
        color: #555;
        font-size: 15px;
        margin-bottom: 20px;
    }

    .details {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        text-align: left;
    }

    .details p {
        margin: 5px 0;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        background: #28a745;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn:hover {
        background: #218838;
    }
</style>
