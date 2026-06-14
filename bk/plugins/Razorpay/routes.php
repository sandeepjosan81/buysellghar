<?php

use Illuminate\Support\Facades\Route;
use Plugins\Razorpay\Controllers\RazorpayPaymentController;


// Route::prefix('en')
Route::prefix('')
    ->group(function () {
            Route::get('/razorpay', [RazorpayPaymentController::class, 'index'])->name('razorpay.index');
            Route::post('/razorpay/pay', [RazorpayPaymentController::class, 'pay'])->name('razorpay.pay');

            Route::post('/razorpay/{order_id}/pay', [RazorpayPaymentController::class, 'pay'])->name('razorpay.pay')->where('order_id', '[0-9]+');

            Route::get('/razorpay/{number}/success', [RazorpayPaymentController::class, 'success'])->name('razorpay.success');
            Route::get('/razorpay/{number}/failed', [RazorpayPaymentController::class, 'failed'])->name('razorpay.failed');
            Route::post('/razorpay/update_order_payment', [RazorpayPaymentController::class, 'update_order_payment'])->name('razorpay.update_order_payment');
});