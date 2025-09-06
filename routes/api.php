<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'create']);
    Route::post('/{orderId}/pay', [OrderController::class, 'pay']);
    Route::post('/{orderId}/fulfill', [OrderController::class, 'fulfill']);
    Route::post('/{orderId}/cancel', [OrderController::class, 'cancel']);
});
