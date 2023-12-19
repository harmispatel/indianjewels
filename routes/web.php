<?php

use App\Http\Controllers\{AuthController,DashboardController,CategoryController,TagController, DesignController, SliderController, RoleController, AdminController, AdminSettingsController, BottomBannerController, CommonController, CustomerController, DealerController,WestageDiscountController , OrderController, ReportController, ImportExportController, MiddleBannerController, PageController, TopBannerController};
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
    // return view('welcome');
    return redirect()->route('admin.login');
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
Route::get('admin/forget/password',[AuthController::class,'showForgetPasswordForm'])->name('admin.forget.password');
Route::post('admin/forget/password',[AuthController::class,'submitForgetPasswordForm'])->name('admin.forget.password.post');
Route::get('admin/reset/password/{token}',[AuthController::class,'showResetPasswordForm'])->name('admin.reset.password');
Route::post('admin/reset/password',[AuthController::class,'submitResetPasswordForm'])->name('admin.reset.password.post');

// Admin Routes
Route::group(['prefix' => 'admin'], function ()
{
    // If Auth Login
    Route::group(['middleware' => ['is_admin']], function ()
    {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Logout Route
        Route::get('logout', [AdminController::class,'AdminLogout'])->name('admin.logout');

        // Dashboard
        Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');

        // Commmon Routes
        Route::post('states/cities', [CommonController::class, 'getStatesCities'])->name('states.cities');

        // Users
        Route::get('users',[AdminController::class,'index'])->name('users');
        Route::get('users/load',[AdminController::class,'loadUsers'])->name('users.load');
        Route::get('users/create',[AdminController::class,'create'])->name('users.create');
        Route::post('users/store',[AdminController::class,'store'])->name('users.store');
        Route::post('users/status',[AdminController::class,'status'])->name('users.status');
        Route::post('users/update',[AdminController::class,'update'])->name('users.update');
        Route::get('users/edit/{id}',[AdminController::class,'edit'])->name('users.edit');
        Route::post('users/destroy',[AdminController::class,'destroy'])->name('users.destroy');

        // Dealers
        Route::get('dealers',[DealerController::class,'index'])->name('dealers');
        Route::get('dealers/load',[DealerController::class,'loaddealers'])->name('dealers.load');
        Route::get('dealers/create',[DealerController::class,'create'])->name('dealers.create');
        Route::post('dealers/Store',[DealerController::class,'store'])->name('dealers.store');
        Route::get('dealers/edit/{id}',[DealerController::class,'edit'])->name('dealers.edit');
        Route::post('dealers/status',[DealerController::class,'status'])->name('dealers.status');
        Route::post('dealers/update',[DealerController::class,'update'])->name('dealers.update');
        Route::post('dealers/destroy',[DealerController::class,'destroy'])->name('dealers.destroy');

        // Customers
        Route::get('customers',[CustomerController::class,'index'])->name('customers');
        Route::post('customers/load',[CustomerController::class,'loadCustomers'])->name('customers.load');
        Route::get('customers/edit/{id}',[CustomerController::class,'edit'])->name('customers.edit');
        Route::post('customers/status',[CustomerController::class,'status'])->name('customers.status');
        Route::post('customers/update',[CustomerController::class,'update'])->name('customers.update');

        // Categories
        Route::get('/categories',[CategoryController::class,'index'])->name('categories');
        Route::get('categories/load',[CategoryController::class,'loadCategories'])->name('categories.load');
        Route::get('categories/add',[CategoryController::class,'create'])->name('categories.add');
        Route::post('categories/store',[CategoryController::class,'store'])->name('categories.store');
        Route::post('categories/edit',[CategoryController::class,'edit'])->name('categories.edit');
        Route::post('categories/update',[CategoryController::class,'update'])->name('categories.update');
        Route::post('categories/status',[CategoryController::class,'status'])->name('categories.status');
        Route::post('categories/destroy',[CategoryController::class,'destroy'])->name('categories.destroy');

        // Roles
        Route::get('roles',[RoleController::class,'index'])->name('roles');
        Route::get('roles/create',[RoleController::class,'create'])->name('roles.create');
        Route::post('roles/store',[RoleController::class,'store'])->name('roles.store');
        Route::get('roles/edit/{id}',[RoleController::class,'edit'])->name('roles.edit');
        Route::post('roles/update',[RoleController::class,'update'])->name('roles.update');
        Route::post('roles/destroy',[RoleController::class,'destroy'])->name('roles.destroy');

        // Tags
        Route::get('tags',[TagController::class,'index'])->name('tags');
        Route::get('tags/load',[TagController::class,'loadtags'])->name('tags.load');
        Route::get('tags/create',[TagController::class,'create'])->name('tags.create');
        Route::post('tags/store',[TagController::class,'store'])->name('tags.store');
        Route::post('tags/edit',[TagController::class,'edit'])->name('tags.edit');
        Route::post('tags/update',[TagController::class,'update'])->name('tags.update');
        Route::post('tags/status',[TagController::class,'status'])->name('tags.status');
        Route::post('tags/destroy',[TagController::class,'destroy'])->name('tags.destroy');
        Route::post('tags/display-header/status',[TagController::class,'displayHeaderStatus'])->name('tags.display_header_status');

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
        Route::post('designs/top-selling',[DesignController::class,'topSelling'])->name('designs.top-selling');

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
