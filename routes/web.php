<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return env('DB_DATABASE');
});
*/

/**
 * Register Routes
 */
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');
/**
 * Login Routes
 */
Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::get('/', [HomeController::class, 'index'])->name('home_index');
Route::get('/test/queue', [TestController::class, 'queue'])->name('test_queue');

Route::get('/products/{phrase?}', [ProductController::class, 'list'])->name('product_list');
Route::get('/product/show/{phrase}', [ProductController::class, 'display'])->name('product_display');
Route::get('/product/create', [ProductController::class, 'create'])->name('create_product');
Route::post('/product/save', [ProductController::class, 'save'])->name('save_product');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit_product');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('update_product');
Route::delete('/product/delete_product', [ProductController::class, 'delete_product'])->name('delete_product');
Route::get('/product/{id}/photos', [ProductController::class, 'photos'])->name('product_photos');
Route::get('/product/{id}/photos/add', [ProductController::class, 'addPhotos'])->name('product_add_photos');
Route::post('/product/photos/save', [ProductController::class, 'savePhotos'])->name('save_product_photos');

Route::get('/categories/{phrase?}', [CategoryController::class, 'list'])->name('category_list');
Route::get('/category/show/{phrase}', [CategoryController::class, 'display'])->name('category_display');
Route::get('/category/create', [CategoryController::class, 'create'])->name('create_category');
Route::post('/category/save', [CategoryController::class, 'save'])->name('save_category');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('edit_category');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('update_category');
Route::get('/category/pdf/{id}', [CategoryController::class, 'generatePDF'])->name('pdf_category');

Route::get('/contact', [ContactController::class, 'display'])->name('display_contact_form');
Route::post('/contact/sendemail', [ContactController::class, 'sendemail'])->name('send_contact_form_by_email');
Route::post('/contact/sendsms', [ContactController::class, 'sendsms'])->name('send_contact_form_by_sms');


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['middleware' => ['guest']], function () {
    });

    Route::group(['middleware' => ['auth', 'permission']], function () {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });
        /**
         * User Routes
         */
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', 'PostsController@index')->name('posts.index');
            Route::get('/create', 'PostsController@create')->name('posts.create');
            Route::post('/create', 'PostsController@store')->name('posts.store');
            Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
            Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
            Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
            Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
        });

        /**
         * Message Routes
         */
        Route::group(['prefix' => 'messages'], function () {
            Route::get('/', 'ContactController@index')->name('contact_list');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});
