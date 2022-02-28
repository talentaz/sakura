<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

//frontend
Route::get('/', [App\Http\Controllers\Frontend\FrontController::class, 'index'])->name('front.home');
Route::any('/stock', [App\Http\Controllers\Frontend\StockController::class, 'index'])->name('front.stock');
Route::get('/select_port', [App\Http\Controllers\Frontend\StockController::class, 'select_port'])->name('front.select_port');
Route::get('/details/{id}', [App\Http\Controllers\Frontend\StockController::class, 'details'])->name('front.details');
Route::get('/details/image_download/{id}', [App\Http\Controllers\Frontend\StockController::class, 'image_download'])->name('front.details.image_download');
Route::get('/contact_us', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('front.contact');
Route::post('/contact_us/email', [App\Http\Controllers\Frontend\ContactController::class, 'contactEmail'])->name('front.contact.email');
Route::get('/company', [App\Http\Controllers\Frontend\ContactController::class, 'company'])->name('front.company');
Route::get('/agents', [App\Http\Controllers\Frontend\ContactController::class, 'agents'])->name('front.agents');
Route::get('/gallery', [App\Http\Controllers\Frontend\ContactController::class, 'gallery'])->name('front.gallery');
Route::get('/payment', [App\Http\Controllers\Frontend\ContactController::class, 'payment'])->name('front.payment');
Route::get('/blog', [App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('front.blog');
Route::get('/blog/{id}', [App\Http\Controllers\Frontend\BlogController::class, 'details'])->name('front.blog.detail');

Route::group(['prefix' => 'user'], function(){
    Route::get('/login', [App\Http\Controllers\Frontend\UserController::class, 'login'])->name('front.user.login');
    Route::post('/login_post', [App\Http\Controllers\Frontend\UserController::class, 'login_post'])->name('front.user.login_post');
    Route::get('/signup', [App\Http\Controllers\Frontend\UserController::class, 'signup'])->name('front.user.signup');
    Route::post('/signup_post', [App\Http\Controllers\Frontend\UserController::class, 'signup_post'])->name('front.user.signup_post');
});
Route::prefix('/user')->middleware(['auth:web', 'CustomerRole'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Frontend\UserController::class, 'dashboard'])->name('front.user.dashboard');
});
Route::get('/clear', [App\Http\Controllers\Frontend\FrontController::class, 'clear'])->name('front.clear');

// admin dashboard
Route::prefix('/admin')->middleware(['auth:web', 'Admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    Route::group(['prefix' => 'user'], function(){
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
        Route::get('/{id}/change_passowrd', [App\Http\Controllers\Admin\UserController::class, 'change_password'])->name('admin.user.change_password');
        Route::post('/updatePassword', [App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('admin.user.updatePassword');
        Route::post('/delete', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin.user.delete');
    });
    Route::group(['prefix' => 'vehicle'], function(){
        Route::get('/', [App\Http\Controllers\Admin\VehicleController::class, 'index'])->name('admin.vehicle.index');
        Route::get('/rate', [App\Http\Controllers\Admin\VehicleController::class, 'rate'])->name('admin.vehicle.rate');
        Route::post('/rate_post', [App\Http\Controllers\Admin\VehicleController::class, 'rate_post'])->name('admin.vehicle.rate_post');
        Route::get('/create', [App\Http\Controllers\Admin\VehicleController::class, 'create'])->name('admin.vehicle.create');
        Route::post('/create_post', [App\Http\Controllers\Admin\VehicleController::class, 'create_post'])->name('admin.vehicle.create_post');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\VehicleController::class, 'edit'])->name('admin.vehicle.edit');
        Route::post('/edit_post/{id}', [App\Http\Controllers\Admin\VehicleController::class, 'edit_post'])->name('admin.vehicle.edit_post');
        Route::post('/imageDelete', [App\Http\Controllers\Admin\VehicleController::class, 'imageDelete'])->name('admin.vehicle.imageDelete');
        Route::post('/imageAdd', [App\Http\Controllers\Admin\VehicleController::class, 'imageAdd'])->name('admin.vehicle.imageAdd');
        Route::get('/delete', [App\Http\Controllers\Admin\VehicleController::class, 'delete'])->name('admin.vehicle.delete');
    });

    Route::group(['prefix' => 'customer'], function(){
        Route::get('/', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customer.index');
        Route::get('/add', [App\Http\Controllers\Admin\CustomerController::class, 'add'])->name('admin.customer.add');
        Route::post('/add_post', [App\Http\Controllers\Admin\CustomerController::class, 'add_post'])->name('admin.customer.add_post');
        Route::get('/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('admin.customer.edit');
        Route::post('/edit_post', [App\Http\Controllers\Admin\CustomerController::class, 'edit_post'])->name('admin.customer.edit_post');
    });
    Route::group(['prefix' => 'port'], function(){
        Route::get('/', [App\Http\Controllers\Admin\PortController::class, 'index'])->name('admin.port.index');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\PortController::class, 'edit'])->name('admin.port.edit');
        Route::post('/edit_post', [App\Http\Controllers\Admin\PortController::class, 'edit_post'])->name('admin.port.edit_post');
    });
    Route::group(['prefix' => 'news'], function(){
        Route::get('/', [App\Http\Controllers\Admin\NewsController::class, 'index'])->name('admin.news.index');
        Route::get('/add', [App\Http\Controllers\Admin\NewsController::class, 'add'])->name('admin.news.add');
        Route::post('/add_post', [App\Http\Controllers\Admin\NewsController::class, 'add_post'])->name('admin.news.add_post');
        Route::get('/edit', [App\Http\Controllers\Admin\NewsController::class, 'edit'])->name('admin.news.edit');
        Route::post('/edit_post', [App\Http\Controllers\Admin\NewsController::class, 'edit_post'])->name('admin.news.edit_post');
        Route::get('/delete', [App\Http\Controllers\Admin\NewsController::class, 'delete'])->name('admin.news.delete');
    });
    Route::get('/edit_profile', [App\Http\Controllers\Admin\AdminController::class, 'edit_profile'])->name('admin.edit_profile');
    Route::post('/update_profile', [App\Http\Controllers\Admin\AdminController::class, 'update_profile'])->name('admin.update_profile');
});


//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
