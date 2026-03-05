<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

use function Illuminate\Support\days;

Route::apiResource('clients', ClientController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('clients.sales', SaleController::class)->only('store');
Route::apiResource('sales', SaleController::class)->only('show')->middleware(CacheResponse::for(days(30)));
