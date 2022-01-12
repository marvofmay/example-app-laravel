<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UsersController;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::post('/login', [LoginController::class, 'login'])->name('api_login');
Route::get('/products/{phrase?}', [ProductController::class, 'list'])->name('api_product_list');
Route::get('/categories/{phrase?}', [CategoryController::class, 'list'])->name('api_category_list');
Route::get('/users', [UsersController::class, 'index'])->name('api_user_list');

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/logout', [LogoutController::class, 'perform'])->name('api_logout');
});