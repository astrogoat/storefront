<?php

use Astrogoat\Storefront\Http\Controllers\StorefrontOrderController;
use Illuminate\Support\Facades\Route;
use Astrogoat\Storefront\Http\Controllers\StorefrontCollectionController;
use Astrogoat\Storefront\Http\Controllers\StorefrontProductController;

Route::group([
    'as' => 'products.',
    'prefix' => 'products'
], function () {
    Route::get('{product:slug}', [StorefrontProductController::class, 'show'])->name('show');
});

Route::group([
    'as' => 'collections.',
    'prefix' => 'collections'
], function () {
    Route::get('{collection:slug}', [StorefrontCollectionController::class, 'show'])->name('show');
});

Route::group([
    'as' => 'orders.',
    'prefix' => 'orders'
], function () {
    Route::get('/{storeOrder}/invoice', [StorefrontOrderController::class, 'invoice'])->name('invoice');
    Route::get('/{reference}/track', [StorefrontOrderController::class, 'track'])->name('track');
});

