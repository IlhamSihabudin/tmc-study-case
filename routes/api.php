<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Store Category
Route::post('categories', [CategoryController::class, 'store'])
    ->name('categories.store');

// Store Product
Route::post('products', [ProductController::class, 'store'])
    ->name('products.store');

// Search Product
Route::get('search', [ProductController::class, 'index'])
    ->name('products.search');
