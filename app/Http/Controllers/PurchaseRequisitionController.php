<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PurchaseRequisitionRepo;
use App\Http\Requests\PurchaseRequisitionRequest;

class PurchaseRequisitionController extends Controller
{
    private $purchaseRequisitionRepo;

    public function __construct(PurchaseRequisitionRepo $purchaseRequisitionRepo)
    {
        $this->purchaseRequisitionRepo = $purchaseRequisitionRepo;
    }

    public function index(Request $request)
    {
        $purchaseRequisitions = $this->purchaseRequisitionRepo->getByPaginate($request);
        return response()->json(returnData(2000, $purchaseRequisitions));
    }

    public function store(PurchaseRequisitionRequest $request)
    {
        $this->purchaseRequisitionRepo->store($request);
        return response()->json(returnData(2000, null, 'New purchase requisition inserted successfully'));
    }

    public function update(PurchaseRequisitionRequest $request, $primaryKey)
    {
        $purchaseRequisition = $this->purchaseRequisitionRepo->find($primaryKey);
        $this->purchaseRequisitionRepo->requestByUpdate($request, $purchaseRequisition);
        return response()->json(returnData(2000, null, 'Purchase requisition updated successfully'));
    }

    public function destroy($primaryKey)
    {
        $this->purchaseRequisitionRepo->delete($primaryKey);
        return response()->json(returnData(2000, null, 'Purchase requisition deleted successfully'));
    }

    public function approve(Request $request)
    {
        $this->purchaseRequisitionRepo->approve($request);
        return response()->json(returnData(2000, null, 'Stock transfer approved successfully'));
    }
    
}
