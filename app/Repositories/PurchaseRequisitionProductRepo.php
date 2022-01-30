<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\PurchaseRequisitionProduct;

class PurchaseRequisitionProductRepo extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return PurchaseRequisitionProduct::class;
    }

    public function findByAll($purchaseRequisitionId)
    {
        return  $this->model()::where('purchase_requisition_id', $purchaseRequisitionId)->get();
    }

    public function deleteByPurchaseRequisition($purchaseRequisitionId)
    {
        return  $this->model()::where('purchase_requisition_id', $purchaseRequisitionId)->delete();
    }

    public function bulkInsert($array)
    {
        return  $this->model()::insert($array);
    }

}
