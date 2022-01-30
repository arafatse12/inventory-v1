<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Product;
use App\Models\StockDetail;
use Illuminate\Http\Request;
use App\Repositories\SaleRepo;
use App\Repositories\StockRepo;
use App\Repositories\OfficeRepo;
use App\Repositories\ProductRepo;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StockRequest;
use App\Repositories\SaleDetailRepo;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StockDetailRepo;
use App\Repositories\StockTransferRepo;

class StockController extends Controller
{
    private $stockRepo, $productRepo, $stockDetailRepo, $officeRepo, $saleRepo, $saleDetailRepo, $stockTransferRepo;

    public function __construct(StockRepo $stockRepo, ProductRepo $productRepo , StockDetailRepo $stockDetailRepo, OfficeRepo $officeRepo, SaleRepo $saleRepo, SaleDetailRepo $saleDetailRepo, StockTransferRepo $stockTransferRepo)
    {
        $this->stockRepo = $stockRepo;
        $this->productRepo = $productRepo;
        $this->stockDetailRepo = $stockDetailRepo;
        $this->officeRepo = $officeRepo;
        $this->saleRepo = $saleRepo;
        $this->saleDetailRepo = $saleDetailRepo;
        $this->stockTransferRepo = $stockTransferRepo;

    }

    public function index(Request $request)
    {
        $stocks = $this->stockRepo->getByPaginate($request);
        return response()->json(returnData(2000, $stocks));
    }

    public function create()
    {
    }

    public function store(StockRequest $request)
    {
        $this->stockRepo->store($request);
        return response()->json(returnData(2000, null, 'New stock inserted successfully'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(StockRequest $request, $primaryKey)
    {
        $stock = $this->stockRepo->find($primaryKey);
        $this->stockRepo->requestByUpdate($request,$stock);
        return response()->json(returnData(2000, null, 'Stock updated successfully'));
    }

    public function destroy($primaryKey)
    {
        $this->stockRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Stock deleted successfully'));
    }

    public function getByProduct(Request $request)
    {
        $product = $this->productRepo->find($request->product_id);
        return response()->json($product);
    }

    public function getByProductByStock(Request $request)
    {
        $product =  $this->productRepo->findByStock($request->all());
        return response()->json($product);
    }

    public function getStock(){
        $product = $this->productRepo->getAllWithProduct();
        return response()->json($product);
    }

    public function createPDF() {
        $officeId = Auth::user()->office_id;
        $office = $this->officeRepo->find($officeId);
        $products =  $this->productRepo->getAllWithProduct();
        $collection=  collect($products);
        $stockIn = $collection->sum('stockIn');
        $stockOut = $collection->sum('stockOut');
        $soldQty = $this->saleRepo->soldQty();
        $pdf = PDF::loadView('stock', [
            'products' => $products,
            'office' => $office,
            'date' => now(),
            'stockIn' => $stockIn,
            'stockOut' => $stockOut,
            'soldQty' => $soldQty,
        ]);
        return $pdf->download('stock_report.pdf');
      }

      public function createProductTransferPdf() {
        $officeId = Auth::user()->office_id;
        $office = $this->officeRepo->find($officeId);
        $stockTransfer = $this->stockTransferRepo->createProductTransferPdf();
        $pdf = PDF::loadView('product-transfer', [
            'products' => $stockTransfer,
            'office' => $office,
            'date' => now(),
        ]);
        return $pdf->download('product-transfer.pdf');
      }


}
