<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController\CustomerApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('parent-category', [CustomerApiController::class, 'getParentCategories']);
Route::post('sub-category',[CustomerApiController::class,'getSubCategories']);
Route::get('flash-design', [CustomerApiController::class,'getFlashDesign']);

Route::get('highest-selling-designs', [CustomerApiController::class, 'getHigestSellingDesigns']);
Route::get('latest-designs', [CustomerApiController::class, 'getLatestDesign']);
Route::get('slider',[CustomerApiController::class,'getSlider']);
Route::post('design-detail',[CustomerApiController::class,'getDesignDetail']);
Route::post('designs',[CustomerApiController::class,'getDesigns']);

