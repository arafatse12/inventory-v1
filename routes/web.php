<?php

use App\Http\Controllers\PurchaseOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\PurchaseRequisitionController;
use App\Http\Controllers\UserController;

Route::get(
    '/',
    function () {
        return redirect('/login');
    }
);
Route::get('/home/{any}', [HomeController::class, 'index'])->where('any', '.*');
Route::get('/home', function () {
    return Redirect::to('/home/dashboard');
});

Auth::routes();

Route::middleware('auth')->group(
    function () {
        Route::resource('product-category', ProductCategoryController::class);
        Route::resource('brand', BrandController::class);
        Route::post('image-upload',[ImageUploadController::class, 'index']);
        Route::resource('office', OfficeController::class);
        Route::resource('supplier', SupplierController::class);
        Route::resource('customer', CustomerController::class);
        Route::resource('purchase-order', PurchaseOrderController::class);
        Route::post('stock/store', [PurchaseOrderController::class, 'addStock']);
        Route::resource('product', ProductController::class);
        Route::resource('stock', StockController::class);
        Route::resource('purchase-requisition', PurchaseRequisitionController::class);
        Route::get('purchase-requisition-approve', [PurchaseRequisitionController::class, 'approve'] );
        Route::post('general', [HelperController::class, 'index']);
        Route::get('get-by-product', [StockController::class, 'getByProduct']);
        Route::get('get-by-product-by-stock', [StockController::class, 'getByProductByStock']);
        Route::get('search-by-product', [ProductController::class, 'getSearchByProduct']);
        Route::resource('stock-transfer',StockTransferController::class);
        Route::resource('sale',SaleController::class);
        Route::get('sale-return', [SaleController::class, 'getSalesReturn']);
        Route::put('sales-return/{id}', [SaleController::class, 'salesReturnStore']);
        Route::get('physical-stock-report', [StockController::class, 'getStock']);
        Route::get('create-pdf', [StockController::class, 'createPDF']);
        Route::get('product-transfer-report', [ProductController::class, 'getProductTransfer']);
        Route::get('create-product-transfer-pdf', [StockController::class, 'createProductTransferPdf']);
        Route::get('sales-report', [SaleController::class, 'salesReport']);
        Route::get('create-sales-report-pdf', [SaleController::class, 'salesPdf']);
        
        Route::resource('user', UserController::class);
        Route::get('print-invoice', [SaleController::class, 'printInvoice']);
        Route::get('stock-transfer-approve', [StockTransferController::class, 'approve']);
        Route::get('get-by-sale-id-details', [SaleController::class, 'getBySaleIdDetails']);

        
    }
);



