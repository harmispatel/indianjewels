<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    CategoryController,
    TagController,
    DesignController,
    SliderController,
    RoleController,
    AdminController,
    AdminSettingsController,
    BottomBannerController,
    CommonController,
    CustomerController,
    DealerController,
    WestageDiscountController ,
    OrderController,
    ReportController,
    ImportExportController,
    MiddleBannerController,
    PageController,
    TopBannerController
};
use Illuminate\Support\Facades\Auth;

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
        Route::get('top-banners',[TopBannerController::class,'index'])->name('top-banners');
        Route::get('top-banners/load',[TopBannerController::class,'loadTopBanners'])->name('top-banners.load');
        Route::get('top-banners/create',[TopBannerController::class,'create'])->name('top-banners.create');
        Route::post('top-banners/store',[TopBannerController::class,'store'])->name('top-banners.store');
        Route::get('top-banners/edit/{id}',[TopBannerController::class,'edit'])->name('top-banners.edit');
        Route::post('top-banners/update',[TopBannerController::class,'update'])->name('top-banners.update');
        Route::post('top-banners/status',[TopBannerController::class,'status'])->name('top-banners.status');
        Route::post('top-banners/destroy',[TopBannerController::class,'destroy'])->name('top-banners.destroy');

        // Middle Banners
        Route::get('middle-banners',[MiddleBannerController::class,'index'])->name('middle-banners');
        Route::get('middle-banners/load',[MiddleBannerController::class,'loadMiddleBanners'])->name('middle-banners.load');
        Route::get('middle-banners/create',[MiddleBannerController::class,'create'])->name('middle-banners.create');
        Route::post('middle-banners/store',[MiddleBannerController::class,'store'])->name('middle-banners.store');
        Route::get('middle-banners/edit/{id}',[MiddleBannerController::class,'edit'])->name('middle-banners.edit');
        Route::post('middle-banners/update',[MiddleBannerController::class,'update'])->name('middle-banners.update');
        Route::post('middle-banners/status',[MiddleBannerController::class,'status'])->name('middle-banners.status');
        Route::post('middle-banners/destroy',[MiddleBannerController::class,'destroy'])->name('middle-banners.destroy');

        // Bottom Banners
        Route::get('bottom-banners',[BottomBannerController::class,'index'])->name('bottom-banners');
        Route::get('bottom-banners/load',[BottomBannerController::class,'loadBottomBanners'])->name('bottom-banners.load');
        Route::get('bottom-banners/create',[BottomBannerController::class,'create'])->name('bottom-banners.create');
        Route::post('bottom-banners/store',[BottomBannerController::class,'store'])->name('bottom-banners.store');
        Route::get('bottom-banners/edit/{id}',[BottomBannerController::class,'edit'])->name('bottom-banners.edit');
        Route::post('bottom-banners/update',[BottomBannerController::class,'update'])->name('bottom-banners.update');
        Route::post('bottom-banners/status',[BottomBannerController::class,'status'])->name('bottom-banners.status');
        Route::post('bottom-banners/destroy',[BottomBannerController::class,'destroy'])->name('bottom-banners.destroy');

        // westage Discount
        Route::get('westage-discount',[WestageDiscountController::class,'index'])->name('westage.discount');
        Route::get('westage-discount/load',[WestageDiscountController::class,'loaddiscount'])->name('westage.discount.load');
        Route::get('westage-discount/create',[WestageDiscountController::class,'create'])->name('westage.discount.create');
        Route::post('westage-discount/store',[WestageDiscountController::class,'store'])->name('westage.discount.store');
        Route::get('westage-discount/edit/{id}',[WestageDiscountController::class,'edit'])->name('westage.discount.edit');
        Route::post('westage-discount/update',[WestageDiscountController::class,'update'])->name('westage.discount.update');
        Route::post('westage-discount/status',[WestageDiscountController::class,'status'])->name('westage.discount.status');
        Route::post('westage-discount/destroy',[WestageDiscountController::class,'destroy'])->name('westage.discount.destroy');

        // Reports
        Route::get('summary-items', [ReportController::class,'summaryitemsindex'])->name('reports.summary.items');
        Route::get('star-reports', [ReportController::class,'starreportindex'])->name('reports.star');
        Route::get('scheme-reports', [ReportController::class,'schemereportindex'])->name('reports.scheme');
        Route::get('dealer-performance', [ReportController::class,'dealerperrformanceindex'])->name('reports.dealer.performace');

        // Orders
        Route::get('orders', [OrderController::class,'index'])->name('order');

        // Import/Export
        Route::get('import-export',[ImportExportController::class,'index'])->name('import.export');
        Route::post('import-designs',[ImportExportController::class,'importDesigns'])->name('import.designs');
        Route::get('export-designs',[ImportExportController::class,'exportDesigns'])->name('export.designs');

        // Pages
        Route::get('pages',[PageController::class, 'index'])->name('pages');
        Route::get('pages/load',[PageController::class, 'loadPages'])->name('pages.load');
        Route::get('pages/create',[PageController::class, 'create'])->name('pages.create');
        Route::post('pages/store',[PageController::class, 'store'])->name('pages.store');
        Route::get('pages/edit/{id}',[PageController::class, 'edit'])->name('pages.edit');
        Route::post('pages/update',[PageController::class, 'update'])->name('pages.update');
        Route::post('pages/status',[PageController::class, 'status'])->name('pages.status');
        Route::post('pages/destroy',[PageController::class, 'destroy'])->name('pages.destroy');

        // Settings
        Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings');
        Route::post('settings/update', [AdminSettingsController::class, 'update'])->name('settings.update');

    });
});
