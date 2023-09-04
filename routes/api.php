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
Route::get('slider',[CustomerApiController::class,'getSlider']);
Route::post('design-detail',[CustomerApiController::class,'getDesignDetail']);
Route::post('designs',[CustomerApiController::class,'getDesigns']);
Route::get('alldesigns',[CustomerApiController::class,'getalldesigns']);


Route::get('metal',[CustomerApiController::class,'getMetal']);
Route::get('gender',[CustomerApiController::class,'getGender']);
Route::get('tags',[CustomerApiController::class,'getTags']);
Route::get('child-category',[CustomerApiController::class,'getChildCategories']);
Route::post('filter-design',[CustomerApiController::class,'filterDesign']);
Route::post('related-designs',[CustomerApiController::class,'relatedDesigns']);
Route::post('user-login',[AuthApiController::class,'userlogin']);
