<?php

namespace App\Repositories;

use App\Models\PurchaseOrderDetails;
use App\Repositories\Repository;
use Illuminate\Database\Query\Builder;

class PurchaseOrderDetailsRepo extends Repository
{

    public function model()
    {
        return PurchaseOrderDetails::class;
    }

    public function store($product, $purchaseOrder)
    {
        $this->create([
            'purchase_order_id' => $purchaseOrder->id,
            'product_id' => $product['product_id'],
            'quantity' => $product['quantity'],
            'amount' => $purchaseOrder->total_amount,
        ]);
    }
}
?>
