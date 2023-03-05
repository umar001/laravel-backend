<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

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

Route::get('test', function (Request $request) {
    return ApiResponse::success(['name' => 'Abigail', 'state' => 'CA'], 200, ['accept' => "application/json"], 5);
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get("/get-details", [UserController::class, "getUserDetails"]);
    Route::post("/store-news-feed", [UserController::class, "storeNewsFeed"]);
    Route::post("/update-profile", [UserController::class, "updateProfile"]);
});
