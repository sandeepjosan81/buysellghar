<?php



use Illuminate\Support\Facades\Route;
use Plugin\Paypal\Controllers\PaypalController;

Route::post('/paypal/create', [PaypalController::class, 'create'])->name('paypal.create');
Route::post('/paypal/capture', [PaypalController::class, 'capture'])->name('paypal.capture');
