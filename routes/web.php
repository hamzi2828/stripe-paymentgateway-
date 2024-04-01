<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;


Route::get('/', function () {
    return view('welcome');
});




// Route::get('/checkout', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
// Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');
// Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');

// Route::get('/checkout',  [StripeController::class, 'checkout'])->name('checkout');
// Route::post('/session', [StripeController::class, 'processPayment'] )->name('process.payment');
// Route::get('/success',  [StripeController::class, 'success'] )->name('payment.success');

Route::get('checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::post('process-payment', [StripeController::class, 'processPayment'])->name('process.payment');
Route::get('payment-success', [StripeController::class, 'success'])->name('payment.success');
// Route::get('/card-declined', [StripeController::class, 'handleCardDeclined'])->name('card.declined');
