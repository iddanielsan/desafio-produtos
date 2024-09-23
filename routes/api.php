<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('product', ProductController::class)->parameters([
    'product' => 'product'
]);

Route::apiResource('order', OrderController::class)->parameters([
    'order' => 'order'
]);
