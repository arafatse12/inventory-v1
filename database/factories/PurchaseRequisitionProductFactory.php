<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseRequisitionProductFactory extends Factory
{
    protected $model = PurchaseRequisitionProduct::class;

    public function definition()
    {
        $purchaseRequisitions = PurchaseRequisition::pluck('id');
        $product = Product::pluck('id');
        return [
            'purchase_requisition_id' => $this->faker->randomElement($purchaseRequisitions),
            'product_id' => $this->faker->randomElement($product),
            'quantity' => rand(10,100),
            'amount' => rand(50,1000),
        ];
    }
}
