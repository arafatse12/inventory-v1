<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\PurchaseRequisitionRequest;
use App\Repositories\PurchaseRequisitionProductRepo;

class PurchaseRequisitionRepo extends Repository
{
    /**
     * @inheritDoc
     */

    private $purchaseRequisitionProductRepo;

    public function __construct(PurchaseRequisitionProductRepo $purchaseRequisitionProductRepo)
    {
        $this->purchaseRequisitionProductRepo = $purchaseRequisitionProductRepo;
    }

    public function model()
    {
        return PurchaseRequisition::class;
    }

    public function getByPaginate($request) : LengthAwarePaginator
    {
        $pagination = $request->per_page ?? 20;
        $filter = $request->keyword;
        return  $this->query()->with('office','purchaseRequisitions')->when($filter,function (Builder $product) use ($filter) {
                return $product->where('remark', 'like', "%$filter%");
            }
        )
        ->orderBy(sortBy($request)->column, sortBy($request)->sort)
        ->paginate($pagination);
    }

    public function store(PurchaseRequisitionRequest $request)
    {
        $user = Auth::user();
        $purchaseRequisition = [
            'remark' =>$request->remark,
            'status' => 'Pending',
            'date' => $request->date,
            'office_id' => $user->office_id,
        ];
        $purchaseRequisition = $this->create($purchaseRequisition);
        $purchaseRequisitionProducts = [];
        foreach($request->products as $product){
            $purchaseRequisitionProducts[] = [
                'purchase_requisition_id' => $purchaseRequisition->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],                                             
                'amount' => $product['amount'],
                'created_at' => now(),                                            
            ];
        } 
        $this->purchaseRequisitionProductRepo->bulkInsert($purchaseRequisitionProducts);  
    }

    public function requestByUpdate(PurchaseRequisitionRequest $request, $purchaseRequisition)
    {
        $this->purchaseRequisitionProductRepo->deleteByPurchaseRequisition($purchaseRequisition->id);
        $this->update($purchaseRequisition, $request->all());
        $purchaseRequisitionProducts = [];
        foreach($request->products as $product){
            $purchaseRequisitionProducts[] = [
                'purchase_requisition_id' => $purchaseRequisition->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],                                             
                'amount' => $product['amount'],  
            ];
        }
        $this->purchaseRequisitionProductRepo->bulkInsert($purchaseRequisitionProducts);

    }

    public function approve($request)
    {
        $approveData = [
            'status' => "Approved",
        ];
        $purchaseRequisition = $this->find($request->purchase_requisition_id);
      
        $purchaseRequisition->update($approveData);

    }

}
