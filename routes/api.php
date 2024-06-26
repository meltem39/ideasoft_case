<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\DiscountController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [LoginController::class, "register"]);
Route::post('login', [LoginController::class, "login"]);

Route::middleware('auth:api')->group(function () {
    //PRODUCT
    Route::get("products", [ProductController::class, "list"]);
    //ORDER
    Route::resource("orders", OrderController::class);
    //DISCOUNT
    Route::get("discount", DiscountController::class);


});
