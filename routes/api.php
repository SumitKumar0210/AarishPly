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
use App\Http\Controllers\Admin\Modules\Master\MachineController;
use App\Http\Controllers\Admin\Modules\Master\BranchController;
use App\Http\Controllers\Admin\Modules\Master\StockController;
use App\Http\Controllers\Admin\Modules\Purchaese\PurchaseOrderController;
use App\Http\Controllers\Admin\Modules\Purchaese\PurchaseInwardLogController;
use App\Http\Controllers\Admin\Modules\Purchaese\PurchaseMaterialController;
use App\Http\Controllers\Admin\Modules\Quotation\QuotationOrderController;
use App\Http\Controllers\Admin\Modules\Quotation\QuotationProductController;
use App\Http\Controllers\Admin\Modules\Production\ProductionOrderController;
use App\Http\Controllers\Admin\Modules\HandToolController;
use App\Http\Controllers\Admin\Modules\MachineOperatorController;
use App\Http\Controllers\Admin\Modules\SalesReturnController;
use App\Http\Controllers\Admin\Modules\MaintenanceLogController;
use App\Http\Controllers\Admin\Modules\TentativeItemController;
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
        Route::post('status-update', [UserTypeController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'department'], function ($router) {
        Route::get('get-data', [DepartmentController::class, 'getData']);
        Route::post('store', [DepartmentController::class, 'store']);
        Route::post('edit/{id}', [DepartmentController::class, 'edit']);
        Route::post('update/{id}', [DepartmentController::class, 'update']);
        Route::post('delete/{id}', [DepartmentController::class, 'delete']);
        Route::post('status-update', [DepartmentController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'group'], function ($router) {
        Route::get('get-data', [GroupController::class, 'getData']);
        Route::post('store', [GroupController::class, 'store']);
        Route::post('edit/{id}', [GroupController::class, 'edit']);
        Route::post('update/{id}', [GroupController::class, 'update']);
        Route::post('delete/{id}', [GroupController::class, 'delete']);
        Route::post('status-update', [GroupController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'grade'], function ($router) {
        Route::get('get-data', [GradeController::class, 'getData']);
        Route::post('store', [GradeController::class, 'store']);
        Route::post('edit/{id}', [GradeController::class, 'edit']);
        Route::post('update/{id}', [GradeController::class, 'update']);
        Route::post('delete/{id}', [GradeController::class, 'delete']);
        Route::post('status-update', [GradeController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'category'], function ($router) {
        Route::get('get-data', [CategoryController::class, 'getData']);
        Route::post('store', [CategoryController::class, 'store']);
        Route::post('edit/{id}', [CategoryController::class, 'edit']);
        Route::post('update/{id}', [CategoryController::class, 'update']);
        Route::post('delete/{id}', [CategoryController::class, 'delete']);
        Route::post('status-update', [CategoryController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'vendor'], function ($router) {
        Route::get('get-data', [VendorController::class, 'getData']);
        Route::post('store', [VendorController::class, 'store']);
        Route::post('edit/{id}', [VendorController::class, 'edit']);
        Route::post('update/{id}', [VendorController::class, 'update']);
        Route::post('delete/{id}', [VendorController::class, 'delete']);
        Route::post('status-update', [VendorController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'unit'], function ($router) {
        Route::get('get-data', [UnitOfMeasurementController::class, 'getData']);
        Route::post('store', [UnitOfMeasurementController::class, 'store']);
        Route::post('edit/{id}', [UnitOfMeasurementController::class, 'edit']);
        Route::post('update/{id}', [UnitOfMeasurementController::class, 'update']);
        Route::post('delete/{id}', [UnitOfMeasurementController::class, 'delete']);
        Route::post('status-update', [UnitOfMeasurementController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'material'], function ($router) {
        Route::get('get-data', [MaterialController::class, 'getData']);
        Route::post('store', [MaterialController::class, 'store']);
        Route::post('edit/{id}', [MaterialController::class, 'edit']);
        Route::post('update/{id}', [MaterialController::class, 'update']);
        Route::post('delete/{id}', [MaterialController::class, 'delete']);
        Route::post('status-update', [MaterialController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'product'], function ($router) {
        Route::get('get-data', [ProductController::class, 'getData']);
        Route::post('store', [ProductController::class, 'store']);
        Route::post('edit/{id}', [ProductController::class, 'edit']);
        Route::post('update/{id}', [ProductController::class, 'update']);
        Route::post('delete/{id}', [ProductController::class, 'delete']);
        Route::post('status-update', [ProductController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'product-unit-material'], function ($router) {
        Route::get('get-data', [ProductUnitMaterialController::class, 'getData']);
        Route::post('store', [ProductUnitMaterialController::class, 'store']);
        Route::post('edit/{id}', [ProductUnitMaterialController::class, 'edit']);
        Route::post('update/{id}', [ProductUnitMaterialController::class, 'update']);
        Route::post('delete/{id}', [ProductUnitMaterialController::class, 'delete']);
        Route::post('status-update', [ProductUnitMaterialController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'labour'], function ($router) {
        Route::get('get-data', [LabourController::class, 'getData']);
        Route::post('store', [LabourController::class, 'store']);
        Route::post('edit/{id}', [LabourController::class, 'edit']);
        Route::post('update/{id}', [LabourController::class, 'update']);
        Route::post('delete/{id}', [LabourController::class, 'delete']);
        Route::post('status-update', [LabourController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'customer'], function ($router) {
        Route::get('get-data', [CustomerController::class, 'getData']);
        Route::post('store', [CustomerController::class, 'store']);
        Route::post('edit/{id}', [CustomerController::class, 'edit']);
        Route::post('update/{id}', [CustomerController::class, 'update']);
        Route::post('delete/{id}', [CustomerController::class, 'delete']);
        Route::post('status-update', [CustomerController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'sales-user'], function ($router) {
        Route::get('get-data', [SalesUserController::class, 'getData']);
        Route::post('store', [SalesUserController::class, 'store']);
        Route::post('edit/{id}', [SalesUserController::class, 'edit']);
        Route::post('update/{id}', [SalesUserController::class, 'update']);
        Route::post('delete/{id}', [SalesUserController::class, 'delete']);
        Route::post('status-update', [SalesUserController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'machine'], function ($router) {
        Route::get('get-data', [MachineController::class, 'getData']);
        Route::post('store', [MachineController::class, 'store']);
        Route::post('edit/{id}', [MachineController::class, 'edit']);
        Route::post('update/{id}', [MachineController::class, 'update']);
        Route::post('delete/{id}', [MachineController::class, 'delete']);
        Route::post('status-update', [MachineController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'branch'], function ($router) {
        Route::get('get-data', [BranchController::class, 'getData']);
        Route::post('store', [BranchController::class, 'store']);
        Route::post('edit/{id}', [BranchController::class, 'edit']);
        Route::post('update/{id}', [BranchController::class, 'update']);
        Route::post('delete/{id}', [BranchController::class, 'delete']);
        Route::post('status-update', [BranchController::class, 'statusUpdate']);
    });
   
    
    Route::group(['prefix' => 'stock'], function ($router) {
        Route::get('get-data', [StockController::class, 'getData']);
        Route::post('store', [StockController::class, 'store']);
        Route::post('edit/{id}', [StockController::class, 'edit']);
        Route::post('update/{id}', [StockController::class, 'update']);
        Route::post('delete/{id}', [StockController::class, 'delete']);
        Route::post('status-update', [StockController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'purchase-order'], function ($router) {
        Route::get('get-data', [PurchaseOrderController::class, 'getData']);
        Route::post('store', [PurchaseOrderController::class, 'store']);
        Route::post('edit/{id}', [PurchaseOrderController::class, 'edit']);
        Route::post('update/{id}', [PurchaseOrderController::class, 'update']);
        Route::post('delete/{id}', [PurchaseOrderController::class, 'delete']);
        Route::post('status-update', [PurchaseOrderController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'purchase-inward'], function ($router) {
        Route::get('get-data', [PurchaseInwardLogController::class, 'getData']);
        Route::post('store', [PurchaseInwardLogController::class, 'store']);
        Route::post('edit/{id}', [PurchaseInwardLogController::class, 'edit']);
        Route::post('update/{id}', [PurchaseInwardLogController::class, 'update']);
        Route::post('delete/{id}', [PurchaseInwardLogController::class, 'delete']);
        Route::post('status-update', [PurchaseInwardLogController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'purchase-material'], function ($router) {
        Route::get('get-data', [PurchaseMaterialController::class, 'getData']);
        Route::post('store', [PurchaseMaterialController::class, 'store']);
        Route::post('edit/{id}', [PurchaseMaterialController::class, 'edit']);
        Route::post('update/{id}', [PurchaseMaterialController::class, 'update']);
        Route::post('delete/{id}', [PurchaseMaterialController::class, 'delete']);
        Route::post('status-update', [PurchaseMaterialController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'quotation-order'], function ($router) {
        Route::get('get-data', [QuotationOrderController::class, 'getData']);
        Route::post('store', [QuotationOrderController::class, 'store']);
        Route::post('edit/{id}', [QuotationOrderController::class, 'edit']);
        Route::post('update/{id}', [QuotationOrderController::class, 'update']);
        Route::post('delete/{id}', [QuotationOrderController::class, 'delete']);
        Route::post('status-update', [QuotationOrderController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'quotation-product'], function ($router) {
        Route::get('get-data', [QuotationProductController::class, 'getData']);
        Route::post('store', [QuotationProductController::class, 'store']);
        Route::post('edit/{id}', [QuotationProductController::class, 'edit']);
        Route::post('update/{id}', [QuotationProductController::class, 'update']);
        Route::post('delete/{id}', [QuotationProductController::class, 'delete']);
        Route::post('status-update', [QuotationProductController::class, 'statusUpdate']);
        Route::post('revise', [QuotationProductController::class, 'reviseQuotation']);
    });


    // Route::group(['prefix' => 'production-order'], function ($router) {
    //     Route::get('get-data', [ProductionOrderController::class, 'getData']);
    //     Route::post('store', [ProductionOrderController::class, 'store']);
    //     Route::post('edit/{id}', [ProductionOrderController::class, 'edit']);
    //     Route::post('update/{id}', [ProductionOrderController::class, 'update']);
    //     Route::post('delete/{id}', [ProductionOrderController::class, 'delete']);
    //     Route::post('status-update', [ProductionOrderController::class, 'statusUpdate']);
    // });
   

    Route::group(['prefix' => 'hand-tool'], function ($router) {
        Route::get('get-data', [HandToolController::class, 'getData']);
        Route::post('store', [HandToolController::class, 'store']);
        Route::post('edit/{id}', [HandToolController::class, 'edit']);
        Route::post('update/{id}', [HandToolController::class, 'update']);
        Route::post('delete/{id}', [HandToolController::class, 'delete']);
        Route::post('status-update', [HandToolController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'machine-operator'], function ($router) {
        Route::get('get-data', [MachineOperatorController::class, 'getData']);
        Route::post('store', [MachineOperatorController::class, 'store']);
        Route::post('edit/{id}', [MachineOperatorController::class, 'edit']);
        Route::post('update/{id}', [MachineOperatorController::class, 'update']);
        Route::post('delete/{id}', [MachineOperatorController::class, 'delete']);
        Route::post('status-update', [MachineOperatorController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'sales-return'], function ($router) {
        Route::get('get-data', [SalesReturnController::class, 'getData']);
        Route::post('store', [SalesReturnController::class, 'store']);
        Route::post('edit/{id}', [SalesReturnController::class, 'edit']);
        Route::post('update/{id}', [SalesReturnController::class, 'update']);
        Route::post('delete/{id}', [SalesReturnController::class, 'delete']);
        Route::post('status-update', [SalesReturnController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'maintenance-log'], function ($router) {
        Route::get('get-data', [MaintenanceLogController::class, 'getData']);
        Route::post('store', [MaintenanceLogController::class, 'store']);
        Route::post('edit/{id}', [MaintenanceLogController::class, 'edit']);
        Route::post('update/{id}', [MaintenanceLogController::class, 'update']);
        Route::post('delete/{id}', [MaintenanceLogController::class, 'delete']);
        Route::post('status-update', [MaintenanceLogController::class, 'statusUpdate']);
    });


    Route::group(['prefix' => 'tentative-item'], function ($router) {
        Route::get('get-data', [TentativeItemController::class, 'getData']);
        Route::post('store', [TentativeItemController::class, 'store']);
        Route::post('edit/{id}', [TentativeItemController::class, 'edit']);
        Route::post('update/{id}', [TentativeItemController::class, 'update']);
        Route::post('delete/{id}', [TentativeItemController::class, 'delete']);
        Route::post('status-update', [TentativeItemController::class, 'statusUpdate']);
    });

    

});
