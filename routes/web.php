<?php

use App\Http\Controllers\{AuthController,DashboardController,CategoryController,TagController, DesignController, SliderController};
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

        // Sliders
        Route::get('sliders',[SliderController::class,'index'])->name('sliders');
        Route::get('sliders/load-sliders',[SliderController::class,'loadSliders'])->name('sliders.load-sliders');
        Route::get('sliders/add/slider',[SliderController::class,'create'])->name('sliders.add-slider');
        Route::post('sliders/store/slider',[SliderController::class,'store'])->name('sliders.store-slider');
        Route::get('sliders/edit/slider/{id}',[SliderController::class,'edit'])->name('sliders.edit-slider');
        Route::post('sliders/update/slider',[SliderController::class,'update'])->name('sliders.update-slider');
        Route::post('sliders/status',[SliderController::class,'status'])->name('sliders.status');
        Route::post('sliders/destroy',[SliderController::class,'destroy'])->name('sliders.destroy');


        // Design
        Route::get('designs',[DesignController::class,'index'])->name('designs');
        Route::get('designs/load',[DesignController::class,'loaddesigns'])->name('designs.load');
        Route::get('designs/create',[DesignController::class,'create'])->name('designs.create');
        Route::post('designs/store',[DesignController::class,'store'])->name('designs.store');
        Route::get('designs/edit/{id}',[DesignController::class,'edit'])->name('designs.edit');
        Route::post('designs/update',[DesignController::class,'update'])->name('designs.update');
        Route::post('designs/status',[DesignController::class,'status'])->name('designs.status');
        Route::post('designs/image/destroy',[DesignController::class,'imagedestroy'])->name('designs-image.destroy');
        Route::post('designs/destroy',[DesignController::class,'destroy'])->name('designs.destroy');

    });
});
