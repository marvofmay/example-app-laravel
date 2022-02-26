<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
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

Route::post('/login', [LoginController::class, 'login'])->name('api_login');
Route::get('/categories/{id?}', [CategoryController::class, 'categories'])->name('api_categories');
Route::get('/products/{id?}', [ProductController::class, 'products'])->name('api_products');

//Route::get('/users', [UsersController::class, 'index'])->name('api_user_list');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [LogoutController::class, 'perform'])->name('api_logout');    
    
    Route::post('/categories', [CategoryController::class, 'create'])->name('api_category_create');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('api_category_update');
    Route::delete('/categories/{id}', [CategoryController::class, 'delete'])->name('api_category_delete'); 
    
    Route::post('/products', [ProductController::class, 'create'])->name('api_product_create'); 
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('api_product_update'); 
    Route::delete('/products/{id}', [ProductController::class, 'delete'])->name('api_product_delete');
});
