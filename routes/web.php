<?php

use App\Http\Controllers\{AuthController,DashboardController,CategoryController,TagController};
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', function () {
    return view('welcome');
});

// Cache Clear Route
Route::get('config-clear', function ()
{
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    return redirect()->route('admin.dashboard');
});

// Admin Auth Routes
Route::get('admin/login', [AuthController::class,'showAdminLogin'])->name('admin.login');
Route::post('admin/do/login', [AuthController::class,'Adminlogin'])->name('admin.do.login');

// Admin Routes
Route::group(['prefix' => 'admin'], function ()
{
    // If Auth Login
    Route::group(['middleware' => ['is_admin']], function ()
    {
        // Dashboard
        Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');

        // Logout Route
        Route::get('logout', [AuthController::class,'AdminLogout'])->name('admin.logout');

        //Categories Route
        Route::get('/categories',[CategoryController::class,'index'])->name('admin.categories');
        Route::get('categories/load-categories',[CategoryController::class,'loadCategories'])->name('categories.load-categories');
        Route::get('categories/add/category',[CategoryController::class,'create'])->name('categories.add-category');
        Route::post('categories/store/category',[CategoryController::class,'store'])->name('categories.store-category');
        Route::get('categories/edit/category/{id}',[CategoryController::class,'edit'])->name('categories.edit-category');
        Route::post('categories/update/category',[CategoryController::class,'update'])->name('categories.update-category');
        Route::post('categories/status',[CategoryController::class,'status'])->name('categories.status');
        Route::post('categories/destroy',[CategoryController::class,'destroy'])->name('categories.destroy');
        
        // Tag
        Route::get('tags',[TagController::class,'index'])->name('tags');
        Route::get('tags/load',[TagController::class,'loadtags'])->name('tags.load');
        Route::get('tags/create',[TagController::class,'create'])->name('tags.create');
        Route::post('tags/store',[TagController::class,'store'])->name('tags.store');
        Route::get('tags/edit/{id}',[TagController::class,'edit'])->name('tags.edit');
        Route::post('tags/update',[TagController::class,'update'])->name('tags.update');
        Route::post('tags/status',[TagController::class,'status'])->name('tags.status');
        Route::post('tags/destroy',[TagController::class,'destroy'])->name('tags.destroy');
    });
});
