<?php


use Illuminate\Support\Facades\Route;
use Plugin\Stripe\Controllers\StripeController;

// Elements
Route::post('/stripe/capture', [StripeController::class, 'capture'])->name('stripe_capture');
Route::post('/callback/stripe', [StripeController::class, 'callback'])->name('stripe_callback');

// Checkout
Route::post('/stripe/checkout-session', [StripeController::class, 'createCheckoutSession'])->name('stripe_checkout_session');
Route::get('/stripe/checkout-success', [StripeController::class, 'checkoutSuccess'])->name('stripe_checkout_success');
Route::get('/stripe/checkout-cancel', [StripeController::class, 'checkoutCancel'])->name('stripe_checkout_cancel');
