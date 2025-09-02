<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\Modules\Master\UserTypeController;
use App\Http\Controllers\Admin\Modules\Master\DepartmentController;
use App\Http\Controllers\Admin\Modules\Master\GradeController;
use App\Http\Controllers\Admin\Modules\Master\GroupController;
use App\Http\Controllers\Admin\Modules\Master\CategoryController;
use App\Http\Controllers\Admin\Modules\Master\VendorController;
use App\Http\Controllers\Admin\Modules\Master\UnitOfMeasurementController;
use App\Http\Controllers\Admin\Modules\Master\MaterialController;
use App\Http\Controllers\Admin\Modules\Master\ProductController;
use App\Http\Controllers\Admin\Modules\Master\ProductUnitMaterialController;
use App\Http\Controllers\Admin\Modules\Master\LabourController;
use App\Http\Controllers\Admin\Modules\Master\CustomerController;
use App\Http\Controllers\Admin\Modules\Master\SalesUserController;
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

Route::post('test', function(){
    return response()->json(['message' => 'This is a test endpoint']);
});
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('update-password/{id}', [AuthController::class, 'updatePassword']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['api', 'check.jwt'],'prefix' => 'auth'], function ($router) {
    
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);


});

// Admin Master Data
Route::group(['middleware' => ['api', 'check.jwt'],'prefix' => 'admin'], function ($router) {
    
    Route::group(['prefix' => 'userType'], function ($router) {
        Route::get('get-data', [UserTypeController::class, 'getUserType']);
        Route::post('store', [UserTypeController::class, 'store']);
        Route::post('edit/{id}', [UserTypeController::class, 'edit']);
        Route::post('update/{id}', [UserTypeController::class, 'update']);
        Route::post('delete/{id}', [UserTypeController::class, 'delete']);
    });


    Route::group(['prefix' => 'department'], function ($router) {
        Route::get('get-data', [DepartmentController::class, 'getData']);
        Route::post('store', [DepartmentController::class, 'store']);
        Route::post('edit/{id}', [DepartmentController::class, 'edit']);
        Route::post('update/{id}', [DepartmentController::class, 'update']);
        Route::post('delete/{id}', [DepartmentController::class, 'delete']);
    });


    Route::group(['prefix' => 'group'], function ($router) {
        Route::get('get-data', [GroupController::class, 'getData']);
        Route::post('store', [GroupController::class, 'store']);
        Route::post('edit/{id}', [GroupController::class, 'edit']);
        Route::post('update/{id}', [GroupController::class, 'update']);
        Route::post('delete/{id}', [GroupController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'grade'], function ($router) {
        Route::get('get-data', [GradeController::class, 'getData']);
        Route::post('store', [GradeController::class, 'store']);
        Route::post('edit/{id}', [GradeController::class, 'edit']);
        Route::post('update/{id}', [GradeController::class, 'update']);
        Route::post('delete/{id}', [GradeController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'category'], function ($router) {
        Route::get('get-data', [CategoryController::class, 'getData']);
        Route::post('store', [CategoryController::class, 'store']);
        Route::post('edit/{id}', [CategoryController::class, 'edit']);
        Route::post('update/{id}', [CategoryController::class, 'update']);
        Route::post('delete/{id}', [CategoryController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'vendor'], function ($router) {
        Route::get('get-data', [VendorController::class, 'getData']);
        Route::post('store', [VendorController::class, 'store']);
        Route::post('edit/{id}', [VendorController::class, 'edit']);
        Route::post('update/{id}', [VendorController::class, 'update']);
        Route::post('delete/{id}', [VendorController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'unit'], function ($router) {
        Route::get('get-data', [UnitOfMeasurementController::class, 'getData']);
        Route::post('store', [UnitOfMeasurementController::class, 'store']);
        Route::post('edit/{id}', [UnitOfMeasurementController::class, 'edit']);
        Route::post('update/{id}', [UnitOfMeasurementController::class, 'update']);
        Route::post('delete/{id}', [UnitOfMeasurementController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'material'], function ($router) {
        Route::get('get-data', [MaterialController::class, 'getData']);
        Route::post('store', [MaterialController::class, 'store']);
        Route::post('edit/{id}', [MaterialController::class, 'edit']);
        Route::post('update/{id}', [MaterialController::class, 'update']);
        Route::post('delete/{id}', [MaterialController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'product'], function ($router) {
        Route::get('get-data', [ProductController::class, 'getData']);
        Route::post('store', [ProductController::class, 'store']);
        Route::post('edit/{id}', [ProductController::class, 'edit']);
        Route::post('update/{id}', [ProductController::class, 'update']);
        Route::post('delete/{id}', [ProductController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'product-unit-material'], function ($router) {
        Route::get('get-data', [ProductUnitMaterialController::class, 'getData']);
        Route::post('store', [ProductUnitMaterialController::class, 'store']);
        Route::post('edit/{id}', [ProductUnitMaterialController::class, 'edit']);
        Route::post('update/{id}', [ProductUnitMaterialController::class, 'update']);
        Route::post('delete/{id}', [ProductUnitMaterialController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'labour'], function ($router) {
        Route::get('get-data', [LabourController::class, 'getData']);
        Route::post('store', [LabourController::class, 'store']);
        Route::post('edit/{id}', [LabourController::class, 'edit']);
        Route::post('update/{id}', [LabourController::class, 'update']);
        Route::post('delete/{id}', [LabourController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'customer'], function ($router) {
        Route::get('get-data', [CustomerController::class, 'getData']);
        Route::post('store', [CustomerController::class, 'store']);
        Route::post('edit/{id}', [CustomerController::class, 'edit']);
        Route::post('update/{id}', [CustomerController::class, 'update']);
        Route::post('delete/{id}', [CustomerController::class, 'delete']);
    });
   
    
    Route::group(['prefix' => 'sales-user'], function ($router) {
        Route::get('get-data', [SalesUserController::class, 'getData']);
        Route::post('store', [SalesUserController::class, 'store']);
        Route::post('edit/{id}', [SalesUserController::class, 'edit']);
        Route::post('update/{id}', [SalesUserController::class, 'update']);
        Route::post('delete/{id}', [SalesUserController::class, 'delete']);
    });
   
    

});
