<?php

use Illuminate\Support\Facades\{Auth, Route, Artisan};
use App\Http\Controllers\{AuthController, DashboardController, CategoryController, TagController, DesignController, RoleController, AdminController, AdminSettingsController, BottomBannerController, CommonController, CustomerController, DealerController , OrderController, ReportController, ImportExportController, MiddleBannerController, PageController, TopBannerController};

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

// Index Route
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Cache Clear Route
Route::get('config-clear', function (){
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    return redirect()->route('admin.dashboard')->with('success', 'Cache has been Cleared.');
});

// Admin Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('admin/login', 'showAdminLogin')->name('admin.login');
    Route::post('admin/do/login', 'Adminlogin')->name('admin.do.login');
    Route::get('admin/forget/password', 'showForgetPasswordForm')->name('admin.forget.password');
    Route::post('admin/forget/password', 'submitForgetPasswordForm')->name('admin.forget.password.post');
    Route::get('admin/reset/password/{token}', 'showResetPasswordForm')->name('admin.reset.password');
    Route::post('admin/reset/password', 'submitResetPasswordForm')->name('admin.reset.password.post');
});

// Admin Routes
Route::group(['prefix' => 'admin'], function ()
{
    // If User is Logged In
    Route::group(['middleware' => ['is_admin']], function ()
    {
        // Admin Index Route
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Logout Route
        Route::get('logout', [AdminController::class, function () {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        }])->name('admin.logout');

        // Dashboard
        Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');

        // Commmon Routes
        Route::post('states/cities', [CommonController::class, 'getStatesCities'])->name('states.cities');

        // Users
        Route::controller(AdminController::class)->group(function () {
            Route::get('users', 'index')->name('users.index');
            Route::get('users/load', 'load')->name('users.load');
            Route::get('users/create', 'create')->name('users.create');
            Route::post('users/store', 'store')->name('users.store');
            Route::get('users/edit/{id}', 'edit')->name('users.edit');
            Route::post('users/update', 'update')->name('users.update');
            Route::get('users/show', 'show')->name('users.show');
            Route::post('users/status', 'status')->name('users.status');
            Route::post('users/destroy', 'destroy')->name('users.destroy');
        });

        // Dealers
        Route::controller(DealerController::class)->group(function () {
            Route::get('dealers', 'index')->name('dealers.index');
            Route::get('dealers/load', 'load')->name('dealers.load');
            Route::get('dealers/create', 'create')->name('dealers.create');
            Route::post('dealers/Store', 'store')->name('dealers.store');
            Route::get('dealers/edit/{id}', 'edit')->name('dealers.edit');
            Route::post('dealers/update', 'update')->name('dealers.update');
            Route::post('dealers/status', 'status')->name('dealers.status');
            Route::post('dealers/destroy', 'destroy')->name('dealers.destroy');
        });

        // Customers
        Route::controller(CustomerController::class)->group(function () {
            Route::get('customers', 'index')->name('customers.index');
            Route::post('customers/load', 'load')->name('customers.load');
            Route::get('customers/edit/{id}', 'edit')->name('customers.edit');
            Route::post('customers/update', 'update')->name('customers.update');
            Route::post('customers/status', 'status')->name('customers.status');
        });

        // Roles
        Route::controller(RoleController::class)->group(function () {
            Route::get('roles','index')->name('roles.index');
            Route::get('roles/load','load')->name('roles.load');
            Route::get('roles/create','create')->name('roles.create');
            Route::post('roles/store','store')->name('roles.store');
            Route::get('roles/edit/{id}','edit')->name('roles.edit');
            Route::post('roles/update','update')->name('roles.update');
            Route::post('roles/destroy','destroy')->name('roles.destroy');
        });

        // Categories
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('categories.index');
            Route::post('categories/store', 'store')->name('categories.store');
            Route::post('categories/edit', 'edit')->name('categories.edit');
            Route::post('categories/update', 'update')->name('categories.update');
            Route::post('categories/status', 'status')->name('categories.status');
            Route::post('categories/destroy', 'destroy')->name('categories.destroy');
        });

        // Tags
        Route::controller(TagController::class)->group(function () {
            Route::get('tags', 'index')->name('tags.index');
            Route::get('tags/load', 'load')->name('tags.load');
            Route::post('tags/store', 'store')->name('tags.store');
            Route::post('tags/edit', 'edit')->name('tags.edit');
            Route::post('tags/update', 'update')->name('tags.update');
            Route::post('tags/status', 'status')->name('tags.status');
            Route::post('tags/header-status', 'headerStatus')->name('tags.header.status');
            Route::post('tags/destroy', 'destroy')->name('tags.destroy');
        });

        // Designs
        Route::controller(DesignController::class)->group(function () {
            Route::get('designs', 'index')->name('designs.index');
            Route::get('designs/load', 'load')->name('designs.load');
            Route::get('designs/create', 'create')->name('designs.create');
            Route::post('designs/store', 'store')->name('designs.store');
            Route::get('designs/edit/{id}', 'edit')->name('designs.edit');
            Route::post('designs/update', 'update')->name('designs.update');
            Route::post('designs/status', 'status')->name('designs.status');
            Route::post('designs/top-selling', 'topSelling')->name('designs.top-selling');
            Route::post('designs/destroy', 'destroy')->name('designs.destroy');
        });

        // Top Banners
        Route::controller(TopBannerController::class)->group(function () {
            Route::get('top-banners', 'index')->name('top-banners.index');
            Route::get('top-banners/load', 'load')->name('top-banners.load');
            Route::get('top-banners/create', 'create')->name('top-banners.create');
            Route::post('top-banners/store', 'store')->name('top-banners.store');
            Route::get('top-banners/edit/{id}', 'edit')->name('top-banners.edit');
            Route::post('top-banners/update', 'update')->name('top-banners.update');
            Route::post('top-banners/status', 'status')->name('top-banners.status');
            Route::post('top-banners/destroy', 'destroy')->name('top-banners.destroy');
        });

        // Middle Banners
        Route::controller(MiddleBannerController::class)->group(function () {
            Route::get('middle-banners', 'index')->name('middle-banners.index');
            Route::get('middle-banners/load', 'load')->name('middle-banners.load');
            Route::get('middle-banners/create', 'create')->name('middle-banners.create');
            Route::post('middle-banners/store', 'store')->name('middle-banners.store');
            Route::get('middle-banners/edit/{id}', 'edit')->name('middle-banners.edit');
            Route::post('middle-banners/update', 'update')->name('middle-banners.update');
            Route::post('middle-banners/status', 'status')->name('middle-banners.status');
            Route::post('middle-banners/destroy', 'destroy')->name('middle-banners.destroy');
        });

        // Bottom Banners
        Route::controller(BottomBannerController::class)->group(function () {
            Route::get('bottom-banners', 'index')->name('bottom-banners.index');
            Route::get('bottom-banners/load', 'load')->name('bottom-banners.load');
            Route::get('bottom-banners/create', 'create')->name('bottom-banners.create');
            Route::post('bottom-banners/store', 'store')->name('bottom-banners.store');
            Route::get('bottom-banners/edit/{id}', 'edit')->name('bottom-banners.edit');
            Route::post('bottom-banners/update', 'update')->name('bottom-banners.update');
            Route::post('bottom-banners/status', 'status')->name('bottom-banners.status');
            Route::post('bottom-banners/destroy', 'destroy')->name('bottom-banners.destroy');
        });

        // Reports
        Route::controller(ReportController::class)->group(function () {
            Route::get('reports/summary', 'summaryReport')->name('reports.summary');
            Route::get('reports/star', 'starReport')->name('reports.star');
            Route::get('reports/scheme', 'schemeReport')->name('reports.scheme');
            Route::get('reports/performance', 'performanceReport')->name('reports.performance');
            Route::get('reports/performance/load', 'loadPerformanceReport')->name('reports.performance.load');
        });

        // Orders
        Route::controller(OrderController::class)->group(function () {
            Route::get('orders', 'index')->name('orders.index');
            Route::get('orders/load', 'load')->name('orders.load');
            Route::get('orders/show/{id}', 'show')->name('orders.show');
            Route::post('orders/process', 'orderProcess')->name('orders.process');
        });

        // Import/Export
        Route::controller(ImportExportController::class)->group(function () {
            Route::get('import-export',[ImportExportController::class,'index'])->name('import.export');
            Route::post('import-designs',[ImportExportController::class,'importDesigns'])->name('import.designs');
            Route::get('export-designs',[ImportExportController::class,'exportDesigns'])->name('export.designs');
        });

        // Pages
        Route::controller(PageController::class)->group(function () {
            Route::get('pages', 'index')->name('pages.index');
            Route::get('pages/load', 'load')->name('pages.load');
            Route::get('pages/create', 'create')->name('pages.create');
            Route::post('pages/store', 'store')->name('pages.store');
            Route::get('pages/edit/{id}', 'edit')->name('pages.edit');
            Route::post('pages/update', 'update')->name('pages.update');
            Route::post('pages/status', 'status')->name('pages.status');
            Route::post('pages/destroy', 'destroy')->name('pages.destroy');
        });

        // Settings
        Route::controller(AdminSettingsController::class)->group(function () {
            Route::get('settings',  'index')->name('settings.index');
            Route::post('settings/update',  'update')->name('settings.update');
        });

    });
});
