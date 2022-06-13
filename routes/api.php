<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResources([
    'sellers' => SellerController::class,
    'orders' => OrderController::class,
]);

Route::get('/sellers/{seller}/orders', [SellerController::class, 'showOrders']);
Route::get('/orders/total/{date}', [OrderController::class, 'showTotalOrders']);

