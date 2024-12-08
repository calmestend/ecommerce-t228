<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\ShoppingHistoryController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\WishListProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Catalogue
    Route::get('/catalogue', [CatalogueController::class, "index"])->name('catalogue');

    // Wish List
    Route::get('/wish_list', [WishListController::class, "indexView"])->name('wish_list');
    Route::post('/wish_list/store', [WishListProductController::class, "storeView"])->name('wish_list_products.store');
    Route::post('/wish_list/destroy/{id}', [WishListProductController::class, "destroyView"])->name('wish_list_products.destroy');

    // Shopping Cart
    Route::get('/shopping_cart', [ShoppingCartController::class, "index"])->name('shopping_cart');
    Route::post('/shopping_cart/store', [ShoppingCartController::class, "store"])->name('shopping_cart.store');
    Route::post('/shopping_cart/destroy/', [ShoppingCartController::class, "destroyAll"])->name('shopping_cart.destroy.all');
    Route::post('/shopping_cart/destroy/{stock_id}', [ShoppingCartController::class, "destroy"])->name('shopping_cart.destroy');

    // PayPal
    Route::post('/paypal', [PayPalController::class, "payment"])->name('paypal.payment');
    Route::get('/paypal/success', [PayPalController::class, "success"])->name('paypal.success');
    Route::get('/paypal/cancel', [PayPalController::class, "cancel"])->name('paypal.cancel');

    // Invoice
    Route::post('/invoice/download/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoice.download.pdf');
    Route::post('/invoice/download/xml', [InvoiceController::class, 'downloadXml'])->name('invoice.download.xml');


    // Shopping History
    Route::get('/shopping_history', [ShoppingHistoryController::class, "index"])->name('shopping_history');
});
