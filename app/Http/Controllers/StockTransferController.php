<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StockTransferRepo;
use App\Http\Requests\StockTransferRequest;

class StockTransferController extends Controller
{
    private $stockTransferRepo;

    public function __construct(StockTransferRepo $stockTransferRepo)
    {
        $this->stockTransferRepo = $stockTransferRepo;
    }

    public function index(Request $request)
    {
        $stockTransfer = $this->stockTransferRepo->getByPaginate($request);
        return response()->json(returnData(2000, $stockTransfer));
    }

    public function create()
    {
    }

    public function store(StockTransferRequest $request)
    {
        $this->stockTransferRepo->store($request);
        return response()->json(returnData(2000, null, 'New stock transfer inserted successfully'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(StockTransferRequest $request, $primaryKey)
    {
        $stock = $this->stockTransferRepo->find($primaryKey);
        $this->stockTransferRepo->requestByUpdate($request,$stock);
        return response()->json(returnData(2000, null, 'Stock transfer updated successfully'));
    }

    public function destroy($primaryKey)
    {
        $this->stockTransferRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Stock transfer deleted successfully'));
    }

    public function approve(Request $request)
    {
        $this->stockTransferRepo->approve($request);
        return response()->json(returnData(2000, null, 'Stock transfer approved successfully'));
    }

    public function createProductTransferPdf() {
        $officeId = Auth::user()->office_id;
        $stockTransfer = $this->stockTransferRepo->transferDetails();

        $officeId = Auth::user()->office_id;
        $office = $this->officeRepo->find($officeId);
        $products = StockDetail::whereIn('stock_id', $stockTransfer)
        ->select('stock_id','product_id',DB::raw("COALESCE(SUM(quantity),0) as totalQty"))
        ->groupBy('product_id')
        ->orderBy('stock_id')
        ->get();
        $collection=  collect($products);
        $stockIn = $collection->sum('stockIn');
        $stockOut = $collection->sum('stockOut');
        $soldQty = $this->saleRepo->soldQty();
        $pdf = PDF::loadView('product-transfer', [
            'products' => $products,
            'office' => $office,
            'date' => now(),
            'stockIn' => $stockIn,
            'stockOut' => $stockOut,
            'soldQty' => $soldQty,
        ]);
        return $pdf->download('product-transfer.pdf');
      }
}
