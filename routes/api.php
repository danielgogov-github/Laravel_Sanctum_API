<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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

// Users
Route::get('/user/login', [AuthController::class, 'login']);
// Products
Route::get('/products', [ProductController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    // Users
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::get('/user/logout', [AuthController::class, 'logout']);
    // Products
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/search/{search}', [ProductController::class, 'search']);    
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});
