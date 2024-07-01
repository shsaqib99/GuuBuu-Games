<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingsController;


Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('products', ProductController::class)->only('index');

    Route::resource('settings', SettingsController::class);

    Route::get('/fetchProducts', [ProductController::class, 'fetchProducts'])->name('fetchProducts');
    Route::post('/importProduct', [ProductController::class, 'importProduct'])->name('importProduct');

    Route::get('/list', [\App\Http\Controllers\ShopifyController::class, 'listProducts']);

    Route::get('/shopify', [\App\Http\Controllers\ShopifyController::class, 'index']);
});
