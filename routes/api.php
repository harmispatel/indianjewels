<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController\{CustomerApiController,AuthApiController};

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


Route::get('parent-category', [CustomerApiController::class, 'getParentCategories']);
Route::post('sub-category',[CustomerApiController::class,'getSubCategories']);
Route::get('flash-design', [CustomerApiController::class,'getFlashDesign']);
Route::get('highest-selling-designs', [CustomerApiController::class, 'getHigestSellingDesigns']);
Route::get('latest-designs', [CustomerApiController::class, 'getLatestDesign']);
Route::get('banners',[CustomerApiController::class,'getAllBanners']);
Route::post('design-detail',[CustomerApiController::class,'getDesignDetail']);
Route::post('designs',[CustomerApiController::class,'getDesigns']);
Route::post('alldesigns',[CustomerApiController::class,'getalldesigns']);


Route::get('metal',[CustomerApiController::class,'getMetal']);
Route::get('gender',[CustomerApiController::class,'getGender']);
Route::get('tags',[CustomerApiController::class,'getTags']);
Route::get('child-category',[CustomerApiController::class,'getChildCategories']);
Route::post('filter-design',[CustomerApiController::class,'filterDesign']);
Route::post('related-designs',[CustomerApiController::class,'relatedDesigns']);
Route::post('user-login',[AuthApiController::class,'userlogin']);

Route::post('profile',[CustomerApiController::class,'profile']);
Route::post('update-profile',[CustomerApiController::class,'updateProfile'])->middleware('auth:api');

Route::post('add-collection-design',[CustomerApiController::class,'dealerAddCollectionDesign']);
Route::post('remove-collection-design',[CustomerApiController::class,'dealerRemoveCollectionDesign']);
Route::post('list-collection-design',[CustomerApiController::class,'listCollectionDesign']);
Route::post('alldesigns-collection',[CustomerApiController::class,'getalldesignscollection']);

Route::post('add-user-wishlist',[CustomerApiController::class,'userAddWishlist']);
Route::post('remove-user-wishlist',[CustomerApiController::class,'userReomveWishlist']);
Route::post('login',[AuthApiController::class,'login']);
Route::post('user-profile',[CustomerApiController::class,'userProfile']);
Route::post('update-user-profile',[CustomerApiController::class,'updateUserProfile']);
Route::post('upload-user-image',[CustomerApiController::class, 'uploadUserImage']);
Route::post('user-wishlist',[CustomerApiController::class,'getuserWishlist']);
Route::post('dealer/cart-store',[CustomerApiController::class,'delaerCartStore']);
Route::post('dealer/cart-list',[CustomerApiController::class,'dealerCartList']);
Route::post('dealer/cart-remove',[CustomerApiController::class,'dealerCartRemove']);
Route::post('dealer/order-store',[CustomerApiController::class,'dealerOrderStore']);
Route::post('dealer/order-list',[CustomerApiController::class,'dealerOrderList']);

Route::post('user/cart-store',[CustomerApiController::class,'userCartStore']);
Route::post('user/cart-list',[CustomerApiController::class,'userCartList']);
Route::post('user/cart-update',[CustomerApiController::class,'userCartUpdate']);
Route::post('user/cart-remove',[CustomerApiController::class,'userCartRemove']);
Route::post('user/purchase-order',[CustomerApiController::class,'userPurchaseOrder']);

Route::post('state/cities',[CustomerApiController::class,'getStateCities']);

Route::get('header-tags', [CustomerApiController::class, 'getHeaderTags']);
Route::post('apply-dealer-code',[CustomerApiController::class, 'applyDealerCode']);
Route::post('custom-pages',[CustomerApiController::class, 'customPages']);
Route::get('site-settings', [CustomerApiController::class, 'getSiteSettings']);

Route::post('order-details', [CustomerApiController::class, 'orderDetails']);
Route::post('my-orders', [CustomerApiController::class, 'myOrders']);

Route::post('forget-password', [AuthApiController::class, 'forgetPassword']);
Route::post('reset-password', [AuthApiController::class, 'resetPassword']);
