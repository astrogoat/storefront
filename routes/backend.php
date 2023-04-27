<?php

use Astrogoat\Storefront\Http\Livewire\StorefrontCollectionForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontCollectionIndex;
use Illuminate\Support\Facades\Route;
use Astrogoat\Storefront\Http\Controllers\StorefrontCollectionController;
use Astrogoat\Storefront\Http\Livewire\StorefrontOrderForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontOrderIndex;
use Astrogoat\Storefront\Http\Controllers\StorefrontProductController;
use Astrogoat\Storefront\Http\Livewire\StorefrontProductForm;
use Astrogoat\Storefront\Http\Livewire\StorefrontProductIndex;

Route::group([
    'as' => 'storefront.',
    'prefix' => 'storefront/'
], function () {
    Route::group([
        'as' => 'products.',
        'prefix' => 'products'
    ], function () {
        Route::get('/', StorefrontProductIndex::class)->name('index');
        Route::get('/create', StorefrontProductForm::class)->name('create');
        Route::get('/{product}/edit', StorefrontProductForm::class)->name('edit');
        Route::get('/{product}/editor/{editor_view?}', [StorefrontProductController::class, 'editor'])->name('editor');
    });

    Route::group([
        'as' => 'collections.',
        'prefix' => 'collections'
    ], function () {
        Route::get('/', StorefrontCollectionIndex::class)->name('index');
        Route::get('/create', StorefrontCollectionForm::class)->name('create');
        Route::get('/{collection}/edit', StorefrontCollectionForm::class)->name('edit');
        Route::get('/{collection}/editor/{editor_view?}', [StorefrontCollectionController::class, 'editor'])->name('editor');
    });

    Route::group([
        'as' => 'orders.',
        'prefix' => 'orders'
    ], function () {
        Route::get('/', StorefrontOrderIndex::class)->name('index');
        Route::get('/create', StorefrontOrderForm::class)->name('create');
        Route::get('/{storeOrder}/edit', StorefrontOrderForm::class)->name('edit');
//        Route::get('/{storeOrder}/editor/{editor_view?}', [StorefrontCollectionController::class, 'editor'])->name('editor');
    });
});

