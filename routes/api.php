<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoriesController as Inventories;
use App\Http\Controllers\ProductsController as Products;
use App\Http\Controllers\PaymentMethodController as Payment;
use App\Http\Controllers\SalesController as Sales;

Route::middleware('api.key')->group(function () {
    // route api inventories
    Route::get('/inventories', [Inventories::class, 'index']);
    Route::get('/inventories/{id}', [Inventories::class, 'show']);
    Route::post('/inventories', [Inventories::class, 'store']);
    Route::post('/inventories/{id}', [Inventories::class, 'update']);
    Route::delete('/inventories/{id}', [Inventories::class, 'destroy']);

    // route api products
    Route::get('/products', [Products::class, 'index']);
    Route::get('/products/{id}', [Products::class, 'show']);
    Route::post('/products', [Products::class, 'store']);
    Route::post('/products/{id}', [Products::class, 'update']);
    Route::delete('/products/{id}', [Products::class, 'destroy']);

    // route api payment method
    Route::get('/payment-method', [Payment::class, 'index']);
    Route::get('/payment-method/{id}', [Payment::class, 'show']);
    Route::post('/payment-method', [Payment::class, 'store']);
    Route::post('/payment-method/{id}', [Payment::class, 'update']);
    Route::delete('/payment-method/{id}', [Payment::class, 'destroy']);

    // route api sales
    Route::get('/sales', [Sales::class, 'index']);
    Route::get('/sales/{id}', [Sales::class, 'show']);
    Route::post('/sales', [Sales::class, 'store']);
});
