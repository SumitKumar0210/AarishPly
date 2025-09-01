<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Modules\Master\UserTypeController;
use App\Http\Controllers\Admin\Modules\Master\DepartmentController;
use App\Http\Controllers\Admin\Modules\Master\GroupController;
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
   
    

});
