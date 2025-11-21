<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PunchinController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FranchiseController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\favoriteController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\socialmedialinkController;
use App\Http\Controllers\ProductImageController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => 'api'], function ($routes) {
    Route::post('/admin-login', [AuthController::class, 'adminlogin']);
    Route::post('/user-login', [AuthController::class, 'userlogin']);
    Route::post('/register', [AuthController::class, 'register']);
 
      
});











Route::group(['middleware' => ['tokencheck.api'],  'prefix' => 'admin'], function ($routes) {

  

});

