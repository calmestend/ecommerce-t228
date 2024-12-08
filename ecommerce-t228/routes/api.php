<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleStockController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\WishListProductController;
use Illuminate\Support\Facades\Route;

// Categories
Route::get('api/categories/', [CategoryController::class, 'index'])->name('api.categories.index');
Route::get('api/categories/{id}', [CategoryController::class, 'show'])->name('api.categories.show');
Route::post('api/categories/store', [CategoryController::class, 'store'])->name('api.categories.store');
Route::post('api/categories/{id}/update', [CategoryController::class, 'update'])->name('api.categories.update');
Route::get('api/categories/{id}/destroy', [CategoryController::class, 'destroy'])->name('api.categories.destroy');

// Products
Route::get('api/products/', [ProductController::class, 'index'])->name('api.products.index');
Route::get('api/products/{id}', [ProductController::class, 'show'])->name('api.products.show');
Route::post('api/products/store', [ProductController::class, 'store'])->name('api.products.store');
Route::post('api/products/{id}/update', [ProductController::class, 'update'])->name('api.products.update');
Route::get('api/products/{id}/destroy', [ProductController::class, 'destroy'])->name('api.products.destroy');

// Stocks
Route::get('api/stocks/', [StockController::class, 'index'])->name('api.stocks.index');
Route::get('api/stocks/{id}', [StockController::class, 'show'])->name('api.stocks.show');
Route::post('api/stocks/store', [StockController::class, 'store'])->name('api.stocks.store');
Route::post('api/stocks/{id}/update', [StockController::class, 'update'])->name('api.stocks.update');
Route::get('api/stocks/{id}/destroy', [StockController::class, 'destroy'])->name('api.stocks.destroy');

// Sale
Route::get('api/sales/', [SaleController::class, 'index'])->name('api.sales.index');
Route::get('api/sales/{id}', [SaleController::class, 'show'])->name('api.sales.show');
Route::post('api/sales/store', [SaleController::class, 'store'])->name('api.sales.store');
Route::post('api/sales/{id}/update', [SaleController::class, 'update'])->name('api.sales.update');
Route::get('api/sales/{id}/destroy', [SaleController::class, 'destroy'])->name('api.sales.destroy');

// Sale Stocks
Route::get('api/sale_stocks/', [SaleStockController::class, 'index'])->name('api.sale_stocks.index');
Route::get('api/sale_stocks/{id}', [SaleStockController::class, 'show'])->name('api.sale_stocks.show');
Route::post('api/sale_stocks/store', [SaleStockController::class, 'store'])->name('api.sale_stocks.store');
Route::post('api/sale_stocks/{id}/update', [SaleStockController::class, 'update'])->name('api.sale_stocks.update');
Route::get('api/sale_stocks/{id}/destroy', [SaleStockController::class, 'destroy'])->name('api.sale_stocks.destroy');

// Payment
Route::get('api/payments/', [PaymentController::class, 'index'])->name('api.payments.index');
Route::get('api/payments/{id}', [PaymentController::class, 'show'])->name('api.payments.show');
Route::post('api/payments/store', [PaymentController::class, 'store'])->name('api.payments.store');
Route::post('api/payments/{id}/update', [PaymentController::class, 'update'])->name('api.payments.update');
Route::get('api/payments/{id}/destroy', [PaymentController::class, 'destroy'])->name('api.payments.destroy');

// Wish List
Route::get('api/wish_lists/', [WishListController::class, 'index'])->name('api.wish_lists.index');
Route::get('api/wish_lists/{id}', [WishListController::class, 'show'])->name('api.wish_lists.show');
Route::post('api/wish_lists/store', [WishListController::class, 'store'])->name('api.wish_lists.store');
Route::post('api/wish_lists/{id}/update', [WishListController::class, 'update'])->name('api.wish_lists.update');
Route::get('api/wish_lists/{id}/destroy', [WishListController::class, 'destroy'])->name('api.wish_lists.destroy');

// Wish List Products
Route::get('api/wish_list_products/', [WishListProductController::class, 'index'])->name('api.wish_list_products.index');
Route::get('api/wish_list_products/{id}', [WishListProductController::class, 'show'])->name('api.wish_list_products.show');
Route::post('api/wish_list_products/store', [WishListProductController::class, 'store'])->name('api.wish_list_products.store');
Route::post('api/wish_list_products/{id}/update', [WishListProductController::class, 'update'])->name('api.wish_list_products.update');
Route::get('api/wish_list_products/{id}/destroy', [WishListProductController::class, 'destroy'])->name('api.wish_list_products.destroy');

// Invoice
Route::get('api/invoices/', [InvoiceController::class, 'index'])->name('api.invoices.index');
Route::get('api/invoices/{id}', [InvoiceController::class, 'show'])->name('api.invoices.show');
Route::post('api/invoices/store', [InvoiceController::class, 'store'])->name('api.invoices.store');
Route::post('api/invoices/{id}/update', [InvoiceController::class, 'update'])->name('api.invoices.update');
Route::get('api/invoices/{id}/destroy', [InvoiceController::class, 'destroy'])->name('api.invoices.destroy');

// Users
Route::post('api/users/login', [UserController::class, 'login'])->name('api.users.login');
Route::post('api/users/register', [UserController::class, 'register'])->name('api.users.register');
