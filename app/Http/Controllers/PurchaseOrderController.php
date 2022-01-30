<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Requests\StockRequest;
use App\Repositories\PurchaseOrderRepo;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    private $purchaseOrderRepo;

    public function __construct(PurchaseOrderRepo $purchaseOrderRepo)
    {
        $this->purchaseOrderRepo = $purchaseOrderRepo;
    }

    public function index(Request $request)
    {
        $purchaseOrders = $this->purchaseOrderRepo->getByPaginate($request);
        return response()->json(returnData(2000, $purchaseOrders));
    }

    public function store(PurchaseOrderRequest $request)
    {
        $this->purchaseOrderRepo->store($request->all());
        return response()->json(returnData(2000, null, 'Successfully purchase order inserted'));
    }

    public function addStock(StockRequest $request)
    {
        $this->purchaseOrderRepo->storeStock($request->all());
        return response()->json(returnData(2000, null, 'Successfully stock inserted'));
    }

    public function update(PurchaseOrderRequest $request, $primaryKey)
    {
        $purchaseOrder = $this->purchaseOrderRepo->find($primaryKey);

        if ($purchaseOrder) {
            $this->purchaseOrderRepo->store($request->all());
            $this->purchaseOrderRepo->delete($primaryKey);
        }

        return response()->json(returnData(2000, $purchaseOrder, 'Successfully purchase order updated'));
    }

    public function destroy($primaryKey)
    {
        $this->purchaseOrderRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Successfully purchase order deleted'));
    }
}
